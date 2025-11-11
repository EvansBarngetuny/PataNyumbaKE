<?php

namespace App\Http\Livewire\Landlord;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BookedProperties extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = '';

    public $selectedBooking = null;

    public $showDetailsModal = false;

    public $landlordNotes = '';

    protected $queryString = ['search', 'statusFilter'];

    public function showDetails($id)
    {
        $this->selectedBooking = Booking::with(['listing', 'user'])
            ->whereHas('listing', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        $this->landlordNotes = $this->selectedBooking->landlord_notes;
        //$this->showDetailsModal = true;

        $this->dispatchBrowserEvent('show-details-modal');
    }

      public function updateStatus($id, $status)
      {
          $booking = Booking::with('listing')
              ->whereHas('listing', function ($query) {
                  $query->where('user_id', Auth::id());
              })
              ->findOrFail($id);

          $booking->update(['status' => $status]);

          // If confirmed, update listing status to booked
          if ($status === 'confirmed') {
              $booking->listing->update(['status' => 'Booked']);
          }

          // If cancelled or completed, update listing status back to vacant
          if (in_array($status, ['cancelled', 'completed'])) {
              $booking->listing->update(['status' => 'vacant']);
          }

          session()->flash('message', 'Booking status updated successfully.');
      }

     public function saveLandlordNotes()
     {
         if ($this->selectedBooking) {
             $this->selectedBooking->update(['landlord_notes' => $this->landlordNotes]);
             session()->flash('message', 'Notes updated successfully.');
         }
     }

    public function render()
    {
        $bookings = Booking::with(['listing', 'user'])
            ->whereHas('listing', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('full_name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhere('phone', 'like', '%'.$this->search.'%')
                      ->orWhereHas('listing', function ($q2) {
                          $q2->where('title', 'like', '%'.$this->search.'%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.landlord.booked-properties',
            [
                'bookings' => $bookings,
            ]);
    }
}

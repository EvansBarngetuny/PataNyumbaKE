<?php

namespace App\Http\Livewire\Landlord;

use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyProperties extends Component
{
    use WithPagination;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedListing = null;
    public $showDeleteModal = false;
     public $showEditModal = false;
     public $statusFilter = '';
    protected $queryString = ['search', 'sortField', 'sortDirection','statusFilter'];
   //edit Properties
   public $editTitle;
    public $editCategory;
    public $editPrice;
    public $editStatus;
    public $editCounty;
    public $editEstate;
    public $editLocation;
    public $editDescription;
    public $editVideoUrl;
    public $editIsVerified = false;
    public $newImages = [];
    public $existingImages = [];
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
      public function confirmDelete($id)
    {
        $this->selectedListing = Listing::findOrFail($id);
        $this->showDeleteModal = true;
        $this->dispatchBrowserEvent('showDeleteModal');
    }
    public function deleteListing()
    {
        if ($this->selectedListing) {
            // Delete associated images from storage
            $images = json_decode($this->selectedListing->images, true);
            foreach ($images as $image) {
                if (file_exists(storage_path('app/public/' . $image))) {
                    unlink(storage_path('app/public/' . $image));
                }
            }

            $this->selectedListing->delete();
            $this->showDeleteModal = false;
            $this->selectedListing = null;

            session()->flash('message', 'Listing deleted successfully.');
            $this->dispatchBrowserEvent('hideDeleteModal');
        }
    }
    public function editListing($id)
    {
        $this->selectedListing = Listing::where('user_id', Auth::id())->findOrFail($id);

        // Populate edit form fields
        $this->editTitle = $this->selectedListing->title;
        $this->editCategory = $this->selectedListing->category;
        $this->editPrice = $this->selectedListing->price;
        $this->editStatus = $this->selectedListing->status;
        $this->editCounty = $this->selectedListing->county;
        $this->editEstate = $this->selectedListing->estate;
        $this->editLocation = $this->selectedListing->location;
        $this->editDescription = $this->selectedListing->description;
        $this->editVideoUrl = $this->selectedListing->video_url;
        $this->editIsVerified = $this->selectedListing->is_verified;

        // Get existing images
        $this->existingImages = json_decode($this->selectedListing->images, true) ?? [];
        $this->newImages = [];

        $this->showEditModal = true;
        $this->dispatchBrowserEvent('showEditModal');
    }
     public function updateListing()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editCategory' => 'required|in:single,double,bedsitter,one-bedroom,two-bedroom',
            'editPrice' => 'required|numeric|min:0',
            'editStatus' => 'required|in:vacant,Booked,occupied',
            'editCounty' => 'required|string|max:255',
            'editEstate' => 'required|string|max:255',
            'editLocation' => 'required|string|max:255',
            'editDescription' => 'required|string|min:10',
            'editVideoUrl' => 'nullable|url',
            'newImages.*' => 'nullable|image|max:5120',
            'editIsVerified' => 'boolean'
        ]);

        try {
            // Handle new image uploads
            $uploadedImages = $this->existingImages;

            foreach ($this->newImages as $image) {
                $path = $image->store('listings', 'public');
                $uploadedImages[] = str_replace('public/', '', $path);
            }

            // Update the listing
            $this->selectedListing->update([
                'title' => $this->editTitle,
                'category' => $this->editCategory,
                'price' => $this->editPrice,
                'status' => $this->editStatus,
                'county' => $this->editCounty,
                'estate' => $this->editEstate,
                'location' => $this->editLocation,
                'description' => $this->editDescription,
                'video_url' => $this->editVideoUrl,
                'images' => json_encode($uploadedImages),
                'is_verified' => $this->editIsVerified,
            ]);

            $this->showEditModal = false;
            $this->selectedListing = null;
            $this->newImages = [];
            $this->existingImages = [];

            session()->flash('message', 'Listing updated successfully.');
            $this->dispatchBrowserEvent('hideEditModal');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating listing: ' . $e->getMessage());
        }
    }
       public function removeExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            // Delete the image file from storage
            $imagePath = storage_path('app/public/' . $this->existingImages[$index]);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);
        }
    }
     public function removeNewImage($index)
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);
            $this->newImages = array_values($this->newImages);
        }
    }
      public function markAsOccupied($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->update(['status' => 'occupied']);

        session()->flash('message', 'Listing marked as occupied.');
    }

    public function markAsBooked($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->update(['status' => 'Booked']);

        session()->flash('message', 'Listing marked as booked.');
    }
    public function render()
    {
        $listings = Listing::with('user')
            ->where('user_id', Auth::id())
            ->where('status', 'vacant')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%')
                        ->orWhere('county', 'like', '%' . $this->search . '%')
                        ->orWhere('estate', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        return view('livewire.landlord.my-properties', [
            'listings' => $listings,
        ]);
    }
}

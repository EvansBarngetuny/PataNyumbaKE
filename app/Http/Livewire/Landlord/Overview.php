<?php

namespace App\Http\Livewire\Landlord;

use App\Models\Listing;
use App\Models\User;
use App\Models\Payment;
use App\Models\Activity;
use Livewire\Component;

class Overview extends Component
{
    public $activeListings;
    public $occupiedUnits;
    public $pendingRent;
    public $totalRevenue;
    public $recentActivities;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Get the authenticated landlord's ID
        $landlordId = auth()->id();

        // Count active listings for this landlord
        $this->activeListings = Listing::where('user_id', $landlordId)->count();

        // Count occupied units (listings with status 'occupied')
        $this->occupiedUnits = Listing::where('user_id', $landlordId)
            ->where('status', 'occupied')
            ->count();

        // Count pending rent payments (payments with pending status)
        $this->pendingRent = Payment::where('user_id', $landlordId)
            ->where('status', 'pending')
            ->count();

        // Calculate total revenue from payments
        $this->totalRevenue = Payment::where('user_id', $landlordId)
            ->where('status', 'completed')
            ->sum('ammount');

        // Get recent activities
        $this->recentActivities = Activity::where('user_id', $landlordId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'action' => $this->getActionType($activity->type),
                    'details' => $activity->details,
                    'time' => $activity->time_ago
                ];
            })
            ->toArray();

        // If no activities yet, show sample data
        if (empty($this->recentActivities)) {
            $this->recentActivities = [
                ['action' => 'Welcome to PataNyumba', 'details' => 'Get started by adding your first property', 'time' => 'Just now']
            ];
        }
    }

    protected function getActionType($type)
    {
        $types = [
            'user_created' => 'User registered',
            'listing_created' => 'New listing created',
            'listing_updated' => 'Listing updated',
            'listing_deleted' => 'Listing deleted',
            'payment_created' => 'Payment received',
            'payment_updated' => 'Payment updated',
            'payment_deleted' => 'Payment deleted',
        ];

        return $types[$type] ?? ucfirst(str_replace('_', ' ', $type));
    }

    public function render()
    {
        return view('livewire.landlord.overview');
    }
}

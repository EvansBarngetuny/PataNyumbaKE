<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Listing;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalListings = Listing::count();
        $totalLandlords = User::where('role', 'landlord')->count();
        $verifiedListings = Listing::where('is_verified', true)->count();
        $totalInquiries = Inquiry::count();
        $mostPopularLocation = Listing::select('location')
            ->groupBy('location')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->pluck('location')
            ->first() ?? 'No inquiries yet';
        //Get recent rent payments for the chart
        $chartData = [
         'label' => Payment::orderBy('created_at')->pluck('created_at')->map(fn ($date) => $date ? $date->format('Y-m-d'): null)->filter()->toArray(),
         'data' => Payment::orderBy('created_at')->pluck('ammount')->toArray(),
        ];
        //dd($chartData);
        return view('dashboard.dashboard', [
            'user' => (object) [
                'total_user' => $totalUsers,
                'total_landlord' => $totalLandlords,
                'total_listing' => $totalListings,
                'verified_listing' => $verifiedListings,
                'total_inquiry' => $totalInquiries,
                'most_popular_location' => $mostPopularLocation,
            ],
            'chartData' => $chartData,
        ]);

    }
}

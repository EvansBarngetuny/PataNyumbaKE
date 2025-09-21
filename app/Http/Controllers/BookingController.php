<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'move_in_date' => 'nullable|date',
            'message' => 'nullable|string',
        ]);
        $listing = Listing::findOrFail($validated['listing_id']);
        if ($listing->status !== 'vacant'){
            return redirect()->back()->with('error','This property is not available for booking.');
        }
        //create booking
        $booking = Booking::create([
            'listing_id' => $validated['listing_id'],
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'move_in_date' => $validated['move_in_date'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);
        return redirect()->back()->with('success', 'Booking request submitted successfully! The landlord will contact you soon.');
    }
}

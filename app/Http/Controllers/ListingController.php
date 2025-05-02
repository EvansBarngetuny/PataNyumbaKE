<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index()
    {
        // $listings = Listing::with('user')
        // ->where('status', 'vacant')
        // ->latest()
        // ->paginate(12);
        $listings = Listing::with('user')
        ->latest()
        ->paginate(12);

        return view('listings.index', compact('listings'));
        //  $listings = Listing::latest()->paginate(10);

        // return view('layouts.allListings', compact('listings'));
    }

    public function search(Request $request)
    {
        $query = Listing::with('user')->where('status', 'vacant');

        if ($request->county) {
            $query->where('county', $request->county);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $listings = $query->latest()->paginate(12);
        $counties = kenyanCounties();

        return view('listings.search', compact('listings', 'counties'));
    }

    public function create()
    {
        return view('layouts.createListing');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:single,double,bedsitter,one-bedroom,two-bedroom',
            'description' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric|min:0',
            'county' => 'required|string|max:255',
            'estate' => 'required|string|max:255',
            'status' => 'required|in:vacant,Booked,occupied',
            'video_url' => 'nullable| url',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_verified' => 'nullable|boolean',
        ]);
        $imagePath = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('listings', 'public');
            $imagePath[] = str_replace('public/', '', $path);
        }
        Listing::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'price' => $validated['price'],
            'county' => $validated['county'],
            'estate' => $validated['estate'],
            'status' => $validated['status'],
            'video_url' => $validated['video_url'] ?? null,
            'images' => json_encode($imagePath),
            'is_verified' => $validated['is_verified'] ?? null,
        ]);

        return redirect()->route('layouts.allListings')->with('success', 'Listing created successfully');
    }

    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }
}

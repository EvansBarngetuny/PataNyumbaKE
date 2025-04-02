<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::latest()->paginate(10);
        return view('layouts.allListings', compact('listings'));
    }
    public function create()
    {
        return view('layouts.roomListing');
    }
    public function store( Request $request) {
        $request->validate([
            'title' => 'required| string| max:255',
            'category' => 'required| in:single, double, bedsitter, one-bedroom, two-bedroom',
            'description' => 'required| string',
            'location' => 'required| string',
            'price' => 'required| numeric| min:0',
            'county' => 'required| string| max:255',
            'estate' => 'required| string| max:255',
            'video_url' => 'nullable| url',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imagePath = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $imagePath[] = $path;
            }
        }
         Listing::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
            'county' => $request->county,
            'estate' => $request->estate,
            'video_url' => $request->video_url,
            'images' => json_encode($imagePath),

         ]);
         return redirect()->route('layouts.listing')->with('success', 'Listing created successfully');
    }
    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }
}

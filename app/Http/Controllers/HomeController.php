<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get all the 47 Kenya counties
        $counties = kenyanCounties();
        $featuredListings = Listing::with('user')
            ->where('is_verified', true)
            ->where('status', 'vacant')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        $newListings = Listing::with('user')
            ->where('status', 'vacant')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        $popularCounties = Listing::select('county as name')
        ->selectRaw('count(*) as listings_count')
        ->groupBy('county')
        ->orderBy('listings_count', 'desc')
        ->take(6)
        ->get();

        return view('home', compact('featuredListings', 'newListings', 'popularCounties', 'counties'));
    }
    // return view('dashboard.dashboard');
}

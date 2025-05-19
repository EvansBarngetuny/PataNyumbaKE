<?php

namespace App\Http\Controllers;

class LandlordDashboardController extends Controller
{
    public function index()
    {
        return view('landloard.dashboard');
    }
}

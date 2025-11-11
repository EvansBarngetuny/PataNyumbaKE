<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class LandlordDashboardController extends Controller
{
    public function index()
    {
        $unreadCount = 0;
        if (Auth::check() && Auth::user()->user_type === 'landlord') {
            $unreadCount = Message::where('recipient_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }

        return view('landloard.dashboard', compact('unreadCount'));
    }
}

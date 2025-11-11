<?php

namespace App\Http\Controllers;

use App\Mail\PropertyInquiry;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'listing_id' => 'required|exists:listings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'content' => 'required|string',
        ]);
        $senderId = Auth::check() ? Auth::user()->id : null;

        $message = Message::create([
            'sender_id' => $senderId,
            'recipient_id' => $validated['recipient_id'],
            'listing_id' => $validated['listing_id'],
            'content' => $validated['content'],
            'sender_email' => $validated['email'],
            'sender_phone' => $validated['phone'],
            'is_successful' => true,
            'success_marked_at' => now(),
        ]);
        // Send email notification
        $recipient = \App\Models\User::find($validated['recipient_id']);
        $listing = \App\Models\Listing::find($validated['listing_id']);
        try {
            Mail::to($recipient->email)->send(new PropertyInquiry($message, $listing, $validated['name']));
        } catch (\Exception $e) {
            \Log::error('Email Sending failed'.$e->getMessage());
        }

          return redirect()->back()->with('success', 'Message sent successfully!');
    }
}

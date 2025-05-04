<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        // Get messages where user is either sender or recipient
        $messages = Message::with(['listing', 'sender', 'recipient'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('recipient_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $this->authorize('view', $message);

        // Mark as read if recipient is viewing
        if ($message->recipient_id === auth()->id() && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'listing_id' => 'required|exists:listings,id',
            'content' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'listing_id' => $validated['listing_id'],
            'content' => $validated['content'],
            'sender_email' => $validated['email'],
            'sender_phone' => $validated['phone'],
        ]);
        $message->recipient->notify(new NewMessageNotification($message));

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
        ]);
    }

    public function markSuccesscful(Message $message)
    {
        $message->update([
            'is_successful' => true,
            'success_marked_at' => now(),
        ]);

        return back()->with('success', 'Marked as successful match!');
    }
}

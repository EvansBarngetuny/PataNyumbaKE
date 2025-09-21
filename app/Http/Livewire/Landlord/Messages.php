<?php

namespace App\Http\Livewire\Landlord;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class Messages extends Component
{
    public $unreadCount = 0;
    public $messages;
    public $selectedMessage;

    public function mount(){
        $this->loadMessages();
    }
    public function loadMessages(){
        $this->messages = Message::where('recipient_id', Auth::id())
        ->with(['sender','listing','replies'])
        ->orderBy('created_at','desc')
        ->get()
        ->unique(function($message){
            return $message->sender_id .'-' . $message->listing_id . '-' . md5($message->content);
        });
        $this->unreadCount = Message::where('recipient_id', Auth::id())
        ->where('is_read', false)
        ->count();
    }
    public function selectMessage($messageId)
    {
        $this->selectedMessage = Message::with(['sender', 'listing', 'replies'])->find($messageId);

        if ($this->selectedMessage && !$this->selectedMessage->is_read)
        {
            $this->selectedMessage->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }
    public function markAsSuccessful($messageId)
    {
        $message = Message::find($messageId);
        if ($message) {
            $message->update([
                'is_successful' => true,
                'success_marked_at' => now()
            ]);
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.landlord.messages');
    }
}

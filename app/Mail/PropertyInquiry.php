<?php

namespace App\Mail;

use App\Models\Listing;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiryMessage;

    public $listing;

    public $senderName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message, Listing $listing, $senderName)
    {
        //
        $this->inquiryMessage = $message;
        $this->listing = $listing;
        $this->senderName = $senderName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Property Inquiry: '.$this->listing->title)
        ->view('emails.property-inquiry')
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->replyTo($this->inquiryMessage->sender_email, $this->senderName);
    }
}

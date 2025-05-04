<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
       ->subject('New Message About Your Property: '.$this->message->listing->title)
        ->greeting('Hello '.$notifiable->name)
        ->line('You have received a new message regarding your property at '.
              $this->message->listing->estate.', '.$this->message->listing->county)
        ->line('From: '.$this->message->sender->name.' ('.$this->message->sender_email.')')
        ->line('Phone: '.$this->message->sender_phone)
        ->line('Message: "'.$this->message->content.'"')
        ->action('View Listing', url('/listings/'.$this->message->listing_id))
        ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}

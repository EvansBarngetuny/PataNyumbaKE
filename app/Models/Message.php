<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $dates = ['read_at'];

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'listing_id',
        'content',
        'is_read',
        'is_successful',
        'parent_id',
        'sender_email', // Add this
        'sender_phone',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

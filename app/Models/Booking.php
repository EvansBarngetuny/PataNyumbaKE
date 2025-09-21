<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'message',
        'status',
        'move_in_date',
        'landlord_notes',
    ];
    protected $casts = [
        'move_in_date' => 'date',
    ];
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

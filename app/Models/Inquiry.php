<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'listing_id',
        'user_id',
        'message',
        'contact_method',
        'status',
        'created_at',
        'updated_at',
    ];
}

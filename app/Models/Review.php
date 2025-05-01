<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'listing_id',
        'rating',
        'comment',
        'created_at',
        'updated_at'
    ];
}

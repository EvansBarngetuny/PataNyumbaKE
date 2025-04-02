<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'category',
        'description',
        'price',
        'location',
        'county',
        'estate',
        'image',
        'video_url',
        'is_verified',
        'created_at',
        'updated_at',
    ];
}

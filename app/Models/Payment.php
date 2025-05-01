<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'listing_id',
        'ammount',
        'payment_method',
        'transaction_id',
        'status',
        'created_at',
        'updated_at',

    ];
}

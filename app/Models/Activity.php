<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

      public static function log($type, $description, $metadata = [])
      {
          return self::create([
              'user_id' => auth()->id(),
              'type' => $type,
              'description' => $description,
              'metadata' => $metadata,
          ]);
      }
}

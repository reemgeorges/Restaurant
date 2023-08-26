<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'star',
        'comment',
        'restaurant_id',
        'user_id',
    ];

    protected $casts = [
        'uuid' => 'string',
        'star' => 'integer',
        'comment' => 'string',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

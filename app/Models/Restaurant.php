<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'cuisine_type',
        'address',
        'contact',
    ];

    protected $casts = [
        'uuid'    => 'string',
        'contact' => 'json',
        'name'    => 'string' ,
        'cuisine_type' => 'string',
        'address' => 'string',
        'contact' => 'string',

    ];


    protected $appends = ['average-review'];



    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Define an accessor to calculate the 'average_reviews' attribute for the restaurant.
    public function getAverageReviewsAttribute()
    {
        // Calculate the average star rating for this restaurant.
        $totalReviews = $this->reviews->count();
        if ($totalReviews === 0) {
            return 0; // Avoid division by zero.
        }

        $sumRatings = $this->reviews->sum('star');
        return $sumRatings / $totalReviews;
    }

}

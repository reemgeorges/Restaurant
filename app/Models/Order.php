<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'status', // Order status (boolean: 0 for undelivered, 1 for delivered).
    ];

    // protected $fillablePivot = [
    //     'quantity',  // Quantity of each menu item in the order.
    // ];

    protected $casts = [
        'uuid' => 'string',
        'status' => 'boolean',
    ];

    protected $appends = ['total'];

     // Define a relationship to the 'User' model
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function menuOrders()
    {
        return $this->hasMany(MenuOrder::class);
    }

    // Define an accessor to calculate the 'total' attribute for the order.
    public function getTotalAttribute()
    {
        return $this->menuOrders->sum(function ($menuOrders) {
            return $menuOrders->menu->price * $menuOrders->quantity;
        });
    }




}



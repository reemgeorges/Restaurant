<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus'; 

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'item_id',
        'price',
        'quantity'
    ];

    protected $casts = [
        'uuid' => 'string',
        'price' => 'double',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menuOrders()
    {
        return $this->hasMany(MenuOrder::class);
    }
}

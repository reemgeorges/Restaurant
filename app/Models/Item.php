<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table='items';
    protected $fillable = [
        'uuid',
        'name',       // The name of the food item
        'desc',       // Description of the food item
        'attachment', // Attachment or materials related to the food item
    ];

    protected $casts = [
        'uuid'      => 'string', // Cast 'uuid' to string
        'name'      => 'string',
        'desc'      => 'string',
        'attachment'=> 'string'
    ];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function menus(){
        return $this->hasMany(Menu::class);
    }


}

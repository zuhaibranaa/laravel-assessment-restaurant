<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}

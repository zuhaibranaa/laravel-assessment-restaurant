<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['menu_id', 'item_name', 'image', 'price'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

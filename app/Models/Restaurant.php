<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    protected $fillable = [
        'name',
        'location',
        'owner_id'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }

    // If using a shared menu
    public function sharedMenu()
    {
        return $this->belongsTo(Menu::class, 'shared_menu_id');
    }
}

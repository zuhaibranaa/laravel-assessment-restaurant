<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;

use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function all()
    {
        $menus = Menu::with(['items','restaurant.owner'])
            ->get();
//            ->map(function ($restaurant) {
//                return [
//                    'id' => $restaurant->id,
//                    'name' => $restaurant->name,
//                    'owner' => $restaurant->owner,
//                    'location' => $restaurant->location,
//                    'is_using_shared_menu' => !is_null($restaurant->shared_menu_id),
//                    'menu_source_name' => $restaurant->sharedMenu?->name ?? $restaurant->menu?->name,
//                    'menu_id' => $restaurant->shared_menu_id ?? $restaurant->menu?->id,
//                ];
//            });

        return Inertia::render('SuperAdmin/Menu', [
            'menus' => $menus
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $menu = Menu::create([
            'name' => $request->name,
            'restaurant_id' => $request->restaurant_id,
        ]);
        return redirect()->route('super_admin.menu')->with(['message' => 'Menu Created Successfully']);
    }
    public function create(){
        $restaurants = Restaurant::all();
        return Inertia::render('SuperAdmin/CreateRestaurant', compact('restaurants'));
    }
}

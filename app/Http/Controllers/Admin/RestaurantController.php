<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function showRestaurant(Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== Auth::id()) {
            abort(403);
        }

        $menus = Menu::with('restaurant', 'items')
            ->where('restaurant_id', '!=', $restaurant->id) // other menus for sharing
            ->get();

        $restaurant->load('menus', 'sharedMenu', 'owner');

        return Inertia::render('Admin/Restaurant', [
            'restaurant' => $restaurant,
            'menus' => $menus,
        ]);
    }

    public function createRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'owner_id' => 'required|exists:users,id',
        ]);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'location' => $request->location,
            'owner_id' => $request->owner_id,
        ]);

        return response()->json(['restaurant' => $restaurant], 201);
    }
}

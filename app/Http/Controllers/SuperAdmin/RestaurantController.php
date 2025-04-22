<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function all()
    {
        $restaurants = Restaurant::with(['owner','menu', 'sharedMenu'])
            ->get()
            ->map(function ($restaurant) {
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'owner' => $restaurant->owner,
                    'location' => $restaurant->location,
                    'is_using_shared_menu' => !is_null($restaurant->shared_menu_id),
                    'menu_source_name' => $restaurant->sharedMenu?->name ?? $restaurant->menu?->name,
                    'menu_id' => $restaurant->shared_menu_id ?? $restaurant->menu?->id,
                ];
            });

        return Inertia::render('SuperAdmin/Restaurant', [
            'restaurants' => $restaurants
        ]);
    }

    public function store(Request $request){
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
        return redirect()->route('super_admin.restaurant')->with(['message' => 'Restaurant Created Successfully']);
    }
    public function create(){
        $users = User::where('role', 'admin')->get();
        return Inertia::render('SuperAdmin/CreateRestaurant', compact('users'));
    }
}

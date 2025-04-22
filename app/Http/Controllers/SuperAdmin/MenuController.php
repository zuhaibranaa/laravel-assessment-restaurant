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
        $menus = Menu::with(['items','restaurant.owner', 'restaurant.sharedMenu'])
            ->get();

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
        return Inertia::render('SuperAdmin/CreateMenu', compact('restaurants'));
    }



    public function show(int $id)
    {
        $menu = Menu::with('items')->findOrFail($id);
        $restaurants = Restaurant::all();

        return Inertia::render('SuperAdmin/ShowMenu', [
            'menu' => $menu,
            'restaurants' => $restaurants,
        ]);
    }

    public function addItem(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $menu = Menu::findOrFail($id);

        $menu->items()->create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('message', 'Menu item added successfully.');
    }

    public function share(Request $request, int $id)
    {
        $request->validate([
            'restaurant_ids' => 'required|array',
            'restaurant_ids.*' => 'exists:restaurants,id',
        ]);

        $menu = Menu::findOrFail($id);
        Restaurant::whereIn('id', $request->restaurant_ids)->update(['shared_menu_id', $menu->id]);

        return redirect()->back()->with('message', 'Menu shared successfully.');
    }
}

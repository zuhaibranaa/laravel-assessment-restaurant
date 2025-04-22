<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $menu = Menu::with(['items', 'restaurant'])->findOrFail($id);

        return Inertia::render('SuperAdmin/ViewMenu', [
            'menu' => $menu
        ]);
    }

    public function showAddMenuItemForm($id)
    {
        return Inertia::render('SuperAdmin/AddMenuItem', compact('id'));
    }

    public function addItem(Request $request, int $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = Storage::disk('public')->put('menu_items', $image);
        }

        $menu->items()->create([
            'item_name' => $request->item_name,
            'price' => $request->price,
            'image' => $imagePath ?? 'default.png', // fallback or default image
        ]);

        return redirect()->back()->with('message', 'Menu item added successfully.');
    }
    public function showShareForm($id)
    {
        $restaurants = Restaurant::all();
        return Inertia::render('SuperAdmin/ShareMenu', compact('id', 'restaurants'));
    }

    public function share(Request $request, int $id)
    {
        $request->validate([
            'restaurant_ids' => 'required|array',
            'restaurant_ids.*' => 'exists:restaurants,id',
        ]);

        $menu = Menu::findOrFail($id);
        Restaurant::whereIn('id', [1, 2, 3])->update([
            'shared_menu_id' => $id,
            'active' => true,
        ]);

        return redirect()->back()->with('message', 'Menu shared successfully.');
    }
}

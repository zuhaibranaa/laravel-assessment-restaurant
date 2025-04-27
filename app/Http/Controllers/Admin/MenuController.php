<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function all(){
        $restaurants = Restaurant::where('owner_id',Auth::id())->with('menu.items','owner')
            ->get();
        return Inertia::render('Admin/Restaurant', compact('restaurants'));
    }

    public function view(int $id)
    {
        $menu = Menu::with(['items', 'restaurant'])->findOrFail($id);

        return Inertia::render('Admin/ViewMenu', [
            'menu' => $menu
        ]);
    }

    public function showAddMenuItemForm($id)
    {
        return Inertia::render('Admin/AddMenuItem', compact('id'));
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
        return Inertia::render('Admin/ShareMenu', compact('id', 'restaurants'));
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
            'useSharedMenu' => true,
        ]);

        return redirect()->back()->with('message', 'Menu shared successfully.');
    }
    public function toggleShared(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:restaurants,id'
        ]);
        $restaurant = Restaurant::findOrFail($validated['id']);
        if($restaurant->useSharedMenu){
            $restaurant->shared_menu_id = null;
        }
        $restaurant->useSharedMenu = !$restaurant->useSharedMenu;
        $restaurant->update();
        return redirect()->back()->with('message', 'Toggle Done successfully.');
    }
}

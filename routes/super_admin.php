<?php

use App\Http\Controllers\SuperAdmin\{
    RestaurantController,
    MenuController,
    MenuItemController
};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('super_admin/')->middleware(['auth', 'verified', 'role:super_admin'])->name('super_admin.')->group(function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(RestaurantController::class)->group(function () {
        Route::get('restaurant', 'all')->name('restaurant');
        Route::post('restaurant', 'store');
        Route::get('restaurant/create', 'create')->name('restaurant.create');
    });

    Route::controller(MenuController::class)->group(function () {
        Route::get('menu', 'all')->name('menu');
        Route::post('menu', 'store');
        Route::get('menu/create', 'create')->name('menu.create');
    });

    Route::controller(MenuItemController::class)->group(function () {

    });

    Route::get('menu', function () {
        return Inertia::render('Menu');
    })->middleware(['auth', 'verified'])->name('menu');
});



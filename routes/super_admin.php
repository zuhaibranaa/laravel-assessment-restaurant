<?php

use App\Http\Controllers\SuperAdmin\{
    RestaurantController,
    MenuController
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
        Route::get('menu/{id}/view', 'view')->name('menu.view');
        Route::get('menu/{id}/add', 'showAdd')->name('menu.add');
        Route::post('menu/{id}/add', 'addItem');
        Route::get('menu/{id}/share', 'showShare')->name('menu.share');
        Route::post('menu/{id}/share', 'share');
    });
});



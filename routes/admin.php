<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\{RestaurantController};
Route::prefix('admin/')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function (){

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::controller(RestaurantController::class)->group(function(){
//        Route::get('restaurant', 'getRestaurants')->name('restaurant');
    });

    Route::get('menu', function () {
        return Inertia::render('Menu');
    })->middleware(['auth', 'verified'])->name('menu');
});



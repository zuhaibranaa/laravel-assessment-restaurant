<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\{MenuController};
Route::prefix('admin/')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function (){

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::controller(MenuController::class)->group(function () {
        Route::get('restaurant', 'all')->name('restaurant');
        Route::post('sharedToggle', 'toggleShared')->name('sharedToggle');
        Route::get('menu/{id}/view', 'view')->name('menu.view');
        Route::get('menu/{id}/add', 'showAddMenuItemForm')->name('menu.add');
        Route::post('menu/{id}/add', 'addItem');
        Route::get('menu/{id}/share', 'showShareForm')->name('menu.share');
        Route::post('menu/{id}/share', 'share');
    });
});



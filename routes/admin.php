<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\{MenuController};
Route::prefix('admin/')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function (){

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

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



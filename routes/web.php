<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ItemUnitController;
use App\Http\Controllers\ManagerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Resource routes (ทั่วไป)
Route::resource('items', ItemController::class);
Route::resource('item-types', ItemTypeController::class);
Route::resource('item-units', ItemUnitController::class);

// Manager Routes
Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/', [ManagerController::class, 'index'])->name('index');

    // Items CRUD
    Route::get('items/create', [ManagerController::class, 'createItem'])->name('items.create');
    Route::post('items', [ManagerController::class, 'storeItem'])->name('items.store');
    Route::get('items/{item}/edit', [ManagerController::class, 'editItem'])->name('items.edit');
    Route::put('items/{item}', [ManagerController::class, 'updateItem'])->name('items.update');
    Route::delete('items/{item}', [ManagerController::class, 'destroyItem'])->name('items.destroy');

    // Units CRUD
    Route::post('units', [ManagerController::class, 'storeUnit'])->name('units.store');
    Route::put('units/{unit}', [ManagerController::class, 'updateUnit'])->name('units.update');
    Route::delete('units/{unit}', [ManagerController::class, 'destroyUnit'])->name('units.destroy');

    // Types CRUD
    Route::post('types', [ManagerController::class, 'storeType'])->name('types.store');
    Route::put('types/{type}', [ManagerController::class, 'updateType'])->name('types.update');
    Route::delete('types/{type}', [ManagerController::class, 'destroyType'])->name('types.destroy');

    // AJAX search items
    Route::get('items/search', [ManagerController::class, 'searchItems'])->name('items.search');
});

require __DIR__ . '/auth.php';

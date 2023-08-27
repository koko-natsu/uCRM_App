<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    route::get('/items', [ItemController::class, 'index'])->name('items.index');
    route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
});

require __DIR__.'/auth.php';

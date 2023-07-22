<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RetrieveItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    Route::post('/items', [ItemController::class, 'store']);
    Route::patch('/items/{item_id}', [ItemController::class, 'update']);
    Route::delete('/items/{item_id}', [ItemController::class, 'destroy']);
    Route::get('/items/{item_id}', [RetrieveItemController::class, 'retrieveItem']);

    Route::post('/customers', [CustomerController::class, 'store']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
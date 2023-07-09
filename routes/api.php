<?php

use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    Route::post('/items', [ItemController::class, 'store']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
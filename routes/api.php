<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RetrieveAddressController;
use App\Http\Controllers\RetrieveCustomerController;
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
    
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::patch('/customers/{customer_id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer_id}', [CustomerController::class, 'destroy']);
    
    Route::get('/items/{item_id}', [RetrieveItemController::class, 'retrieveItem']);
    Route::get('/customers/{customer_id}', [RetrieveCustomerController::class, 'retrieveCustomer']);
    Route::get('/retrieve-address/{postcode}', [RetrieveAddressController::class, 'retrieveAddress']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
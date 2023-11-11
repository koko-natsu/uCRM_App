<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RetrieveAddressController;
use App\Http\Controllers\RetrieveCustomerController;
use App\Http\Controllers\RetrieveItemController;
use App\Http\Controllers\RetrievePurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    Route::controller(ItemController::class)->group(function () {
        Route::post('/items', 'store');
        Route::patch('/items/{item_id}', 'update');
        Route::delete('/items/{item_id}', 'destroy');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::post('/customers', 'store');
        Route::patch('/customers/{customer_id}', 'update');
        Route::delete('/customers/{customer_id}', 'destroy');
    });

    Route::controller(PurchaseController::class)->group(function () {
        Route::post('/purchases', 'store');
        Route::patch('/purchases/{purchase_id}', 'update');
        Route::delete('/purchases/{purchase_id}', 'destroy');
    });
    
    Route::get('/items/{item_id}', [RetrieveItemController::class, 'retrieveItem']);

    Route::get('/customers/{customer_id}', [RetrieveCustomerController::class, 'retrieveCustomer']);

    Route::get('/retrieve-address/{postcode}', [RetrieveAddressController::class, 'retrieveAddress']);

    Route::get('/purchases/{purchase_id}', [RetrievePurchaseController::class, 'retrievePurchase']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
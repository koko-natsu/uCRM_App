<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use Illuminate\Http\Request;

class RetrievePurchaseController extends Controller
{

    public function retrievePurchase(Request $request)
    {
        $purchase = Purchase::findOrFail($request->purchase_id);

        return new PurchaseResource($purchase);
    }
}

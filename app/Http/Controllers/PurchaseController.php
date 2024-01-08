<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseCollection;
use App\Models\Order;
use App\Models\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{

    public function index()
    {
        return Inertia::render('Purchases/Index', [
            'purchases' => new PurchaseCollection(
                Purchase::obtainDataWithCalcSubtotal()
                )
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try
        {
            // TODO: Set up validation
            $data = $request->validate([
                'customer_id' => '',
                'status'      => '',
                'items'       => '',
            ]);
    
            $purchase = Purchase::create([
                'customer_id' => $data['customer_id'],
                'status'      => $data['status'],
            ]);

            foreach($request->items as $item)
            {
                $purchase->items()->attach($purchase->id, [
                    'item_id'  => $item['item_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();
        }
        catch(Exception $error)
        {
            DB::rollBack();
        }

        return new PurchaseCollection(
            Purchase::obtainDataWithCalcSubtotal()
        );
    }


    public function update(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);

        $data = $request->validate([
            'customer_id'      => 'required|integer',
            'status'           => 'required|boolean',
            'items.*.item_id'  => 'required|integer',
            'items.*.quantity' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            $purchase->customer_id = $data['customer_id'];
            $purchase->status      = $data['status'];
            $purchase->save();

            foreach($data['items'] as $item) {
                $purchase->items()->updateExistingPivot($item['item_id'], [
                    'quantity' => $item['quantity']
                ]);
            }

            DB::commit();

        } catch(\Exception $e) {
        }

        return new PurchaseCollection(
            Purchase::obtainDataWithCalcSubtotal()
        );
    }


    public function destroy(Request $request)
    {
        $purchase = Purchase::findOrFail($request->purchase_id);
        $purchase->delete();

        return new PurchaseCollection(
            Purchase::obtainDataWithCalcSubtotal()
        );
    }

}

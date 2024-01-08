<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relations
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_purchases', 'purchase_id', 'item_id')
            ->withPivot('quantity')
            ->as('receipt')
            ->withTimestamps();
    }


    // Functions
    protected static function obtainDataWithCalcSubtotal() :Collection
    {
        $data = Order::select(DB::raw('*, SUM(subtotal) as total'))
            ->groupBy('purchase_id')->get();

        return $data;
    }
}

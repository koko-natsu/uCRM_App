<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CommonQuery;

class Item extends Model
{
    use HasFactory;
    use CommonQuery;

    protected $guarded = [
        'item_id'
    ];

    protected static function getItems()
    {
        return Item::getAllObjects();
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'item_purchases', 'item_id', 'purchase_id')
            ->withPivot('quantity');
    }
}

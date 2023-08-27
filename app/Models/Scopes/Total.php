<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Total implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $sql = "select purchases.id as purchase_id,
                purchases.status,
                purchases.created_at as purchase_day,
                purchases.customer_id,
                items.price * item_purchases.quantity as subtotal
                from purchases
                left join item_purchases on purchases.id = item_purchases.purchase_id
                left join items on item_purchases.item_id = items.id";
        
        $builder->fromSub($sql, 'order_total');
    }
}

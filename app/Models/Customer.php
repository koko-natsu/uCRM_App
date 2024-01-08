<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\CommonQuery;

class Customer extends Model
{
    use HasFactory;
    use CommonQuery;

    protected $guarded = [
        'customer_id'
    ];

    protected static function getCustomers()
    {
        return Customer::getAllObjects();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}

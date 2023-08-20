<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [
        'customer_id'
    ];


    protected static function getCustomers()
    {
        return (new static)
            ->orderByDesc('created_at')
            ->get();
    }
}

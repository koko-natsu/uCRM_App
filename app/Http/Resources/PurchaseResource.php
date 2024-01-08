<?php

namespace App\Http\Resources;

use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\ReceiptCollection;
use App\Models\Customer;
use App\Models\Purchase;
use App\Http\Traits\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $date = Date::excerptDate($this->created_at);
        $customer = Customer::find($this->customer_id);

        return [
            'data' => [
                'type' => 'purchases',
                'purchase_id'      => $this->purchase_id ?? $this->id,
                'attributes'       => [
                    'status'       => $this->status,
                    'total'        => (int)$this->total,
                    'purchase_day' => $date,
                    // The only data required Purchase is
                    // customer_id and customer_name, customer_kana.
                    // 'customer'     => new CustomerResource(Customer::find($this->customer_id)),
                    'customer' => [
                        'data' => [
                            'type' => 'customers',
                            'customer_id' => $customer->id,
                            'attributes'  => [
                                'name' => $customer->name,
                                'kana' => $customer->kana,
                            ]
                        ],
                        'links' => [
                            'self' => url('/customers/'. $customer->id),
                        ]
                    ],
                    'receipt'      => new ReceiptCollection($this->findReceipt($this->id ?? $this->purchase_id)),
                ]
            ],
            'links' => [
                'self' => url('/purchases/' . ($this->purchase_id ?? $this->id)),
            ]
        ];
    }

    private function findReceipt(int $purchase_id): Collection
    {
        return Purchase::findOrFail($purchase_id)->items;
    }
}

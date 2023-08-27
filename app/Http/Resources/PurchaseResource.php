<?php

namespace App\Http\Resources;

use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        list($date, $_) = preg_split('/ /', $this->purchase_day);

        return [
            'data' => [
                'type' => 'purchases',
                'purchase_id' => $this->purchase_id,
                'attributes' => [
                    'status' => $this->status,
                    'total'  => $this->total,
                    'purchase_day' => $date,
                    'customer' => new CustomerResource(Customer::find($this->customer_id)),
                ]
            ],
            'links' => [
                'self' => url('/purchases/' . $this->purchase_id),
            ]
        ];
    }
}

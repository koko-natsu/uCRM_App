<?php

namespace App\Http\Resources;

use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\ReceiptCollection;
use App\Models\Customer;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $date = $this->excerptDate($this->created_at);

        return [
            'data' => [
                'type' => 'purchases',
                'purchase_id' => $this->purchase_id ?? $this->id,
                'attributes' => [
                    'status' => $this->status,
                    'total'  => $this->total,
                    'purchase_day' => $date,
                    'customer' => new CustomerResource(Customer::find($this->customer_id)),
                    'receipt' => new ReceiptCollection($this->findReceipt($this->id ?? $this->purchase_id)),
                ]
            ],
            'links' => [
                'self' => url('/purchases/' . ($this->purchase_id ?? $this->id)),
            ]
        ];
    }

    private function excerptDate(Carbon $date): string
    {
        list($excerpt_date, $_) = preg_split('/ /', $date);

        return $excerpt_date;
    }

    private function findReceipt(int $purchase_id): Collection
    {
        return Purchase::findOrFail($purchase_id)->items;
    }
}

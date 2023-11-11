<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'type'=> 'receipt',
                'attributes' => [
                    'item_id' => $this->receipt->item_id,
                    'item_name' => $this->name,
                    'price' => $this->price,
                    'quantity' => $this->receipt->quantity,
                ]
            ]
        ];
    }
}

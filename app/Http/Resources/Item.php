<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
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
                'type' => 'items',
                'item_id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'memo' => $this->memo,
                    'price' => $this->price,
                    'is_selling' => $this->is_selling,
                ]
            ],
            'links' => [
                'self' => url('/items/'.$this->id),
            ]
        ];
    }
}

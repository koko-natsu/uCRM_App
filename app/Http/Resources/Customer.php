<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
                'type' => 'customers',
                'customer_id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'kana' => $this->kana,
                    'tel' => $this->tel,
                    'email' => $this->email,
                    'postcode' => $this->postcode,
                    'address' => $this->address,
                    'birthday' => $this->birthday,
                    'gender' => $this->gender,
                    'memo' => $this->memo,
                ]
            ],
            'links' => [
                'self' => url('/customers/' .$this->id)
            ]
        ];
    }
}

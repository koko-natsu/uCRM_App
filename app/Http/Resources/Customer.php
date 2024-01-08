<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Traits\Date;

class Customer extends JsonResource
{
    public function toArray(Request $request): array
    {
        $base_array  = [
            'data' => [
                'type'        => 'customers',
                'customer_id' => $this->id,
                'attributes'  => [
                    'tel'              => $this->tel,
                    'email'            => $this->email,
                    'postcode'         => $this->postcode,
                    'address'          => $this->address,
                    'birthday'         => $this->birthday,
                    'gender'           => $this->gender,
                    'memo'             => $this->memo,
                    'num_of_purchases' => $this->purchases->count(),
                    'most_recent'      =>  '--/--/--',
                    ]
                ],
            'links' => [
                'self' => url('/customers/' .$this->id)
            ],
        ];

        $route = $request->route()->action['controller'];
        if(preg_match('/retrieveCustomer/', $route) === 1)
        {
            list($last_name, $first_name) = $this->separateName($this->name);
            list($last_kana, $first_kana) = $this->separateName($this->kana);

            $base_array['data']['attributes']['name']['first_name'] = $first_name;
            $base_array['data']['attributes']['name']['last_name']  = $last_name;
            $base_array['data']['attributes']['kana']['first_name'] = $first_kana;
            $base_array['data']['attributes']['kana']['last_name']  = $last_kana;

            return $base_array;
        }


        $base_array['data']['attributes']['name'] = $this->name;
        $base_array['data']['attributes']['kana'] = $this->kana;

        if($this->purchases->isNotEmpty())
        {
            $base_array['data']['attributes']['most_recent'] = Date::excerptDate($this->purchases->last()->created_at);
        }

        return $base_array;

    }


    private function separateName(string $name): Array
    {
        list($last_name, $first_name) = preg_split("/\s/", $name);

        return [$last_name, $first_name];
    }
}

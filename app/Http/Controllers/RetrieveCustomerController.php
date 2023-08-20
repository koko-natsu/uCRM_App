<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class RetrieveCustomerController extends Controller
{
    public function retrieveCustomer(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);

        list($l_name, $f_name) = preg_split("/\s/", $customer->name);
        list($l_kana, $f_kana) = preg_split("/\s/", $customer->kana);

        return [
            'data' => [
                'type' => 'customers',
                'customer_id' => $customer->id,
                'attributes' => [
                    'name' => [
                        'first_name' => $f_name,
                        'last_name'  => $l_name,
                    ],
                    'kana' => [
                        'first_name' => $f_kana,
                        'last_name'  => $l_kana,
                    ],
                    'tel' => $customer->tel,
                    'email' => $customer->email,
                    'postcode' => $customer->postcode,
                    'address' => $customer->address,
                    'birthday' => $customer->birthday,
                    'gender' => $customer->gender,
                    'memo' => $customer->memo,
                ]
            ],
            'links' => [
                'self' => url('/customers/' .$customer->id)
            ]
        ];
    }
}
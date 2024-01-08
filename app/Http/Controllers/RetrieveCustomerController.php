<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer as ResourcesCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;

class RetrieveCustomerController extends Controller
{
    public function retrieveCustomer(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);

        return new ResourcesCustomer($customer);
    }
}
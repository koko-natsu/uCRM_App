<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render('Customers/Index', [
            'customers' => new CustomerCollection(
                Customer::getCustomers()
                )
        ]);
    }


    public function store(RegisterCustomerRequest $request, Customer $customer): CustomerCollection
    {
        // TODO: Set up validation
        $customer->create($request->all());

        return new CustomerCollection(
            Customer::getCustomers()
        );
    }

    public function update(UpdateCustomerRequest $validated_data)
    {
        // TODO: Set up validation
        $customer = Customer::findOrFail(request()->customer_id);

        $customer->update($validated_data->all());

        return new CustomerCollection(
            Customer::getCustomers()
        );
    }

    public function destroy(Request $request)
    {
        // TODO: Set up Relation delete
        // When a customer is deleted, the relationship is also deleted.
        // Add this to the test.
        $customer = Customer::findOrFail($request->customer_id);
        $customer->delete();

        return new CustomerCollection(
            Customer::getAllObjects(),
        );
    }
}

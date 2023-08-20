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
        $customers = Customer::orderByDesc('created_at')->get();

        return Inertia::render('Customers/Index', [
            'customers' => new CustomerCollection($customers)
        ]);
    }


    public function store(RegisterCustomerRequest $request, Customer $customer): CustomerCollection
    {
        $customer->create($request->all());

        $customers = Customer::getCustomers();
        return new CustomerCollection($customers);
    }

    public function update(UpdateCustomerRequest $validated_data)
    {
        $customer = Customer::findOrFail(request()->customer_id);

        $customer->update($validated_data->all());

        $customers = Customer::getCustomers();

        return new CustomerCollection($customers);
    }

    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);

        $customer->delete();
        $customers = Customer::getCustomers();
        return new CustomerCollection($customers);
    }
}

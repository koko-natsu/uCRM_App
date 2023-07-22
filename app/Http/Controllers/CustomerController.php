<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return Inertia::render('Customers/Index', [
            'customers' => new CustomerCollection($customers)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'kana' => 'required|string|max:50',
            'tel' => 'numeric',
            'email' => '',
            'postcode' => 'numeric',
            'address' => 'string',
            'birthday' => '',
            'gender' => 'numeric',
            'memo' => 'string|max:255',
        ]);

        Customer::create([
            'name' => $data['name'],
            'kana' => $data['kana'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'postcode' => $data['postcode'],
            'address' => $data['address'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'memo' => $data['memo'],
        ]);

        $customers = Customer::all();
        return new CustomerCollection($customers);
    }
}

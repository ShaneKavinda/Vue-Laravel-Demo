<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'contact' => 'required|max:10'
        ]);

        // Generate a unique code
        $code = Str::uuid()->toString();

        // Create the customer with generated code
        $customer = Customer::create([
            'name' => $validatedData['name'],
            'code' => $code,
            'address' => $validatedData['address'],
            'contact' => $validatedData['contact'],
        ]);

        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'contact' => 'required|max:10',
        ]);

        $customer->update($validatedData);

        return response()->json($customer, 200);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(null, 204);
    }
}

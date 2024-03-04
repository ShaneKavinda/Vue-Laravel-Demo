<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::with('product')->get();
        return response()->json($discounts);
    }

    /**
     * Display a discount when its id is parsed
     */
    public function show(Discount $discount){
        return response()->json($discount);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount' => 'required|min:0',
            'lower_limit' => 'required|integer|min:0',
            'upper_limit' => 'required|integer|min:0'
        ]);

        $discount = Discount::create($validatedData);

        return response()->json($discount, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount' => 'required|min:0',
            'lower_limit' => 'required|integer|min:0',
            'upper_limit' => 'required|integer|min:0'
        ]);

        $discount->update($validatedData);

        return response()->json($discount, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(null, 204);
    }

    /**
     * Get the discount by product ID and quantity.
     */
    public function discountByProduct($productId, Request $request)
    {
        // Retrieve the quantity from the JSON payload in the request
        $quantity = $request->input('quantity');

        // Find the discount based on product ID and quantity
        $discount = Discount::where('product_id', $productId)
            ->where('lower_limit', '<=', $quantity)
            ->where('upper_limit', '>=', $quantity)
            ->first();
        if ($discount != null){
            return response()->json($discount->discount);
        }
        else{
            return json_encode(0);
        }
        
    }

}

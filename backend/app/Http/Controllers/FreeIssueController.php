<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FreeIssue;
use Illuminate\Http\Request;
use App\Models\Product;

class FreeIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the purchase_product and free_product relationships
        $freeIssues = FreeIssue::with('purchaseProduct', 'freeProduct')->get();
        return response()->json($freeIssues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'purchase_product' => 'required',
            'free_quantity' => 'required',
            'purchase_quantity' => 'required',
            'lower_limit' => 'required',
            'upper_limit' => 'required'
        ]);

        // Assign the same value to free_product as purchase_product
        $request->merge(['free_product' => $request->input('purchase_product')]);

        // Create the FreeIssue
        $freeIssue = FreeIssue::create($request->all());

        return response()->json($freeIssue, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FreeIssue $freeIssue)
    {
        // Return the free issue details as JSON
        return response()->json($freeIssue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FreeIssue $freeIssue)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'purchase_product' => 'required',
            'free_quantity' => 'required',
            'purchase_quantity' => 'required',
            'lower_limit' => 'required',
            'upper_limit' => 'required'
        ]);

        // Assign the same value to free_product as purchase_product
        $request->merge(['free_product' => $request->input('purchase_product')]);

        // Update the free issue
        $freeIssue->update($request->all());

        // Return the updated free issue details as JSON
        return response()->json($freeIssue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FreeIssue $freeIssue)
    {
        // Delete the free issue
        $freeIssue->delete();

        // Return a success response
        return response()->json(null, 204);
    }

    /**
     * Get the free issue by product ID.
     */
    public function getFreeIssueByProduct($productId)
    {
        // Find the free issue by purchase_product ID
        $freeIssue = FreeIssue::where('purchase_product', $productId)->first();

        // Return the free issue details as JSON
        return response()->json($freeIssue);
    }
}

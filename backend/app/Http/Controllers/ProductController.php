<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return response()->json($products);
    }

    /**
     * Search for a given product in the database.
     */
    public function search(Request $request)
    {
        // Retrieve the JSON payload from the request body
        $requestData = $request->json()->all();

        // Check if the 'q' key exists in the JSON payload
        if (isset($requestData['q'])) {
            $searchTerm = $requestData['q'];

            // Perform the search query to retrieve matching products
            $products = Product::where('name', 'like', '%' . $searchTerm . '%')->get();

            // Format the data as JSON and return it
            return response()->json($products);
        } else {
            // If the 'q' key is not present in the JSON payload, return an error response
            return response()->json(['error' => 'Search term not provided'], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'expiry_date' => 'nullable',
        ]);

        // Generate a unique code
        $code = Str::uuid()->toString();

        // Create the product with generated code
        $product = Product::create([
            'name' => $request->name,
            'code' => $code,
            'price' => $request->price,
            'expiry_date' => $request->expiry_date,
        ]);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'expiry_date' => 'nullable',
        ]);

        // Ensure the original code remains unchanged
        $data = $request->except('code');

        $product->update($data);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    /**
     * Get the price of a product by its ID.
     */
    public function getProductPrice($productId)
    {
        // Fetch the product by its ID
        $product = Product::findOrFail($productId);

        // Return the price of the product
        return response()->json(['price' => $product->price]);
    }
}

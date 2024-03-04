<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Exports\OrderExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

class OrderController extends Controller
{
    public function index()
    {
        // Retrieve all orders with their related customer information
        $orders = Order::with('customer')->get();

        // Return JSON response
        return response()->json(['orders' => $orders]);
    }

    public function create()
    {
        // Endpoint not applicable for API
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.free' => 'nullable|integer|min:0',
            'net_amount' => 'required|numeric|min:0',
            'products.*.discount' => 'numeric',
            'products.*.subtotal' => 'required|numeric|min:0'
        ]);

        // Create the order
        $order = new Order();
        $order->customer_id = $validatedData['customer'];
        $order->net_amount = $validatedData['net_amount'];
        $order->order_date = now()->toDateString(); // Set order_date to current date
        $order->order_time = now()->toTimeString(); // Set order_time to current time
        $order->save();

        // Create order products
        foreach ($validatedData['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $order->products()->attach($productData['product_id'], [
                'amount' => $product->price * $productData['quantity'],
                'free' => $productData['free'] ?? 0,
                'quantity' => $productData['quantity'],
                'discount' => $productData['discount'],
                'subtotal' => $productData['subtotal'],
            ]);
        }

        // Return JSON response
        return response()->json(['message' => 'Order created successfully', 'order' => $order]);
    }

    public function show($orderID)
    {
        // Load the associated order products with the order
        $order = Order::with('products')->find($orderID);

        // Return JSON response
        return response()->json(['order' => $order]);
    }

    public function downloadPDF($orderID)
    {
        // Endpoint not applicable for API
    }

    public function exportExcel($orderID)
    {
        // Endpoint not applicable for API
    }

    public function bulkPDFGeneration(Request $request)
    {
        // Endpoint not applicable for API
    }
}

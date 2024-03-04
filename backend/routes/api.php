<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FreeIssueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::get('/{customer}', [CustomerController::class, 'show']);
    Route::put('/{customer}', [CustomerController::class, 'update']);
    Route::delete('/{customer}', [CustomerController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
    Route::post('/search', [ProductController::class, 'search']);
    Route::get('/{productId}/price', [ProductController::class, 'getProductPrice']);
});

Route::prefix('free_issues')->group(function () {
    Route::get('/', [FreeIssueController::class, 'index']);
    Route::post('/', [FreeIssueController::class, 'store']);
    Route::get('/{free_issue}', [FreeIssueController::class, 'show']);
    Route::put('/{free_issue}', [FreeIssueController::class, 'update']);
    Route::delete('/{free_issue}', [FreeIssueController::class, 'destroy']);
    Route::get('/product/{productId}', [FreeIssueController::class, 'getFreeIssueByProduct']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::put('/{order}', [OrderController::class, 'update']);
    Route::delete('/{order}', [OrderController::class, 'destroy']);
    Route::get('/{orderId}/download-pdf', [OrderController::class, 'downloadPDF']);
    Route::get('/{order}/export-excel', [OrderController::class, 'exportExcel']);
    Route::post('/bulk', [OrderController::class, 'bulkPDFGeneration']);
});

Route::prefix('discounts')->group(function () {
    Route::get('/', [DiscountController::class, 'index']);
    Route::post('/', [DiscountController::class, 'store']);
    Route::get('/{discount}', [DiscountController::class, 'show']);
    Route::put('/{discount}', [DiscountController::class, 'update']);
    Route::delete('/{discount}', [DiscountController::class, 'destroy']);
    Route::post('/{productId}', [DiscountController::class, 'discountByProduct']);
});


Route::get('/test-database-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Database connection is successful'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Database connection failed: ' . $e->getMessage()], 500);
    }
});
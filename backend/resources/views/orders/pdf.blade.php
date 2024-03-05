@extends('layouts.app')

@section('content')
<style>
  #element-to-export {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  .block {
    max-width: 6xl;
    background-color: #fff;
    padding: 1.5rem;
    margin: 0 auto;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
  }

  .space-y-6 {
    margin-top: 1.5rem;
  }

  .border-b {
    border-bottom: 1px solid #e5e7eb;
  }

  .pb-6 {
    padding-bottom: 1.5rem;
  }

  .text-lg {
    font-size: 1.125rem;
    font-weight: 700;
  }

  .font-semibold {
    font-weight: 600;
  }

  .mb-2 {
    margin-bottom: 0.5rem;
  }

  .text-sm {
    font-size: 0.875rem;
  }

  .text-gray-500 {
    color: #393e45;
  }

  .flex {
    display: flex;
  }

  .justify-end {
    justify-content: flex-end;
  }

  .space-x-4 {
    gap: 1rem;
  }

  .label {
    display: block;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .text-m {
    font-size: 0.75rem;
  }

  .text-gray-900 {
    color: #212529;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead {
    background-color: #f8f9fa;
  }

  th,
  td {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    text-align: left;
  }

  th {
    font-weight: 700;
    text-transform: uppercase;
  }

  tbody tr:nth-child(even) {
    background-color: #f5f5f5;
  }
</style>

<div class="block" id="element-to-export">
  <div class="space-y-6">
    <div class="border-b pb-6">
      <h2 class="text-lg font-semibold mb-2">Invoice No: {{ $order->id }}</h2>
      <p class="text-sm text-gray-500">Customer: {{ $order->customer->name }}</p>
      <div class="flex justify-end space-x-4">
        <label for="net_amount" class="label">Net Amount</label>
        <span class="text-m text-gray-900">{{ $order->net_amount }}</span>
      </div>
    </div>
    <table class="min-w-full">
      <thead>
        <tr>
          <th class="px-6 py-3">Product</th>
          <th class="px-6 py-3">Quantity</th>
          <th class="px-6 py-3">Free</th>
          <th class="px-6 py-3">Amount</th>
          <th class="px-6 py-3">Discount(%)</th>
          <th class="px-6 py-3">Sub Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->products as $product)
        <tr>
          <td class="px-6 py-4">{{ $product->name }}</td>
          <td class="px-6 py-4">{{ $product->pivot->quantity }}</td>
          <td class="px-6 py-4">{{ $product->pivot->free }}</td>
          <td class="px-6 py-4">{{ $product->pivot->amount }}</td>
          <td class="px-6 py-4">{{ $product->pivot->discount }}</td>
          <td class="px-6 py-4">{{ $product->pivot->subtotal }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

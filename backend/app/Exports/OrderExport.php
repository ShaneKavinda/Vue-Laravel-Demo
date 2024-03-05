<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function collection()
    {
        return collect([$this->order]);
    }

    public function map($order): array
    {
        $data = [];

        

        // Products in the order
        foreach ($order->products as $product) {
            $data[] = [
                'Product Name' => $product->name,
                'Quantity' => $product->pivot->quantity,
                'Price' => $product->price,
                'Amount' => $product->pivot->amount,
                'Free' => $product->pivot->free,
                'Discount' => $product->pivot->discount,
                'Subtotal' => $product->pivot->subtotal
            ];
        }

        // Total amount
        $data[] = [
            'Product Name' => '',
            'Quantity' => '',
            'Price' => '',
            'Amount' => '',
            'Free' => '',
            'Discount' => 'Net Amount',
            'Subtotal' => $order->net_amount, 
        ];

        // Empty space
        $data[] = [
            'Product Name' => '',
            'Quantity' => '',
            'Price' => '',
            'Amount' => '', 
            'Free' => '',
            'Discount' => '',
            'Subtotal' => ''
        ];

        // Order id and name
        $data[] = [
            'Product Name' => 'Order ID',
            'Quantity' => 'Customer Name',
            'Price' => 'Order Date',
            'Amount' => 'Order Time',
            'Free' => '',
            'Discount' => '',
            'Subtotal' => ''
        ];

        // Order date and time
        $data[] = [
            'Product Name' => $order->id,
            'Quantity' => $order->customer->name,
            'Price' => $order->order_date,
            'Amount' => $order->order_time,
            'Free' => '',
            'Discount' => '',
            'Subtotal' => '' 
        ];


        return $data;
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Quantity',
            'Price',
            'Amount',
            'Free',
            'Discount',
            'Subtotal'
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function show(string $orderNumber): View
    {
        $order = Order::with('customer', 'payments', 'invoice', 'latestPayment')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('order.show', compact('order'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'orders' => Order::count(),
                'pending' => Order::whereIn('status', [Order::STATUS_PENDING, Order::STATUS_AWAITING])->count(),
                'paid' => Order::where('status', Order::STATUS_PAID)->count(),
                'customers' => Customer::count(),
                'revenue' => Order::where('status', Order::STATUS_PAID)->sum('amount'),
                'invoices' => Invoice::count(),
                'awaiting_proofs' => Payment::where('status', Payment::STATUS_AWAITING)
                    ->whereNotNull('transaction_reference')
                    ->count(),
            ],
            'recentOrders' => Order::with('customer')->latest()->take(8)->get(),
        ]);
    }
}

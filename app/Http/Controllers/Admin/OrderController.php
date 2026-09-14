<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {
    }

    public function index(Request $request): View
    {
        $query = Order::with('customer', 'latestPayment')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('order_number', 'like', "%{$q}%")
                    ->orWhere('project_name', 'like', "%{$q}%")
                    ->orWhere('package_name', 'like', "%{$q}%")
                    ->orWhereHas('customer', function ($c) use ($q) {
                        $c->where('email', 'like', "%{$q}%")
                            ->orWhere('full_name', 'like', "%{$q}%")
                            ->orWhere('company_name', 'like', "%{$q}%");
                    });
            });
        }

        return view('admin.orders.index', [
            'orders' => $query->paginate(20)->withQueryString(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('customer', 'payments', 'invoice');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,awaiting_confirmation,paid,failed,cancelled'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['status'] === Order::STATUS_PAID && ! $order->isPaid()) {
            $this->orderService->markAsPaid($order);
        } else {
            $order->update([
                'status' => $data['status'],
                'notes' => $data['notes'] ?? $order->notes,
            ]);
        }

        if (isset($data['notes'])) {
            $order->update(['notes' => $data['notes']]);
        }

        return back()->with('success', 'Commande mise à jour.');
    }
}

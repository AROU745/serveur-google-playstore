<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Invoice::with('order.customer')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('admin.invoices.index', [
            'invoices' => $query->paginate(20)->withQueryString(),
        ]);
    }
}

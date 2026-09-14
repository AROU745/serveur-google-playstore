@extends('layouts.admin')

@section('title', 'Factures')
@section('heading', 'Factures')

@section('content')
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Tous les statuts</option>
            @foreach(['draft','issued','paid'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filtrer</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>N° facture</th>
                    <th>Commande</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Émise le</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td><code>{{ $invoice->invoice_number }}</code></td>
                        <td>
                            <a href="{{ route('admin.orders.show', $invoice->order_id) }}">
                                {{ $invoice->order->order_number }}
                            </a>
                        </td>
                        <td>{{ $invoice->order->customer->company_name }}</td>
                        <td>{{ number_format($invoice->amount, 0, ',', ' ') }} {{ $invoice->currency }}</td>
                        <td><span class="badge text-bg-secondary">{{ $invoice->status }}</span></td>
                        <td>{{ optional($invoice->issued_at)->format('d/m/Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Aucune facture</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $invoices->links() }}</div>
@endsection

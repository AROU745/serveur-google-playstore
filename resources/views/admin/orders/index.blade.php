@extends('layouts.admin')

@section('title', 'Commandes')
@section('heading', 'Commandes')

@section('content')
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-5">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher…">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Tous les statuts</option>
            @foreach(['pending','awaiting_confirmation','paid','failed','cancelled'] as $status)
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
                    <th>N°</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Projet</th>
                    <th>Méthode</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><code>{{ $order->order_number }}</code></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->customer->company_name }}</td>
                        <td>{{ $order->project_name }}</td>
                        <td>{{ $order->payment_method ?? '—' }}</td>
                        <td>{{ $order->formattedAmount() }}</td>
                        <td><span class="badge text-bg-secondary">{{ $order->status }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Détail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-secondary py-4">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection

@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('heading', 'Tableau de bord')

@section('content')
<div class="row g-3 mb-4">
    @foreach([
        ['Commandes', $stats['orders'], 'fa-bag-shopping', 'primary'],
        ['En attente', $stats['pending'], 'fa-clock', 'warning'],
        ['Payées', $stats['paid'], 'fa-circle-check', 'success'],
        ['Clients', $stats['customers'], 'fa-users', 'info'],
        ['CA confirmé', number_format($stats['revenue'], 0, ',', ' ').' USD', 'fa-dollar-sign', 'dark'],
        ['Preuves à valider', $stats['awaiting_proofs'], 'fa-file-arrow-up', 'secondary'],
    ] as $card)
    <div class="col-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon text-{{ $card[3] }}"><i class="fa-solid {{ $card[2] }}"></i></div>
            <div class="stat-value">{{ $card[1] }}</div>
            <div class="stat-label">{{ $card[0] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <strong>Commandes récentes</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Projet</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td><code>{{ $order->order_number }}</code></td>
                        <td>{{ $order->customer->full_name }}</td>
                        <td>{{ $order->project_name }}</td>
                        <td>{{ $order->formattedAmount() }}</td>
                        <td><span class="badge text-bg-secondary">{{ $order->status }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

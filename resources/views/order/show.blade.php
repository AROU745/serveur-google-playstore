@extends('layouts.app')

@section('title', 'Commande '.$order->order_number.' — GPSS')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Commande {{ $order->order_number }}</h1>
        <p>Suivi de votre abonnement serveur</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="form-card">
                    @php
                        $statusMap = [
                            'pending' => ['En attente', 'secondary'],
                            'awaiting_confirmation' => ['En attente de confirmation', 'warning'],
                            'paid' => ['Payée', 'success'],
                            'failed' => ['Échouée', 'danger'],
                            'cancelled' => ['Annulée', 'dark'],
                        ];
                        [$label, $color] = $statusMap[$order->status] ?? ['Inconnu', 'secondary'];
                    @endphp
                    <span class="badge text-bg-{{ $color }} mb-3">{{ $label }}</span>

                    <h2 class="h4 mb-3">Détails</h2>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6"><strong>Projet</strong><br>{{ $order->project_name }}</div>
                        <div class="col-md-6"><strong>Package</strong><br>{{ $order->package_name }}</div>
                        <div class="col-md-6"><strong>Montant</strong><br>{{ $order->formattedAmount() }}</div>
                        <div class="col-md-6"><strong>Durée</strong><br>{{ $order->formattedDuration() }}</div>
                        <div class="col-md-6"><strong>Méthode</strong><br>{{ strtoupper($order->payment_method ?? '—') }}</div>
                        <div class="col-md-6"><strong>Facture</strong><br>{{ $order->invoice->invoice_number ?? '—' }}</div>
                    </div>

                    <h3 class="h5">Client</h3>
                    <p class="mb-0">{{ $order->customer->full_name }} — {{ $order->customer->company_name }}</p>
                    <p class="text-secondary">{{ $order->customer->email }} · {{ $order->customer->phone }} · {{ $order->customer->country }}</p>

                    @if($order->status !== 'paid')
                        <a href="{{ route('payment.pending', ['order' => $order->order_number]) }}" class="btn btn-accent mt-3">
                            Gérer le paiement / preuve Wise
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="summary-card">
                    <h3 class="h6">Historique paiements</h3>
                    @forelse($order->payments as $payment)
                        <div class="border-bottom py-2 small">
                            <div class="d-flex justify-content-between">
                                <strong>{{ strtoupper($payment->method) }}</strong>
                                <span>{{ $payment->status }}</span>
                            </div>
                            @if($payment->transaction_reference)
                                <div class="text-secondary">Réf. {{ $payment->transaction_reference }}</div>
                            @endif
                        </div>
                    @empty
                        <p class="text-secondary small mb-0">Aucun paiement enregistré.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

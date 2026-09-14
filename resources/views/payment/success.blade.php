@extends('layouts.app')

@section('title', 'Paiement confirmé — GPSS')

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="form-card">
                    <div class="result-icon success mb-3"><i class="fa-solid fa-circle-check"></i></div>
                    <h1 class="h3">Paiement confirmé</h1>
                    <p class="text-secondary">Votre abonnement serveur est activé côté commande.</p>
                    @if($order)
                        <p class="mb-4">Commande <code>{{ $order->order_number }}</code> — {{ $order->formattedAmount() }}</p>
                        <a href="{{ route('order.show', $order->order_number) }}" class="btn btn-accent">Voir la commande</a>
                    @endif
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Accueil</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

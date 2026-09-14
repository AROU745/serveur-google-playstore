@extends('layouts.app')

@section('title', 'Paiement échoué — GPSS')

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="form-card">
                    <div class="result-icon failed mb-3"><i class="fa-solid fa-circle-xmark"></i></div>
                    <h1 class="h3">Paiement non abouti</h1>
                    <p class="text-secondary">
                        {{ session('error', 'Une erreur est survenue lors du traitement du paiement.') }}
                    </p>
                    @if($order)
                        <p class="mb-4">Commande <code>{{ $order->order_number }}</code></p>
                        <a href="{{ route('payment.pending', ['order' => $order->order_number]) }}" class="btn btn-accent">Réessayer / Wise</a>
                    @endif
                    <a href="{{ route('payment') }}" class="btn btn-outline-secondary ms-2">Nouvelle souscription</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

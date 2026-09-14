@extends('layouts.admin')

@section('title', 'Commande '.$order->order_number)
@section('heading', 'Commande '.$order->order_number)

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5">Informations</h2>
                <div class="row g-3">
                    <div class="col-md-6"><strong>Client</strong><br>{{ $order->customer->full_name }}</div>
                    <div class="col-md-6"><strong>Entreprise</strong><br>{{ $order->customer->company_name }}</div>
                    <div class="col-md-6"><strong>Email</strong><br>{{ $order->customer->email }}</div>
                    <div class="col-md-6"><strong>Téléphone</strong><br>{{ $order->customer->phone }}</div>
                    <div class="col-md-6"><strong>Pays</strong><br>{{ $order->customer->country }}</div>
                    <div class="col-md-6"><strong>Projet</strong><br>{{ $order->project_name }}</div>
                    <div class="col-md-6"><strong>Package</strong><br>{{ $order->package_name }}</div>
                    <div class="col-md-6"><strong>Montant</strong><br>{{ $order->formattedAmount() }}</div>
                    <div class="col-12"><strong>Adresse</strong><br>{{ $order->customer->billing_address }}</div>
                    @if($order->payment_method === 'visa')
                        <div class="col-12"><hr><strong>Dossier Visa / KYC</strong></div>
                        <div class="col-md-6"><strong>NIF</strong><br>{{ $order->nif ?? '—' }}</div>
                        <div class="col-md-6"><strong>RCCM</strong><br>{{ $order->rccm ?? '—' }}</div>
                        <div class="col-md-6"><strong>CFE</strong><br>{{ $order->cfe ?? '—' }}</div>
                        <div class="col-md-6"><strong>Ancienneté</strong><br>{{ $order->company_years ? $order->company_years.' ans' : '—' }}</div>
                        <div class="col-md-6"><strong>Pièce</strong><br>{{ $order->id_document_type ?? '—' }}</div>
                        <div class="col-md-6"><strong>Confirmé +3 ans</strong><br>{{ $order->company_eligible_confirmed ? 'Oui' : 'Non' }}</div>
                        <div class="col-md-6"><strong>Dossier soumis le</strong><br>{{ optional($order->dossier_submitted_at)->format('d/m/Y H:i') ?? '—' }}</div>
                        <div class="col-md-3">
                            @if($order->nif_document_path)
                                <a href="{{ asset('storage/'.$order->nif_document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">PDF NIF</a>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($order->rccm_document_path)
                                <a href="{{ asset('storage/'.$order->rccm_document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">PDF RCCM</a>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($order->cfe_document_path)
                                <a href="{{ asset('storage/'.$order->cfe_document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">PDF CFE</a>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($order->id_document_path)
                                <a href="{{ asset('storage/'.$order->id_document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">PDF identité</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Paiements</h2>
                @forelse($order->payments as $payment)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ strtoupper($payment->method) }} — {{ $payment->status }}</strong>
                            <span>{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</span>
                        </div>
                        @if($payment->transaction_reference)
                            <div class="small">Réf. : {{ $payment->transaction_reference }}</div>
                        @endif
                        @if($payment->payer_name)
                            <div class="small">Payeur : {{ $payment->payer_name }} ({{ $payment->payer_email }})</div>
                        @endif
                        @if($payment->payment_date)
                            <div class="small">Date : {{ $payment->payment_date->format('d/m/Y') }}</div>
                        @endif
                        @if($payment->proof_path)
                            <a href="{{ asset('storage/'.$payment->proof_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-2">
                                Voir la preuve
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="text-secondary mb-0">Aucun paiement</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6">Mettre à jour le statut</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <select name="status" class="form-select" required>
                            @foreach(['pending','awaiting_confirmation','paid','failed','cancelled'] as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes internes</label>
                        <textarea name="notes" rows="4" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                    </div>
                    <button class="btn btn-accent w-100">Enregistrer</button>
                </form>
                @if($order->invoice)
                    <hr>
                    <p class="small mb-0">Facture : <code>{{ $order->invoice->invoice_number }}</code> ({{ $order->invoice->status }})</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

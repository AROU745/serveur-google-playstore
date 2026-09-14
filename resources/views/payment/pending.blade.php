@extends('layouts.app')

@section('title', $order->payment_method === 'visa' ? 'Dossier Visa en attente — GPSS' : 'Paiement Wise en attente — GPSS')

@section('content')
<section class="page-hero">
    <div class="container">
        @if($order->payment_method === 'visa')
            <h1>Dossier Visa en attente de confirmation</h1>
            <p>Votre dossier entreprise a été transmis pour vérification</p>
        @else
            <h1>Paiement Wise en attente de confirmation</h1>
            <p>Finalisez votre virement puis déclarez le paiement</p>
        @endif
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="summary-card">
                    <div class="status-pill awaiting mb-3"><i class="fa-solid fa-clock me-1"></i> En attente</div>
                    <h2 class="h5">Détails de la commande</h2>
                    <dl class="detail-list">
                        <div><dt>N° commande</dt><dd><code>{{ $order->order_number }}</code></dd></div>
                        <div><dt>Montant</dt><dd><strong>{{ $order->formattedAmount() }}</strong></dd></div>
                        <div><dt>Durée</dt><dd>{{ $order->formattedDuration() }}</dd></div>
                        <div><dt>Méthode</dt><dd>{{ strtoupper($order->payment_method ?? '—') }}</dd></div>
                        <div><dt>Projet</dt><dd>{{ $order->project_name }}</dd></div>
                        <div><dt>Package</dt><dd>{{ $order->package_name }}</dd></div>
                       
                    </dl>

                    @if($order->payment_method === 'visa')
                        <div class="alert alert-primary border-0 small mb-3">
                            Votre dossier a été <strong>enregistré en base de données</strong>
                            (NIF, RCCM, CFE, pièce d’identité et informations client).
                            Après vérification des réglementations de l’entreprise, vous recevrez une réponse
                            <strong>au plus tard dans les 15 jours</strong>, ainsi qu’un
                            <strong>lien de paiement conforme aux règlements de l’Union européenne</strong>
                            pour finaliser le règlement de <strong>1 082 USD</strong>.
                        </div>
                    @elseif($wiseUrl || session('wise_redirect'))
                        <div class="alert alert-primary border-0 small mb-3">
                            Effectuez le paiement de <strong>1 082 USD</strong> sur votre page Wise, puis revenez remplir le formulaire ci-contre.
                        </div>
                        <a href="{{ session('wise_redirect', $wiseUrl) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-accent w-100 mb-2"
                           id="openWiseBtn"
                           data-wise-url="{{ session('wise_redirect', $wiseUrl) }}">
                            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>
                            Payer maintenant sur Wise — 1 082 USD
                        </a>
                        <p class="small text-secondary text-center mb-3">
                            <a href="{{ session('wise_redirect', $wiseUrl) }}" target="_blank" rel="noopener noreferrer">
                                {{ session('wise_redirect', $wiseUrl) }}
                            </a>
                        </p>
                    @else
                        <div class="alert alert-warning small mb-2">
                            Le lien Wise n'est pas encore configuré (WISE_PAYMENT_URL). Contactez le support.
                        </div>
                    @endif

                    <a href="{{ route('order.show', $order->order_number) }}" class="btn btn-outline-secondary w-100">
                        Voir ma commande
                    </a>
                </div>

                @if($order->payment_method !== 'visa')
                    <div class="info-panel mt-4">
                        <h3 class="h6 mb-2">Instructions</h3>
                        <div class="small text-secondary" style="white-space: pre-line;">{{ $wiseInstructions }}</div>
                    </div>
                @endif
            </div>

            <div class="col-lg-7">
                @if($order->payment_method === 'visa')
                    <div class="form-card">
                        <h2 class="h4 mb-3">Prochaines étapes</h2>
                        <ol class="text-secondary">
                            <li class="mb-2">Vérification du dossier entreprise (plus de 3 ans d’existence) et des réglementations applicables.</li>
                            <li class="mb-2">Contrôle des documents NIF, RCCM, CFE et pièce d’identité.</li>
                            <li class="mb-2">Réponse au plus tard dans les <strong>15 jours</strong>, avec transmission d’un lien de paiement conforme aux règlements de l’Union européenne.</li>
                            <li class="mb-2">Cette procédure contribue à se prémunir contre les applications mobiles pirates ou malveillantes et à garantir une bonne utilisation des projets liés à Play Store.</li>
                        </ol>
                        <a href="{{ route('contact') }}" class="btn btn-accent">Contacter le support</a>
                    </div>
                @else
                    <div class="form-card">
                        <h2 class="h4 mb-3">J'ai effectué le paiement</h2>
                        <p class="text-secondary mb-4">Indiquez les informations de votre transaction Wise et joignez une preuve.</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('payment.proof') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Numéro de transaction Wise *</label>
                                    <input type="text" name="transaction_reference" class="form-control" value="{{ old('transaction_reference') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date du paiement *</label>
                                    <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom du payeur *</label>
                                    <input type="text" name="payer_name" class="form-control" value="{{ old('payer_name', $order->customer->full_name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="payer_email" class="form-control" value="{{ old('payer_email', $order->customer->email) }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Preuve de paiement (JPG, PNG, PDF — max 5 Mo) *</label>
                                    <input type="file" name="proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-accent btn-lg w-100 mt-4">
                                Envoyer la confirmation de paiement
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@if($order->payment_method !== 'visa')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('openWiseBtn');
    const autoUrl = @json(session('wise_redirect'));
    if (autoUrl && btn) {
        window.open(autoUrl, '_blank', 'noopener,noreferrer');
    }
});
</script>
@endif
@endpush

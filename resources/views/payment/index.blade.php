@extends('layouts.app')

@section('title', 'Paiement — Google Play Server Service')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Souscription</h1>
        <p>Abonnement serveur — 1 082 USD — durée indéterminée</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="summary-card sticky-lg-top" style="top: 100px;">
                    <h2 class="h5 mb-3">Abonnement serveur</h2>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Prix</span>
                        <strong>1 082 USD</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Durée</span>
                        <strong>Indéterminée</strong>
                    </div>
                    <hr>
                    <p class="small text-secondary mb-0">
                        {{ $plan['description'] }}
                    </p>
                    <div class="alert alert-light border mt-3 mb-0 small">
                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                        Service - affilié à Google LLC
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-card">
                    <h2 class="h4 mb-4">Informations client</h2>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('payment.store') }}" id="paymentForm" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom complet *</label>
                                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom de l'entreprise *</label>
                                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone *</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pays *</label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom du projet *</label>
                                <input type="text" name="project_name" class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Package / application concerné *</label>
                                <input type="text" name="package_name" class="form-control @error('package_name') is-invalid @enderror" value="{{ old('package_name') }}" placeholder="ex. com.entreprise.app" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse de facturation *</label>
                                <textarea name="billing_address" rows="3" class="form-control @error('billing_address') is-invalid @enderror" required>{{ old('billing_address') }}</textarea>
                            </div>
                        </div>

                        <h2 class="h4 mt-5 mb-3">Moyen de paiement</h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="wise" id="methodWise" {{ old('payment_method', 'wise') === 'wise' ? 'checked' : '' }} required>
                                    <span class="payment-option-body">
                                        <i class="fa-solid fa-building-columns"></i>
                                        <strong>Payer avec Wise</strong>
                                        <small>Montant : 1 082 USD<br>Paiement direct sur Wise</small>
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="visa" id="methodVisa" {{ old('payment_method') === 'visa' ? 'checked' : '' }}>
                                    <span class="payment-option-body">
                                        <i class="fa-brands fa-cc-visa"></i>
                                        <strong>Payer par Visa</strong>
                                        <small>Dossier entreprise + vérification<br>Puis finalisation sécurisée</small>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div id="wisePanel" class="wise-only-panel mb-4">
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <div class="wise-icon"><i class="fa-solid fa-building-columns"></i></div>
                                <div>
                                    <strong class="d-block mb-1">Paiement Wise</strong>
                                    <p class="mb-2 small text-secondary">
                                        Montant : <strong>1 082 USD</strong> — durée indéterminée
                                    </p>
                                    <ol class="small text-secondary mb-0 ps-3">
                                        <li>Validez le formulaire.</li>
                                        <li>Ouvrez Wise et payez 1 082 USD.</li>
                                        <li>Revenez confirmer avec n° de transaction + preuve.</li>
                                    </ol>
                                </div>
                            </div>
                            @if($wiseUrl)
                                <a href="{{ $wiseUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>
                                    Ouvrir Wise pour payer — 1 082 USD
                                </a>
                                <p class="small text-secondary mb-0 text-center">
                                    <a href="{{ $wiseUrl }}" target="_blank" rel="noopener noreferrer">{{ $wiseUrl }}</a>
                                </p>
                            @endif
                        </div>

                        <div id="visaPanel" class="visa-panel mb-4 d-none">
                            <div class="alert alert-primary">
                                <strong>Information importante</strong>
                                <p class="mb-2 small mt-1">
                                    Avant de poursuivre un règlement par carte Visa, veuillez renseigner les informations d’une
                                    <strong>entreprise justifiant de plus de trois (3) années d’existence</strong>.
                                </p>
                                <p class="mb-0 small">
                                    Après vérification des réglementations de l’entreprise, vous recevrez une réponse
                                    <strong>au plus tard dans les 15 jours</strong>, ainsi qu’un
                                    <strong>lien de paiement conforme aux règlements de l’Union européenne</strong>.
                                    Ce contrôle contribue à se prémunir contre les applications mobiles pirates ou malveillantes
                                    et à garantir une utilisation saine des projets liés à Play Store.
                                </p>
                            </div>

                            <h3 class="h5 mb-3">Documents d’entreprise (Visa)</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">NIF *</label>
                                    <input type="text" name="nif" class="form-control" value="{{ old('nif') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIF — fichier PDF *</label>
                                    <input type="file" name="nif_document" class="form-control" accept=".pdf,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Numéro RCCM *</label>
                                    <input type="text" name="rccm" class="form-control" value="{{ old('rccm') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">RCCM — fichier PDF *</label>
                                    <input type="file" name="rccm_document" class="form-control" accept=".pdf,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Numéro CFE *</label>
                                    <input type="text" name="cfe" class="form-control" value="{{ old('cfe') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CFE — fichier PDF *</label>
                                    <input type="file" name="cfe_document" class="form-control" accept=".pdf,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type de pièce *</label>
                                    <select name="id_document_type" class="form-select">
                                        <option value="">Choisir…</option>
                                        <option value="cni" @selected(old('id_document_type') === 'cni')>Carte d'identité</option>
                                        <option value="passeport" @selected(old('id_document_type') === 'passeport')>Passeport</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pièce d'identité / passeport — PDF *</label>
                                    <input type="file" name="id_document" class="form-control" accept=".pdf,application/pdf">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ancienneté de l'entreprise (années) *</label>
                                    <input type="number" name="company_years" class="form-control" min="3" max="120" value="{{ old('company_years') }}" placeholder="Minimum 3">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="company_eligible_confirm" value="1" id="companyEligible" {{ old('company_eligible_confirm') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="companyEligible">
                                            Je confirme que les informations transmises concernent une entreprise ayant
                                            <strong>plus de trois ans d’existence</strong>.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p class="small text-secondary mt-3 mb-0">
                                <i class="fa-solid fa-shield-halved me-1"></i>
                                Pour des raisons de sécurité et de conformité, le numéro de carte Visa, le CVC et la date d’expiration
                                ne sont <strong>pas</strong> saisis sur ce site. Après validation du dossier (sous 15 jours maximum),
                                un lien de paiement sécurisé conforme aux règlements de l’Union européenne vous sera communiqué.
                            </p>
                        </div>

                        <button type="submit" class="btn btn-accent btn-lg w-100" id="submitPayment">
                            Valider et continuer — 1 082 USD
                        </button>
                    </form>

                    @if(!empty($whopUrl))
                        <div class="mt-3">
                            <a href="{{ $whopUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-outline-dark btn-lg w-100">
                                <i class="fa-solid fa-bolt me-2"></i>
                                Payer avant configuration
                            </a>
                            <p class="small text-secondary text-center mt-2 mb-0">
                                Paiement immédiat via Whop — configuration après règlement
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal message professionnel entreprise 3 ans --}}
<div class="modal fade" id="visaCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title h5">Vérification préalable — Paiement Visa</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    Madame, Monsieur,
                </p>
                <p class="mb-3">
                    Avant de procéder au règlement par carte Visa d’un montant de <strong>1 082 USD</strong>,
                    nous vous prions de bien vouloir transmettre les informations et documents relatifs à une
                    <strong>entreprise ayant plus de trois (3) années d’existence</strong>.
                </p>
                <p class="mb-3">
                    Merci de renseigner le <strong>NIF</strong>, le <strong>RCCM</strong>, le <strong>CFE</strong>
                    ainsi qu’une pièce d’identité ou un passeport (fichiers PDF), puis de confirmer l’ancienneté de l’entreprise.
                </p>
                <p class="mb-3">
                    Après vérification des réglementations et de la conformité de votre entreprise, vous recevrez une réponse
                    <strong>au plus tard dans les quinze (15) jours à venir</strong>.
                    Un <strong>lien de paiement</strong> vous sera ensuite communiqué pour le règlement, conformément aux
                    <strong>règlements de l’Union européenne</strong>.
                </p>
                <p class="mb-0">
                    Cette procédure vise à renforcer la sécurité des projets, à se prémunir contre les
                    <strong>applications mobiles pirates ou malveillantes</strong>, et à garantir une bonne utilisation
                    des services liés à Play Store.
                    <span class="d-block mt-2 small text-secondary">Service — affilié à Google LLC.</span>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-accent" id="visaModalContinue">J’ai compris, continuer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('paymentForm');
    const wisePanel = document.getElementById('wisePanel');
    const visaPanel = document.getElementById('visaPanel');
    const submitBtn = document.getElementById('submitPayment');
    const methodWise = document.getElementById('methodWise');
    const methodVisa = document.getElementById('methodVisa');
    let visaMessageSeen = {{ old('payment_method') === 'visa' ? 'true' : 'false' }};

    function syncPanels() {
        const isVisa = methodVisa.checked;
        wisePanel.classList.toggle('d-none', isVisa);
        visaPanel.classList.toggle('d-none', !isVisa);
        submitBtn.textContent = isVisa
            ? 'Soumettre le dossier Visa — 1 082 USD'
            : 'Valider et payer sur Wise — 1 082 USD';
    }

    methodWise.addEventListener('change', syncPanels);
    methodVisa.addEventListener('change', function () {
        syncPanels();
        if (methodVisa.checked && !visaMessageSeen) {
            const modal = new bootstrap.Modal(document.getElementById('visaCompanyModal'));
            modal.show();
        }
    });

    document.getElementById('visaModalContinue').addEventListener('click', function () {
        visaMessageSeen = true;
        bootstrap.Modal.getInstance(document.getElementById('visaCompanyModal')).hide();
        visaPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    form.addEventListener('submit', function (e) {
        if (methodVisa.checked && !visaMessageSeen) {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('visaCompanyModal'));
            modal.show();
        }
    });

    syncPanels();
});
</script>
@endpush

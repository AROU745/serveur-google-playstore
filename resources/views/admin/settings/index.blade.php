@extends('layouts.admin')

@section('title', 'Paramètres')
@section('heading', 'Paramètres')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nom de l'entreprise</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings['company_name']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email support</label>
                        <input type="email" name="support_email" class="form-control" value="{{ old('support_email', $settings['support_email']) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone support</label>
                        <input type="text" name="support_phone" class="form-control" value="{{ old('support_phone', $settings['support_phone']) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instructions Wise (affichées au client)</label>
                        <textarea name="wise_instructions" rows="6" class="form-control" required>{{ old('wise_instructions', $settings['wise_instructions']) }}</textarea>
                    </div>
                    <button class="btn btn-accent">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6">Configuration .env</h2>
                <ul class="small text-secondary mb-0">
                    <li>WISE_PAYMENT_URL : {{ $wiseUrlConfigured ? 'configurée' : 'non configurée' }}</li>
                    <li>ONLINE_PAYMENT_ENABLED : {{ $onlineEnabled ? 'oui' : 'non' }}</li>
                    <li>Les clés secrètes de paiement ne doivent jamais être exposées au frontend.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

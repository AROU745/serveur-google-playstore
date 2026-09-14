@extends('layouts.app')

@section('title', 'Tarifs — Google Play Server Service')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Tarifs</h1>
        <p>Une offre claire, sans surprise</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="pricing-card">
                    <div class="pricing-badge">Offre principale</div>
                    <h2 class="pricing-name">{{ $plan['name'] }}</h2>
                    <div class="pricing-price">
                        <span class="amount">1 082</span>
                        <span class="currency">USD</span>
                    </div>
                    <p class="pricing-duration">Durée : Indéterminée</p>
                    <hr>
                    <ul class="pricing-features">
                        <li><i class="fa-solid fa-check-circle"></i> Hébergement serveur</li>
                        <li><i class="fa-solid fa-check-circle"></i> Ressources serveur dédiées au projet</li>
                        <li><i class="fa-solid fa-check-circle"></i> Surveillance du serveur</li>
                        <li><i class="fa-solid fa-check-circle"></i> Sauvegardes</li>
                        <li><i class="fa-solid fa-check-circle"></i> Configuration technique</li>
                        <li><i class="fa-solid fa-check-circle"></i> Support technique</li>
                        <li><i class="fa-solid fa-check-circle"></i> Maintenance serveur</li>
                        <li><i class="fa-solid fa-check-circle"></i> Sécurisation de l'infrastructure</li>
                    </ul>
                    <a href="{{ route('payment') }}" class="btn btn-accent btn-lg w-100 mt-3">Souscrire maintenant — 1 082 USD</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Conditions générales — GPSS')

@section('content')
<section class="page-hero">
    <div class="container"><h1>Conditions générales</h1></div>
</section>
<section class="section-pad">
    <div class="container">
        <div class="form-card legal-content">
            <p><strong>Service indépendant — Non affilié à Google LLC.</strong></p>
            <p>Google Play Server Service propose un abonnement d'infrastructure serveur et d'accompagnement technique pour projets d'applications mobiles. Le présent document régit l'accès au site et la souscription au plan à 1 082 USD à durée indéterminée.</p>
            <h2>1. Objet</h2>
            <p>Le service couvre l'hébergement, les ressources associées, la surveillance, les sauvegardes, la configuration, le support, la maintenance et la sécurisation décrits dans l'offre.</p>
            <h2>2. Commande et paiement</h2>
            <p>La commande est validée après confirmation du paiement (Wise ou paiement en ligne). Les délais d'activation dépendent de la vérification du règlement.</p>
            <h2>3. Responsabilités</h2>
            <p>Le client fournit des informations exactes (projet, package, facturation). Le prestataire s'engage à une exploitation raisonnable de l'infrastructure dans le cadre de l'abonnement.</p>
            <h2>4. Marques</h2>
            <p>Google, Google Play et les marques associées appartiennent à leurs propriétaires respectifs. Ce site n'est pas un site officiel Google.</p>
            <h2>5. Contact</h2>
            <p>Pour toute question : page <a href="{{ route('contact') }}">Contact</a>.</p>
        </div>
    </div>
</section>
@endsection

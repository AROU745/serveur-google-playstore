@extends('layouts.app')

@section('title', 'Confidentialité — GPSS')

@section('content')
<section class="page-hero">
    <div class="container"><h1>Politique de confidentialité</h1></div>
</section>
<section class="section-pad">
    <div class="container">
        <div class="form-card legal-content">
            <p><strong>Service indépendant — Non affilié à Google LLC.</strong></p>
            <h2>Données collectées</h2>
            <p>Nous collectons les données nécessaires à la commande : identité, entreprise, email, téléphone, pays, projet, package, adresse de facturation, et informations de paiement déclarées (référence Wise, preuve).</p>
            <h2>Finalités</h2>
            <p>Traitement des commandes, confirmation des paiements, facturation, support client et obligations légales.</p>
            <h2>Conservation</h2>
            <p>Les données sont conservées pendant la durée nécessaire à la relation commerciale et aux exigences comptables.</p>
            <h2>Sécurité</h2>
            <p>Mesures techniques et organisationnelles raisonnables sont appliquées. Aucune clé API secrète de paiement n'est exposée côté navigateur.</p>
            <h2>Vos droits</h2>
            <p>Vous pouvez demander l'accès, la rectification ou la suppression de vos données via la page Contact.</p>
        </div>
    </div>
</section>
@endsection

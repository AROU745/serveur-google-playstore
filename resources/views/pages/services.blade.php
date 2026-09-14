@extends('layouts.app')

@section('title', 'Services — Google Play Server Service')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Nos services</h1>
        <p>Infrastructure et accompagnement technique pour vos projets mobiles</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['fa-server', 'Hébergement serveur', 'Mise à disposition d\'un environnement serveur adapté à votre projet.'],
                ['fa-microchip', 'Ressources dédiées', 'Allocation de ressources pour la charge de votre application.'],
                ['fa-chart-line', 'Surveillance', 'Suivi de disponibilité et d\'indicateurs opérationnels.'],
                ['fa-floppy-disk', 'Sauvegardes', 'Politique de sauvegarde pour limiter les pertes de données.'],
                ['fa-gears', 'Configuration technique', 'Paramétrage initial et mise en route de l\'infrastructure.'],
                ['fa-headset', 'Support technique', 'Assistance pour les questions liées à l\'exploitation serveur.'],
                ['fa-wrench', 'Maintenance', 'Actions de maintenance préventive et corrective.'],
                ['fa-lock', 'Sécurisation', 'Mesures de base pour renforcer la posture de sécurité.'],
            ] as $item)
            <div class="col-md-6 col-lg-3">
                <div class="feature-tile h-100">
                    <div class="feature-icon"><i class="fa-solid {{ $item[0] }}"></i></div>
                    <h3>{{ $item[1] }}</h3>
                    <p>{{ $item[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('payment') }}" class="btn btn-accent btn-lg">Souscrire — 1 082 USD — durée indéterminée</a>
        </div>
    </div>
</section>
@endsection

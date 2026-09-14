@extends('layouts.app')

@section('title', 'Google Play Server Service — Infrastructure serveur')

@section('content')
{{-- Hero --}}
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-7 reveal">
                <p class="eyebrow mb-3"><i class="fa-solid fa-cloud me-2"></i>Infrastructure cloud professionnelle</p>
                <h1 class="hero-title mb-3">Google Play Server Service</h1>
                <p class="hero-subtitle mb-4">
                    Infrastructure serveur et accompagnement technique pour applications mobiles
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('payment') }}" class="btn btn-accent btn-lg">
                        Souscrire maintenant — 1 082 USD
                    </a>
                    <a href="#offre" class="btn btn-outline-light btn-lg">Voir l'offre</a>
                </div>
                <p class="mt-4 small text-white-50">
                    Service indépendant — Non affilié à Google LLC
                </p>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0 reveal delay-1">
                <div class="hero-visual">
                    <div class="server-panel">
                        <div class="server-panel-header">
                            <span></span><span></span><span></span>
                            <em>gpss-node-01</em>
                        </div>
                        <div class="server-metrics">
                            <div><label>Uptime</label><strong>99.9%</strong></div>
                            <div><label>Surveillance</label><strong>24/7</strong></div>
                            <div><label>Sauvegardes</label><strong>Quotidiennes</strong></div>
                            <div><label>Support</label><strong>Dédié</strong></div>
                        </div>
                        <div class="server-bars">
                            <div class="bar" style="--h:70%"></div>
                            <div class="bar" style="--h:45%"></div>
                            <div class="bar" style="--h:85%"></div>
                            <div class="bar" style="--h:60%"></div>
                            <div class="bar" style="--h:90%"></div>
                            <div class="bar" style="--h:55%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Présentation --}}
<section class="section-pad" id="presentation">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8 reveal">
                <h2 class="section-title">Présentation du serveur</h2>
                <p class="section-lead">
                    Une infrastructure pensée pour accompagner vos projets d'applications mobiles :
                    disponibilité, sécurité et maintenance opérationnelle à durée indéterminée.
                </p>
            </div>
        </div>
        <div class="row g-4">
            @foreach([
                ['fa-microchip', 'Ressources dédiées', 'Capacité serveur allouée spécifiquement à votre projet.'],
                ['fa-shield-halved', 'Sécurisation', 'Durcissement, accès contrôlés et bonnes pratiques réseau.'],
                ['fa-eye', 'Surveillance', 'Monitoring proactif pour détecter et prévenir les incidents.'],
                ['fa-database', 'Sauvegardes', 'Copies régulières pour protéger vos données critiques.'],
            ] as $i => $item)
            <div class="col-md-6 col-lg-3 reveal delay-{{ $i }}">
                <div class="feature-tile h-100">
                    <div class="feature-icon"><i class="fa-solid {{ $item[0] }}"></i></div>
                    <h3>{{ $item[1] }}</h3>
                    <p>{{ $item[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Avantages --}}
<section class="section-pad bg-soft">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <h2 class="section-title">Pourquoi nous choisir</h2>
                <p class="section-lead mb-4">
                    Un accompagnement clair, sans confusion de marque : nous fournissons
                    l'infrastructure et le support technique autour de votre projet.
                </p>
                <ul class="advantage-list">
                    <li><i class="fa-solid fa-check"></i> Configuration technique initiale incluse</li>
                    <li><i class="fa-solid fa-check"></i> Maintenance serveur continue</li>
                    <li><i class="fa-solid fa-check"></i> Support technique dédié</li>
                    <li><i class="fa-solid fa-check"></i> Durée de souscription indéterminée</li>
                    <li><i class="fa-solid fa-check"></i> Transparence : service indépendant</li>
                </ul>
            </div>
            <div class="col-lg-6 reveal delay-1">
                <div class="info-panel">
                    <h3 class="h5 mb-3">Périmètre typique</h3>
                    <p class="mb-3 text-secondary">Hébergement et exploitation d'environnements serveur liés à votre application mobile et à vos besoins backend.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="chip">Hébergement</span>
                        <span class="chip">Monitoring</span>
                        <span class="chip">Backups</span>
                        <span class="chip">Sécurité</span>
                        <span class="chip">Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Offre --}}
<section class="section-pad" id="offre">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 reveal">
                <div class="pricing-card">
                    <div class="pricing-badge">Offre principale</div>
                    <h2 class="pricing-name">{{ $plan['name'] }}</h2>
                    <div class="pricing-price">
                        <span class="amount">1 082</span>
                        <span class="currency">USD</span>
                    </div>
                    <p class="pricing-duration"><i class="fa-regular fa-calendar me-2"></i>Durée : Indéterminée</p>
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
                    <a href="{{ route('payment') }}" class="btn btn-accent btn-lg w-100 mt-3">
                        Souscrire maintenant — 1 082 USD
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="section-pad bg-soft" id="faq">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center reveal">
                <h2 class="section-title">FAQ</h2>
                <p class="section-lead">Réponses aux questions les plus fréquentes.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 reveal">
                <div class="accordion" id="faqAccordion">
                    @foreach([
                        ['Êtes-vous Google ?', 'Non. Google Play Server Service est un service indépendant, non affilié à Google LLC. Nous ne représentons pas Google et n\'utilisons pas ses marques officielles.'],
                        ['Que comprend le plan à 1 082 USD ?', 'Un abonnement à durée indéterminée incluant hébergement, ressources dédiées, surveillance, sauvegardes, configuration, support, maintenance et sécurisation.'],
                        ['Quels moyens de paiement acceptez-vous ?', 'Paiement via Wise (disponible) et paiement en ligne (carte / Mobile Money) en cours d\'intégration Visa & IBAN européen.'],
                        ['Comment se passe la confirmation Wise ?', 'Après le virement, vous déclarez le paiement avec le numéro de transaction et une preuve. Notre équipe valide ensuite votre commande.'],
                    ] as $i => $faq)
                    <div class="accordion-item faq-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                                {{ $faq[0] }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">{{ $faq[1] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container text-center reveal">
        <h2 class="mb-3">Prêt à déployer votre infrastructure ?</h2>
        <p class="mb-4 opacity-75">Souscrivez au plan serveur à durée indéterminée et démarrez avec une base technique solide.</p>
        <a href="{{ route('payment') }}" class="btn btn-accent btn-lg">Souscrire maintenant — 1 082 USD</a>
    </div>
</section>
@endsection

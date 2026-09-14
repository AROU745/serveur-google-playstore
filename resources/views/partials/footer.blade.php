<footer class="site-footer">
    <div class="container">
        <div class="row g-4 py-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-mark brand-mark-sm"><i class="fa-solid fa-server"></i></span>
                    <strong>Google Play Server Service</strong>
                </div>
                <p class="text-muted-footer mb-0">
                    Infrastructure serveur et accompagnement technique pour projets d'applications mobiles.
                </p>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-title">Navigation</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('pricing') }}">Tarifs</a></li>
                    <li><a href="{{ route('console') }}">Console</a></li>
                    <li><a href="{{ route('payment') }}">Souscrire</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h6 class="footer-title">Légal</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('terms') }}">Conditions générales</a></li>
                    <li><a href="{{ route('privacy') }}">Confidentialité</a></li>
                    <li><a href="{{ route('refund') }}">Politique de remboursement</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="footer-title">Offre</h6>
                <p class="text-muted-footer mb-2">Plan Serveur — 1 082 USD — durée indéterminée</p>
                <a href="{{ route('payment') }}" class="btn btn-outline-light btn-sm">Souscrire maintenant</a>
            </div>
        </div>
        <div class="footer-bottom py-3 border-top border-secondary border-opacity-25">
            <div class="row align-items-center g-2">
                <div class="col-md-7">
                    <p class="mb-0 disclaimer-text">
                        <i class="fa-solid fa-shield-halved me-1"></i>
                        Service indépendant — Non affilié à Google LLC
                    </p>
                </div>
                <div class="col-md-5 text-md-end">
                    <small class="text-muted-footer">&copy; {{ date('Y') }} Google Play Server Service. Tous droits réservés.</small>
                </div>
            </div>
        </div>
    </div>
</footer>

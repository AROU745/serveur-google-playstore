<header class="site-header sticky-top">
    <div class="account-bar">
        <div class="container d-flex align-items-center justify-content-between gap-2">
            <div class="account-bar-label">
                <i class="fa-solid fa-user-shield me-2"></i>
                {{ config('services.account_owner.label', 'Espace personnel') }}
            </div>
            <div class="account-owner-chip">
                <span class="account-avatar" aria-hidden="true">
                    {{ collect(explode(' ', config('services.account_owner.name', 'Marina God Favour')))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
                </span>
                <span class="account-owner-meta">
                    <strong>{{ config('services.account_owner.name', 'Marina God Favour') }}</strong>
                    <small>Compte propriétaire</small>
                </span>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-mark"><i class="fa-solid fa-server"></i></span>
                <span class="brand-text">
                    <strong>Google Play Server Service</strong>
                    <small>Espace de {{ config('services.account_owner.name', 'Marina God Favour') }}</small>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Tarifs</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-console btn-sm px-3 d-inline-flex align-items-center gap-2 {{ request()->routeIs('console') ? 'active' : '' }}"
                           href="{{ route('console') }}">
                            <img src="{{ asset('images/apps/rapidtogo.svg') }}"
                                 alt="RapidTogo"
                                 class="console-app-logo"
                                 width="22"
                                 height="22">
                            <span>Console</span>
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-flex ms-lg-2">
                        <div class="nav-account-pill">
                            <i class="fa-solid fa-circle-user me-2"></i>
                            <span>{{ config('services.account_owner.name', 'Marina God Favour') }}</span>
                        </div>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-accent btn-sm px-3" href="{{ route('payment') }}">Souscrire</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

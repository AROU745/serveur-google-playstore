<aside class="admin-sidebar">
    <div class="admin-brand">
        <i class="fa-solid fa-server me-2"></i>
        <span>GPSS Admin</span>
    </div>
    <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i> Tableau de bord
        </a>
        <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="fa-solid fa-bag-shopping"></i> Commandes
        </a>
        <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Clients
        </a>
        <a href="{{ route('admin.invoices') }}" class="{{ request()->routeIs('admin.invoices') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice"></i> Factures
        </a>
        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i> Paramètres
        </a>
        <a href="{{ route('home') }}" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Voir le site
        </a>
    </nav>
</aside>

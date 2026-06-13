<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ElectroStock') - ElectroStock</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('produits.index') }}"
                class="{{ request()->routeIs('produits.*') ? 'active' : '' }}">Produits</a>
            <a href="{{ route('clients.index') }}"
                class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">Clients</a>
            <a href="{{ route('factures.index') }}"
                class="{{ request()->routeIs('factures.*') ? 'active' : '' }}">Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">Nouvelle Facture</a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
                style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">Mon Profil</a>
        </nav>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">Déconnexion</button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">

        <header class="main-header">
            <h1>@yield('page_title', 'ElectroStock')</h1>
            <div class="user-info">
                Bienvenue, <strong>{{ auth()->user()->name }}</strong>
            </div>
        </header>

        <main class="main-content">
            @yield('content')
        </main>

        <footer class="main-footer">
            &copy; {{ date('Y') }} ElectroStock - Gestion de Stock des Produits Electroniques. Tous droits
            réservés.
        </footer>

    </div>

    @yield('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ElectroStock') - ElectroStock</title>
    
    <!-- TOUT LE CSS GLOBAL ICI -->
    <style>
        /* --- STRUCTURE GLOBALE --- */
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; display: flex; min-height: 100vh; }
        
        /* --- SIDEBAR --- */
        .sidebar { width: 260px; background-color: #2b2d42; color: #fff; padding: 20px 0; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; z-index: 100; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #3d405b; text-align: center; }
        .sidebar-header h2 { margin: 0; font-size: 20px; color: #ef233c; }
        .sidebar-nav { flex: 1; padding: 20px 10px; }
        .sidebar-nav a { display: block; color: #edf2f4; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 5px; transition: background 0.3s; font-size: 15px; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #3d405b; color: #fff; }
        .logout-form { padding: 0 10px 20px; margin-top: auto; }
        .logout-form button { width: 100%; background: #ef233c; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .logout-form button:hover { background: #d90429; }

        /* --- CONTENU PRINCIPAL --- */
        .main-wrapper { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-height: 100vh; }
        
        /* Header */
        .main-header { background: #fff; padding: 15px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .main-header h1 { margin: 0; font-size: 20px; color: #2b2d42; }
        .user-info { font-size: 14px; color: #666; }
        .user-info a { color: #ef233c; text-decoration: none; font-weight: bold; }

        /* Content */
        .main-content { flex: 1; padding: 30px; }

        /* Footer */
        .main-footer { background: #fff; padding: 15px 30px; text-align: center; color: #888; font-size: 13px; border-top: 1px solid #eee; }

        /* --- COMPOSANTS UI GLOBAUX --- */
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        .form-row { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 15px; }
        .form-group { flex: 1; min-width: 200px; display: flex; flex-direction: column; margin-bottom: 15px; }
        .form-group label { margin-bottom: 8px; font-weight: bold; color: #555; font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group select:focus { border-color: #007bff; outline: none; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        tr:hover { background-color: #f1f1f1; }
        .action-btns { display: flex; gap: 5px; }

        /* Classes conditionnelles Stock */
        .stock-rupture { background-color: #f8d7da !important; color: #721c24; font-weight: bold; }
        .stock-faible { background-color: #fff3cd !important; color: #856404; }
        .stock-ok { background-color: #d4edda !important; color: #155724; }
    </style>
    @yield('styles') <!-- Pour le CSS spécifique à une page (ex: Chart.js, PDF) -->
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>📱 ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('produits.index') }}" class="{{ request()->routeIs('produits.*') ? 'active' : '' }}">📦 Produits</a>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">👥 Clients</a>
            <a href="{{ route('factures.index') }}" class="{{ request()->routeIs('factures.*') ? 'active' : '' }}">🧾 Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">➕ Nouvelle Facture</a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}" style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">👤 Mon Profil</a>
        </nav>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">🚪 Déconnexion</button></form>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        
        <!-- HEADER -->
        <header class="main-header">
            <h1>@yield('page_title', 'ElectroStock')</h1>
            <div class="user-info">
                Bienvenue, <strong>{{ auth()->user()->name }}</strong>
            </div>
        </header>

        <!-- CONTENU DYNAMIQUE DES PAGES -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="main-footer">
            &copy; {{ date('Y') }} ElectroStock - Gestion de Stock des Produits Electroniques. Tous droits réservés.
        </footer>

    </div>

    @yield('scripts') <!-- Pour le JS spécifique à une page (ex: Chart.js, Facture) -->
</body>
</html>
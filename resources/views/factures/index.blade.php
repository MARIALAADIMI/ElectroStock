<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
    <style>
        /* CSS IDENTIQUE AU DASHBOARD & AUTRES PAGES */
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #2b2d42; color: #fff; padding: 20px 0; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #3d405b; text-align: center; }
        .sidebar-header h2 { margin: 0; font-size: 20px; color: #ef233c; }
        .sidebar-nav { flex: 1; padding: 20px 10px; }
        .sidebar-nav a { display: block; color: #edf2f4; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 5px; transition: background 0.3s; font-size: 15px; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #3d405b; color: #fff; }
        .logout-form { padding: 0 10px 20px; margin-top: auto; }
        .logout-form button { width: 100%; background: #ef233c; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .logout-form button:hover { background: #d90429; }

        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        .page-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .page-header h1 { margin: 0; color: #333; }
        
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        tr:hover { background-color: #f1f1f1; }
        .action-btns { display: flex; gap: 5px; }

        .search-form { display: flex; gap: 10px; }
        .search-form input { padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('produits.index') }}">Produits</a>
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('factures.index') }}" class="active">Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">Nouvelle Facture</a>
             <a href="{{ route('profile.edit') }}" style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">Mon Profil</a>

        </nav>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">Déconnexion</button></form>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="main-content">
        
        <div class="page-header">
            <h1>Liste des Factures</h1>
            <div style="display: flex; gap: 10px; align-items: center;">
                <form action="{{ route('factures.index') }}" method="GET" class="search-form">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher N° ou client...">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">🔍</button>
                    @if(request('query'))
                        <a href="{{ route('factures.index') }}" class="btn" style="background: #6c757d; color: white; padding: 8px 15px;">X</a>
                    @endif
                </form>
                <a href="{{ route('factures.create') }}" class="btn btn-success">Nouvelle Facture</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>N° Facture</th>
                        <th>Client</th>
                        <th>CIN</th>
                        <th>Date</th>
                        <th>Montant Total</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factures as $facture)
                        <tr>
                            <td><strong>#{{ $facture->id }}</strong></td>
                            <td>{{ $facture->client->nom }} {{ $facture->client->prenom }}</td>
                            <td>{{ $facture->client->cin }}</td>
                            <td>{{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</td>
                            <td><strong>{{ number_format($facture->montant_total, 2) }} DH</strong></td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('factures.show', $facture->id) }}" class="btn btn-info" style="font-size: 12px; padding: 6px 12px;">👁 Voir</a>
                                    <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">📄 PDF</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: center;">
                {{ $factures->withQueryString()->links() }}
            </div>
        </div>

    </main>
</body>
</html>
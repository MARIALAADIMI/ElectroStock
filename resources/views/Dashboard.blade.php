<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* --- STRUCTURE GLOBALE --- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: #2b2d42;
            /* Couleur sombre élégante */
            color: #fff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #3d405b;
            text-align: center;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
            color: #ef233c;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 10px;
        }

        .sidebar-nav a {
            display: block;
            color: #edf2f4;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: background 0.3s;
            font-size: 15px;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #3d405b;
            color: #fff;
        }

        .sidebar-section {
            padding: 0 15px;
            margin-top: 20px;
            border-top: 1px solid #3d405b;
            padding-top: 15px;
        }

        .sidebar-section h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #8d99ae;
            margin-bottom: 10px;
        }

        .mini-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mini-list li {
            font-size: 13px;
            margin-bottom: 8px;
            color: #edf2f4;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #3d405b;
            padding-bottom: 5px;
        }

        .mini-list li span:last-child {
            font-weight: bold;
            color: #ef233c;
            /* Couleur d'accent */
        }

        .logout-form {
            padding: 0 10px 20px;
        }

        .logout-form button {
            width: 100%;
            background: #ef233c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-form button:hover {
            background: #d90429;
        }

        /* --- CONTENU PRINCIPAL --- */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            color: #555;
            font-size: 14px;
            text-transform: uppercase;
        }

        .stat-card p {
            margin: 10px 0 0;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .col-8 {
            flex: 66.66%;
            min-width: 400px;
        }

        .col-4 {
            flex: 33.33%;
            min-width: 250px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .alert-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        .alert-item {
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
        }

        .alert-rouge {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-orange {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('produits.index') }}">Produits</a>
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('factures.index') }}">Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">Nouvelle Facture</a>
            <a href="{{ route('profile.edit') }}"
                style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">Mon Profil</a>

        </nav>

        <div class="sidebar-section">
            <h4>Top Ventes</h4>
            <ul class="mini-list">
                @foreach ($topProduits as $item)
                    <li>
                        <span>{{ $item->produit->libelle ?? 'Supprimé' }}</span>
                        <span>{{ $item->total_vendu }} pcs</span>
                    </li>
                @endforeach
                @if ($topProduits->isEmpty())
                    <li style="justify-content: center; color: #8d99ae;">Aucune vente</li>
                @endif
            </ul>
        </div>

        <div class="sidebar-section">
            <h4>Dernières Factures</h4>
            <ul class="mini-list">
                @foreach ($recentFactures as $facture)
                    <li>
                        <span>#{{ $facture->id }} - {{ $facture->client->nom }}</span>
                        <span>{{ number_format($facture->montant_total, 0) }} MAD</span>
                    </li>
                @endforeach
                @if ($recentFactures->isEmpty())
                    <li style="justify-content: center; color: #8d99ae;">Aucune facture</li>
                @endif
            </ul>
        </div>

        <div class="logout-form" style="margin-top: auto;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    </aside>

    <main class="main-content">

        <div class="header">
            <h1>Tableau de Bord</h1>
            <div>Bienvenue, {{ auth()->user()->name }} !</div>
        </div>

        <div class="stats-container">
            <div class="stat-card" style="border-left: 5px solid #007bff;">
                <h3>Total Stock</h3>
                <p>{{ $Totalstock }}</p>
            </div>

            <div class="stat-card" style="border-left: 5px solid #17a2b8;">
                <h3>Produits</h3>
                <p>{{ $TotalProduits }}</p>
            </div>

            <div class="stat-card" style="border-left: 5px solid #28a745;">
                <h3>Clients</h3>
                <p>{{ $TotalClient }}</p>
            </div>

            <div class="stat-card" style="border-left: 5px solid #ffc107;">
                <h3>Chiffre d'affaires</h3>
                <p>{{ number_format($TotalRevenu, 2) }} MAD</p>
            </div>
        </div>

        <div class="row">

            <div class="col-8">
                <div class="card">
                    <h2>Graphique des Ventes par Mois ({{ date('Y') }})</h2>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <h2>Alertes Stock</h2>
                    <ul class="alert-list">
                        @foreach ($ReptureStock as $p)
                            <li class="alert-item alert-rouge">
                                <span>{{ $p->libelle }}</span>
                                <span><strong>Rupture (0)</strong></span>
                            </li>
                        @endforeach

                        @foreach ($StockFaible as $p)
                            <li class="alert-item alert-orange">
                                <span>{{ $p->libelle }}</span>
                                <span><strong>Faible ({{ $p->qte }})</strong></span>
                            </li>
                        @endforeach

                        @if ($ReptureStock->isEmpty() && $StockFaible->isEmpty())
                            <li class="alert-item alert-success">
                                Aucune alerte, tout est OK !
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const salesData = @json($RevenusByMounth);

            const ctx = document.getElementById('salesChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov',
                        'Déc'
                    ],
                    datasets: [{
                        label: 'Ventes (MAD)',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' MAD';
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>

</body>

</html>

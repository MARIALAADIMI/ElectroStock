<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture N° {{ $facture->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #2b2d42; color: #fff; padding: 20px 0; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #3d405b; text-align: center; }
        .sidebar-header h2 { margin: 0; font-size: 20px; color: #ef233c; }
        .sidebar-nav { flex: 1; padding: 20px 10px; }
        .sidebar-nav a { display: block; color: #edf2f4; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 5px; transition: background 0.3s; font-size: 15px; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #3d405b; color: #fff; }
        .logout-form { padding: 0 10px 20px; margin-top: auto; }
        .logout-form button { width: 100%; background: #ef233c; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }

        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        
        /* CSS SPÉCIFIQUE FACTURE */
        .invoice-box { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; }
        .header-invoice { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #2b2d42; padding-bottom: 20px; }
        .header-invoice h1 { margin: 0; color: #2b2d42; }
        .client-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #2b2d42; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        .total-section { text-align: right; margin-top: 20px; font-size: 22px; font-weight: bold; color: #ef233c; }
        
        .no-print { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { opacity: 0.8; }

        /* CACHER LE SIDEBAR ET LES BOUTONS LORS DE L'IMPRESSION NAVIGATEUR */
        @media print {
            .sidebar, .no-print { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .invoice-box { box-shadow: none !important; }
        }
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

    <!-- CONTENU -->
    <main class="main-content">
        
        <!-- Boutons d'action (disparaissent à l'impression) -->
        <div class="no-print">
            <a href="{{ route('factures.index') }}" class="btn btn-secondary">⬅ Retour à la liste</a>
            <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-primary">Télécharger PDF</a>
            <button onclick="window.print()" class="btn btn-primary" style="background: #28a745;">Imprimer</button>
        </div>

        <div class="invoice-box">
            <!-- En-tête Facture -->
            <div class="header-invoice">
                <div>
                    <h1>FACTURE</h1>
                    <p><strong>N° :</strong> {{ $facture->id }}</p>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</p>
                </div>
                <div style="text-align: right;">
                    <h2 style="color: #ef233c; margin:0;">ElectroStock</h2>
                    <p style="margin:0;">Gestion de produits électroniques</p>
                </div>
            </div>

            <!-- Info Client -->
            <div class="client-info">
                <h3 style="margin-top:0; color:#2b2d42;">Client</h3>
                <p><strong>Nom :</strong> {{ $facture->client->nom }} {{ $facture->client->prenom }}</p>
                <p><strong>CIN :</strong> {{ $facture->client->cin }} | <strong>Tél :</strong> {{ $facture->client->tel }}</p>
            </div>

            <!-- Tableau Détails -->
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th style="text-align:center;">Quantité</th>
                        <th style="text-align:right;">Prix Unitaire</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facture->details as $detail)
                        <tr>
                            <td>{{ $detail->produit->libelle }}</td>
                            <td style="text-align:center;">{{ $detail->qte_prod }}</td>
                            <td style="text-align:right;">{{ number_format($detail->prix_unitaire_prod, 2) }} DH</td>
                            <td style="text-align:right;">{{ number_format($detail->qte_prod * $detail->prix_unitaire_prod, 2) }} DH</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total -->
            <div class="total-section">
                Montant Total : {{ number_format($facture->montant_total, 2) }} DH
            </div>
        </div>

    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Facture</title>
    <style>
        /* CSS IDENTIQUE (Raccourci pour l'exemple, mets le même que index) */
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
        .page-header { margin-bottom: 30px; }
        .page-header h1 { margin: 0; color: #333; }
        
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }

        .form-group { margin-bottom: 20px; display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 8px; font-weight: bold; color: #555; }
        .form-group select, .form-group input { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
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
            <h1>Création de Facture</h1>
        </div>

        @if (session('error'))
            <div class="alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('factures.store') }}" method="POST">
            @csrf
            
            <!-- Sélection du Client -->
            <div class="card">
                <h2>Informations Client</h2>
                <div class="form-group" style="max-width: 400px;">
                    <label for="client_id">Sélectionner un client</label>
                    <select name="client_id" id="client_id" required>
                        <option value="">-- Choisir un client --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }} (CIN: {{ $client->cin }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sélection des Produits -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h2 style="margin: 0; border: none; padding: 0;">Produits</h2>
                    <button type="button" onclick="addProduit()" class="btn btn-success" style="font-size: 13px;">➕ Ajouter une ligne</button>
                </div>

                <table id="produits-table">
                    <thead>
                        <tr>
                            <th style="width: 60%;">Produit</th>
                            <th style="width: 20%;">Quantité</th>
                            <th style="width: 20%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="produits[0][id]" required style="width: 100%; padding: 8px;">
                                    <option value="">-- Choisir un produit --</option>
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->libelle }} (Stock: {{ $produit->qte }} | Prix: {{ $produit->prix }} DH)</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="produits[0][qte]" min="1" value="1" required style="width: 100%; padding: 8px;"></td>
                            <td>
                                <button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger" style="padding: 8px 12px;">🗑</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px;">✅ Valider la Facture</button>
                <a href="{{ route('factures.index') }}" class="btn btn-secondary" style="padding: 12px 30px;">Annuler</a>
            </div>
        </form>

    </main>

    <script>
        let produitIndex = 1;

        // On échappe les quotes pour le JS
        const produitOptions = `@foreach ($produits as $produit)<option value="{{ $produit->id }}">{{ $produit->libelle }} (Stock: {{ $produit->qte }} | Prix: {{ $produit->prix }} DH)</option>@endforeach`;

        function addProduit() {
            const tableBody = document.getElementById('produits-table').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();

            newRow.innerHTML = `
                <td>
                    <select name="produits[${produitIndex}][id]" required style="width: 100%; padding: 8px;">
                        <option value="">-- Choisir un produit --</option>
                        ${produitOptions}
                    </select>
                </td>
                <td><input type="number" name="produits[${produitIndex}][qte]" min="1" value="1" required style="width: 100%; padding: 8px;"></td>
                <td>
                    <button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger" style="padding: 8px 12px;">🗑</button>
                </td>
            `;
            produitIndex++;
        }
    </script>
</body>
</html>
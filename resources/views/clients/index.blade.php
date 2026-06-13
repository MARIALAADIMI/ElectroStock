<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <style>
        /* --- COPIE DU CSS GLOBAL DU DASHBOARD --- */
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
        
        /* --- CONTENU PRINCIPAL --- */
        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        .page-header { margin-bottom: 30px; }
        .page-header h1 { margin: 0; color: #333; }

        /* --- CARTES & FORMULAIRES --- */
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }
        
        .form-row { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 15px; }
        .form-group { flex: 1; min-width: 200px; display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; font-size: 14px; }
        .form-group input { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus { border-color: #007bff; outline: none; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        /* --- TABLEAUX --- */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        tr:hover { background-color: #f1f1f1; }
        .action-btns { display: flex; gap: 5px; }
        .action-btns form { margin: 0; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('produits.index') }}">Produits</a>
            <a href="{{ route('clients.index') }}" class="active">Clients</a>
            <a href="{{ route('factures.index') }}">Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">Nouvelle Facture</a>
             <a href="{{ route('profile.edit') }}" style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">Mon Profil</a>
        
        </nav>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">Déconnexion</button></form>
        </div>
    </aside>
    <main class="main-content">
        
        <div class="page-header">
            <h1>Gestion des Clients</h1>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif
        <div class="card">
            <h2>{{ isset($editClient) ? 'Modifier le client' : 'Ajouter un client' }}</h2>
            @if (isset($editClient))
                <a href="{{ route('clients.index') }}" style="color: #dc3545; text-decoration: none; font-size: 14px; display: block; margin-bottom: 15px;">Annuler la modification</a>
            @endif

            <form action="{{ isset($editClient) ? route('clients.update', $editClient->id) : route('clients.store') }}" method="POST">
                @csrf
                @if (isset($editClient)) @method('PUT') @endif
               
                <div class="form-row">
                    <div class="form-group">
                        <label>CIN</label>
                        <input type="text" name="cin" value="{{ old('cin', $editClient->cin ?? '') }}" placeholder="Ex: AB123456" required>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $editClient->nom ?? '') }}" placeholder="Nom du client" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $editClient->prenom ?? '') }}" placeholder="Prénom du client" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="tel" value="{{ old('tel', $editClient->tel ?? '') }}" placeholder="0612345678" required>
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary">{{ isset($editClient) ? 'Enregistrer' : 'Ajouter' }}</button>
                    <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                </div>
            </form>
        </div>
        <div class="card">
            <h2>Liste des Clients ({{ $clients->count() }})</h2>
            <table>
                <thead>
                    <tr>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td><strong>{{ $client->cin }}</strong></td>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td>{{ $client->tel }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('clients.index', ['edit' => $client->id]) }}" class="btn btn-warning" style="font-size: 12px; padding: 5px 10px;">Modifier</a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="return confirm('Supprimer ce client ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: center;">
                {{ $clients->links() }}
            </div>
        </div>

    </main>
</body>
</html>
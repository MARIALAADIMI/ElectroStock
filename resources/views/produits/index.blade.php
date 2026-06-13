<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <style>
        /* CSS IDENTIQUE AU DASHBOARD & CLIENTS */
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
        .page-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { margin: 0; color: #333; }
        
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }
        
        .form-row { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 15px; }
        .form-group { flex: 1; min-width: 150px; display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group textarea:focus { border-color: #007bff; outline: none; }
        .form-group textarea { resize: vertical; min-height: 40px; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        tr:hover { background-color: #f1f1f1; }
        
        .action-btns { display: flex; gap: 5px; }
        .action-btns form { margin: 0; }

        /* COULEURS CONDITIONNELLES POUR LE STOCK */
        .stock-rupture { background-color: #f8d7da !important; color: #721c24; font-weight: bold; }
        .stock-faible { background-color: #fff3cd !important; color: #856404; }
        .stock-ok { background-color: #d4edda !important; color: #155724; }

        .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; }
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
            <a href="{{ route('produits.index') }}" class="active">Produits</a>
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('factures.index') }}">Factures</a>
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
            <h1>Gestion des Produits</h1>
            <form action="{{ route('produits.index') }}" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher..." style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">🔍</button>
                @if (request('query'))
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary" style="padding: 8px 15px;">X</a>
                @endif
            </form>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <!-- FORMULAIRE -->
        <div class="card">
            <h2>{{ isset($editProduit) ? 'Modifier le produit' : 'Ajouter un produit' }}</h2>
            @if (isset($editProduit))
                <a href="{{ route('produits.index') }}" style="color: #dc3545; text-decoration: none; font-size: 14px; display: block; margin-bottom: 15px;">❌ Annuler la modification</a>
            @endif

            <form action="{{ isset($editProduit) ? route('produits.update', $editProduit->id) : route('produits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($editProduit)) @method('PUT') @endif
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" name="code" value="{{ old('code', $editProduit->code ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Libellé</label>
                        <input type="text" name="libelle" value="{{ old('libelle', $editProduit->libelle ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Prix (MAD)</label>
                        <input type="number" step="0.01" name="prix" value="{{ old('prix', $editProduit->prix ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Quantité en stock</label>
                        <input type="number" name="qte" value="{{ old('qte', $editProduit->qte ?? '') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>Description</label>
                        <textarea name="description">{{ old('description', $editProduit->description ?? '') }}</textarea>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Image</label>
                        <input type="file" name="image" style="padding: 7px;">
                        @if( isset($editProduit) && $editProduit->image)
                            <div style="margin-top: 10px; font-size: 12px; color: #666;">
                                Image actuelle :<br>
                                <img src="{{ asset('storage/'.$editProduit->image) }}" alt="" class="product-img">
                            </div>
                        @endif
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary">{{ isset($editProduit) ? 'Enregistrer' : 'Ajouter' }}</button>
                    <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                </div>
            </form>
        </div>

        <!-- TABLEAU -->
        <div class="card">
            <h2>Liste des Produits ({{ $produits->total() }})</h2>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        @php
                            $stockClass = '';
                            if ($produit->qte == 0) { $stockClass = 'stock-rupture'; }
                            elseif ($produit->qte < 10) { $stockClass = 'stock-faible'; }
                            else { $stockClass = 'stock-ok'; }
                        @endphp

                        <tr class="{{ $stockClass }}">
                            <td>
                                @if ($produit->image)
                                    <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->libelle }}" class="product-img">
                                @else
                                    <div style="width: 50px; height: 50px; background: #eee; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 10px;">N/A</div>
                                @endif
                            </td>
                            <td><strong>{{ $produit->code }}</strong></td>
                            <td>{{ $produit->libelle }}</td>
                            <td>{{ number_format($produit->prix, 2) }} MAD</td>
                            <td>
                                {{ $produit->qte }}
                                @if($produit->qte == 0) <span style="font-size:10px;">(Rupture)</span>
                                @elseif($produit->qte < 10) <span style="font-size:10px;">(Faible)</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($produit->description, 40) }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('produits.index', ['edit' => $produit->id, 'query' => request('query')]) }}" class="btn btn-warning" style="font-size: 12px; padding: 5px 10px;">Modifier</a>
                                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: center;">
                {{ $produits->appends(request()->query())->links() }}
            </div>
        </div>

    </main>
</body>
</html>
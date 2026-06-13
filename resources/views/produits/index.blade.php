@extends('layouts.app')

@section('title', 'Produits')
@section('page_title', 'Gestion des Produits')

@section('content')
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h2>{{ isset($editProduit) ? '✏️ Modifier le produit' : '➕ Ajouter un produit' }}</h2>
        @if (isset($editProduit))
            <a href="{{ route('produits.index') }}"
                style="color: #dc3545; text-decoration: none; font-size: 14px; display: block; margin-bottom: 15px;">❌
                Annuler la modification</a>
        @endif

        <form action="{{ isset($editProduit) ? route('produits.update', $editProduit->id) : route('produits.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($editProduit))
                @method('PUT')
            @endif

            <div class="form-row">
                <div class="form-group"><label>Code</label><input type="text" name="code"
                        value="{{ old('code', $editProduit->code ?? '') }}" required></div>
                <div class="form-group"><label>Libellé</label><input type="text" name="libelle"
                        value="{{ old('libelle', $editProduit->libelle ?? '') }}" required></div>
                <div class="form-group"><label>Prix (MAD)</label><input type="number" step="0.01" name="prix"
                        value="{{ old('prix', $editProduit->prix ?? '') }}" required></div>
                <div class="form-group"><label>Quantité</label><input type="number" name="qte"
                        value="{{ old('qte', $editProduit->qte ?? '') }}" required></div>
            </div>
            <div class="form-row">
                <div class="form-group" style="flex: 2;"><label>Description</label>
                    <textarea name="description">{{ old('description', $editProduit->description ?? '') }}</textarea>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Image</label><input type="file" name="image">
                    @if (isset($editProduit) && $editProduit->image)
                        <img src="{{ asset('storage/' . $editProduit->image) }}"
                            style="width: 50px; margin-top: 10px; border-radius: 5px;">
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($editProduit) ? 'Enregistrer' : 'Ajouter' }}</button>
            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
        </form>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin:0; border:none; padding:0;">Liste des Produits ({{ $produits->total() }})</h2>
            <form action="{{ route('produits.index') }}" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher..."
                    style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">🔍</button>
                @if (request('query'))
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary" style="padding: 8px 15px;">X</a>
                @endif
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                    @php $stockClass = $produit->qte == 0 ? 'stock-rupture' : ($produit->qte < 10 ? 'stock-faible' : 'stock-ok'); @endphp
                    <tr class="{{ $stockClass }}">
                        <td>
                            @if ($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}"
                                    style="width: 40px; border-radius: 5px;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td><strong>{{ $produit->code }}</strong></td>
                        <td>{{ $produit->libelle }}</td>
                        <td>{{ number_format($produit->prix, 2) }} DH</td>
                        <td>{{ $produit->qte }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('produits.index', ['edit' => $produit->id, 'query' => request('query')]) }}"
                                    class="btn btn-warning" style="font-size: 12px; padding: 5px 10px;">Modifier</a>
                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST">@csrf
                                    @method('DELETE') <button type="submit" class="btn btn-danger"
                                        style="font-size: 12px; padding: 5px 10px;"
                                        onclick="return confirm('Supprimer ?')">Supprimer</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $produits->appends(request()->query())->links('partials.pagination') }}
    </div>
@endsection

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
</head>

<body>
    <div class="">
        <div class="">
            <h2>{{ isset($editProduit) ? 'Modifier le produit' : 'Ajouter un produit' }}</h2>
        </div>

        @if (isset($editProduit))
            <a href="{{ route('produits.index') }}">Annuler la modification</a>
        @endif

        @if (session('success'))
            <div class="">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($editProduit) ? route('produits.update', $editProduit->id) : route('produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($editProduit))
                @method('PUT')
            @endif
            <div>
                <label>Code:</label>
                <input type="text" name="code" value="{{ old('code', $editProduit->code ?? '') }}" placeholder="Code du produit">
            </div>
            <div>
                <label>Libellé:</label>
                <input type="text" name="libelle" value="{{ old('libelle', $editProduit->libelle ?? '') }}" placeholder="Libellé du produit">
            </div>
            <div>
                <label>Prix:</label>
                <input type="number" name="prix" value="{{ old('prix', $editProduit->prix ?? '') }}" placeholder="Prix du produit">
            </div>
            <div>
                <label>Description:</label>
                <textarea name="description" placeholder="Description du produit">{{ old('description', $editProduit->description ?? '') }}</textarea>
            </div>
            <div>
                <label>Quantité en stock:</label>
                <input type="number" name="qte" value="{{ old('qte', $editProduit->qte ?? '') }}" placeholder="Quantité en stock">
            </div>
            <div>
                <label>Image:</label>
                <input type="file" name="image" placeholder="Image du produit">
                @if( isset($editProduit) && $editProduit->image)
                    <div>
                        <p>Image actuelle:</p>
                        <img src="{{ $editProduit->image }}" alt="{{ $editProduit->libelle }}" width="100">
                    </div>
                @endif
            </div>

            <button type="submit">{{ isset($editProduit) ? 'Modifier' : 'Ajouter' }}</button>
            <button type="reset">Annuler</button>
        </form>





        <div class="">
            <div>
                <form action="{{ route('produits.index') }}" method="GET">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher par code ou libellé">
                    <button type="submit">Rechercher</button>
                </form>

                @if (request('query'))
                    <a href="{{ route('produits.index') }}">Annuler la recherche</a>
                @endif
            </div>
            <table class="" border="1">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->code }}</td>
                            <td>{{ $produit->libelle }}</td>
                            <td>{{ $produit->prix }}</td>
                            <td>{{ $produit->qte }}</td>
                            <td>{{ $produit->description }}</td>
                            <td>
                                @if ($produit->image)
                                    <img src="{{ $produit->image }}" alt="{{ $produit->libelle }}" width="100">
                                @else
                                    <p>Aucune image disponible</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('produits.index', ['edit' => $produit->id, 'query' => request('query')]) }}">Modifier</a>
                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>

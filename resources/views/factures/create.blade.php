<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Facture</title>
</head>

<body>
    <div class="">
        <div class="">
            <h1>Création de Facture</h1>

            <div>
                <a href="{{ route('factures.index') }}">Retour à la liste</a>
            </div>
        </div>
        @if (session('error'))
            <div class="">
                {{ session('error') }}
            </div>
        @endif


        <div class=""></div>
            <form action="{{ route('factures.store') }}" method="POST">
                @csrf
                <div>
                    <label for="client_id">Client:</label>
                    <select name="client_id" id="client_id" required>
                        <option value="">Sélectionnez un client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }} - CIN : {{ $client->cin }}</option>
                        @endforeach
                    </select>
                </div>

                <h3>Produits</h3>
                <table border="1" id="produits-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="produits[0][id]" required>
                                    <option value="">Sélectionnez un produit</option>
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->libelle }} (Stock: {{ $produit->qte }}) | Prix: {{ $produit->prix }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="produits[0][qte]" min="1" value="1" required></td>
                            <td>
                                <button type="button" onclick="this.closest('tr').remove()">Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addProduit()">Ajouter un produit</button>


                <div>
                    <button type="submit">Créer la facture</button>
                <a href="{{ route('factures.index') }}">Annuler</a>
                </div>
            </form>
        </div>
    </div>


    <script>
        let produitIndex = 1;

        const produitOptions = `
            @foreach ($produits as $produit)
                <option value="{{ $produit->id }}">{{ $produit->libelle }} (Stock: {{ $produit->qte }}) | Prix: {{ $produit->prix }}</option>
            @endforeach
        `;

        function addProduit()
        {
            const tableBody = document.getElementById('produits-table').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();

            newRow.innerHTML = `
                <td>
                    <select name="produits[${produitIndex}][id]" required>
                        <option value="">Sélectionnez un produit</option>
                        ${produitOptions}
                    </select>
                </td>
                <td><input type="number" name="produits[${produitIndex}][qte]" min="1" value="1" required></td>
                <td>
                    <button type="button" onclick="this.closest('tr').remove()">Supprimer</button>
                </td>
            `;
            produitIndex++;
        }
    </script>
</body>

</html>

                       
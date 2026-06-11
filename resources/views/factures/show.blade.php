<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture Num {{ $facture->id }}</title>
</head>

<body>
    <div class="">
        <div class="">
            <div>
                <a href="{{ route('factures.index') }}">Retour à la liste</a>
            </div>
            <div>
                <h2>Facture Num {{ $facture->id }}</h2>
                <p><strong>Date:</strong> {{ $facture->date }}</p>
            </div>

            <div class="">
                <h2>Client</h2>
                <p> CIN : {{ $facture->client->cin }}</p>
                <p> Nom Complet : {{ $facture->client->nom }} {{ $facture->client->prenom }} </p>
                <p> Téléphone : {{ $facture->client->tel }}</p>
            </div>

        </div>


        <h3>Détails de la Facture</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facture->details as $detail)
                    <tr>
                        <td>{{ $detail->produit->libelle }}</td>
                        <td>{{ $detail->qte_prod }}</td>
                        <td>{{ number_format($detail->prix_unitaire_prod, 2) }} DH</td>
                        <td>{{ number_format($detail->qte_prod * $detail->prix_unitaire_prod, 2) }} DH</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p><strong>Montant Total:</strong> {{ number_format($facture->montant_total, 2) }} DH</p>
        </div>
    </div>
</body>

</html>
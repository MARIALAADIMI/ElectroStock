<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
</head>

<body>
    <div class="">
                 <div>
                <a href="{{ route('produits.index') }}">Liste des produits</a>
                <a href="{{ route('clients.index') }}">Liste des clients</a>
            </div>
        <div class="">
            <h1>Liste des Factures</h1>

            <div>
                <a href="{{ route('factures.create') }}">Ajouter une facture</a>
            </div>
        </div>

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

        <form action="{{ route('factures.index') }}" method="GET">
            <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher par numéro ou client">
            <button type="submit">Rechercher</button>
            @if(request('query'))
                <a href="{{ route('factures.index') }}">Annuler la recherche</a>
            @endif
        </form>


        <div class="">
            <table class="" border="1">
                <thead>
                    <tr>
                        <th>Num Facture</th>
                        <th>Client</th>
                        <th>CIN</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factures as $facture)
                        <tr>
                            <td>{{ $facture->id }}</td>
                            <td>{{ $facture->client->nom }} {{ $facture->client->prenom }}</td>
                            <td>{{ $facture->client->cin }}</td>
                            <td>{{ $facture->date }}</td>
                            <td>{{ number_format($facture->montant_total, 2) }} DH</td>
                            <td>
                                <a href="{{ route('factures.show', $facture->id) }}">Voir</a>
                                <a href="{{ route('factures.pdf', $facture->id) }}">Telecharger PDF</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $factures->withQueryString()->links() }}
            </div>
        </div>
    </div>

</body>

</html>

                       
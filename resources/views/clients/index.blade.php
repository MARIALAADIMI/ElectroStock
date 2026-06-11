<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
  
</head>
<body>
    <div class="">
         <div>
                <a href="{{ route('factures.index') }}">Liste des factures</a>
                <a href="{{ route('produits.index') }}">Liste des produits</a>
            </div>
        <div class="">
            <h2>{{ isset($editClient) ? 'Modifier le client' : 'Ajouter un client' }}</h2>
        </div>

        <form action="{{ isset($editClient) ? route('clients.update', $editClient->id) : route('clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
              @if (isset($editClient))
                @method('PUT')
            @endif
           
            <div>
                <label>CIN:</label>
                <input type="text" name="cin" value="{{ isset($editClient) ? $editClient->cin : '' }}" placeholder="CIN du client">
            </div>
            <div>
                <label>Nom:</label>
                <input type="text" name="nom" value="{{ isset($editClient) ? $editClient->nom : '' }}" placeholder="Nom du client">
            </div>
            <div>
                <label>Prénom:</label>
                <input type="text" name="prenom" value="{{ isset($editClient) ? $editClient->prenom : '' }}" placeholder="Prénom du client">
            </div>
            <div>
                <label>Téléphone:</label>
                <input type="text" name="tel" value="{{ isset($editClient) ? $editClient->tel : '' }}" placeholder="Téléphone du client">
            </div>
           
           
            

            <button type="submit">{{ isset($editClient) ? 'Modifier' : 'Ajouter' }}</button>
            <button type="reset">Annuler</button>
        </form>
        
    </div>


    <div class="">
        <h2 class="">Liste des Clients</h2>
    
            <table class="" border="1" >
                <thead class="table-dark">
                    <tr>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->cin }}</td>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td>{{ $client->tel }}</td>
                            <td>
                                <a href="{{ route('clients.index', ['edit' => $client->id]) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       
    </div>

    
</body>
</html>
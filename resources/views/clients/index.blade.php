@extends('layouts.app')

@section('title', 'Clients')
@section('page_title', 'Gestion des Clients')

@section('content')
    @if (session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
    @if ($errors->any()) <div class="alert-danger"><ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

    <div class="card">
        <h2>{{ isset($editClient) ? '✏️ Modifier le client' : '➕ Ajouter un client' }}</h2>
        @if (isset($editClient)) <a href="{{ route('clients.index') }}" style="color: #dc3545; text-decoration: none; font-size: 14px; display: block; margin-bottom: 15px;">❌ Annuler la modification</a> @endif

        <form action="{{ isset($editClient) ? route('clients.update', $editClient->id) : route('clients.store') }}" method="POST">
            @csrf @if (isset($editClient)) @method('PUT') @endif
            <div class="form-row">
                <div class="form-group"><label>CIN</label><input type="text" name="cin" value="{{ old('cin', $editClient->cin ?? '') }}" required></div>
                <div class="form-group"><label>Nom</label><input type="text" name="nom" value="{{ old('nom', $editClient->nom ?? '') }}" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" name="prenom" value="{{ old('prenom', $editClient->prenom ?? '') }}" required></div>
                <div class="form-group"><label>Téléphone</label><input type="text" name="tel" value="{{ old('tel', $editClient->tel ?? '') }}" required></div>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($editClient) ? 'Enregistrer' : 'Ajouter' }}</button>
            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
        </form>
    </div>

    <div class="card">
        <h2>Liste des Clients ({{ $clients->total() }})</h2>
        <table>
            <thead><tr><th>CIN</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Actions</th></tr></thead>
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
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST">@csrf @method('DELETE') <button type="submit" class="btn btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="return confirm('Supprimer ?')">Supprimer</button></form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px; text-align: center;">{{ $clients->links() }}</div>
    </div>
@endsection
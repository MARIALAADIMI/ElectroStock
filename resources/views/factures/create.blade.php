@extends('layouts.app')

@section('title', 'Création Facture')
@section('page_title', 'Création de Facture')

@section('content')
    @if (session('error')) <div class="alert-danger">{{ session('error') }}</div> @endif
    @if ($errors->any()) <div class="alert-danger"><ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

    <form action="{{ route('factures.store') }}" method="POST">
        @csrf
        <div class="card">
            <h2>Informations Client</h2>
            <div class="form-group" style="max-width: 400px;">
                <label>Sélectionner un client</label>
                <select name="client_id" required>
                    <option value="">-- Choisir --</option>
                    @foreach ($clients as $client) <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option> @endforeach
                </select>
            </div>
        </div>

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin:0; border:none;">Produits</h2>
                <button type="button" onclick="addProduit()" class="btn btn-success" style="font-size: 13px;">➕ Ajouter une ligne</button>
            </div>
            <table id="produits-table">
                <thead><tr><th style="width:60%">Produit</th><th style="width:20%">Quantité</th><th style="width:20%">Action</th></tr></thead>
                <tbody>
                    <tr>
                        <td><select name="produits[0][id]" required style="width:100%; padding:8px;">@foreach ($produits as $p) <option value="{{ $p->id }}">{{ $p->libelle }} (Stock: {{ $p->qte }})</option> @endforeach</select></td>
                        <td><input type="number" name="produits[0][qte]" min="1" value="1" required style="width:100%; padding:8px;"></td>
                        <td><button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger" style="padding:8px 12px;">🗑</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px;">✅ Valider la Facture</button>
            <a href="{{ route('factures.index') }}" class="btn btn-secondary" style="padding: 12px 30px;">Annuler</a>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        let produitIndex = 1;
        const produitOptions = `@foreach ($produits as $p)<option value="{{ $p->id }}">{{ $p->libelle }} (Stock: {{ $p->qte }})</option>@endforeach`;
        function addProduit() {
            const tbody = document.getElementById('produits-table').getElementsByTagName('tbody')[0];
            const row = tbody.insertRow();
            row.innerHTML = `<td><select name="produits[${produitIndex}][id]" required style="width:100%; padding:8px;"><option value="">-- Choisir --</option>${produitOptions}</select></td><td><input type="number" name="produits[${produitIndex}][qte]" min="1" value="1" required style="width:100%; padding:8px;"></td><td><button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger" style="padding:8px 12px;">🗑</button></td>`;
            produitIndex++;
        }
    </script>
@endsection
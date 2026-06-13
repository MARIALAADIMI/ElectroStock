@extends('layouts.app')

@section('title', 'Factures')
@section('page_title', 'Liste des Factures')

@section('content')
    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <form action="{{ route('factures.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="query" value="{{ request('query') }}" placeholder="Rechercher..."
                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">🔍</button>
            @if (request('query'))
                <a href="{{ route('factures.index') }}" class="btn btn-secondary" style="padding: 8px 15px;">X</a>
            @endif
        </form>
        <a href="{{ route('factures.create') }}" class="btn btn-success">➕ Nouvelle Facture</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>N° Facture</th>
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
                        <td><strong>#{{ $facture->id }}</strong></td>
                        <td>{{ $facture->client->nom }} {{ $facture->client->prenom }}</td>
                        <td>{{ $facture->client->cin }}</td>
                        <td>{{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</td>
                        <td><strong>{{ number_format($facture->montant_total, 2) }} DH</strong></td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('factures.show', $facture->id) }}" class="btn btn-info"
                                    style="font-size: 12px; padding: 5px 12px;">👁 Voir</a>
                                <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-primary"
                                    style="font-size: 12px; padding: 5px 12px;">📄 PDF</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $factures->withQueryString()->links('partials.pagination') }}
    </div>
@endsection

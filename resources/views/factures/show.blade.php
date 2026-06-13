@extends('layouts.app')

@section('title', 'Facture N° ' . $facture->id)
@section('page_title', 'Facture N° ' . $facture->id)

@section('styles')
    <style>
        /* Cacher le layout si on fait Ctrl+P */
        @media print {
            .sidebar, .main-header, .main-footer, .no-print { display: none !important; }
            .main-wrapper { margin-left: 0 !important; }
            .main-content { padding: 0 !important; }
        }
    </style>
@endsection

@section('content')
    <div class="no-print" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="{{ route('factures.index') }}" class="btn btn-secondary">⬅ Retour</a>
        <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-primary">📄 Télécharger PDF</a>
        <button onclick="window.print()" class="btn btn-success">🖨 Imprimer</button>
    </div>

    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 2px solid #2b2d42; padding-bottom: 15px;">
            <div>
                <h1 style="margin:0; color:#2b2d42;">FACTURE</h1>
                <p><strong>N° :</strong> {{ $facture->id }}<br><strong>Date :</strong> {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</p>
            </div>
            <div style="text-align: right;"><h2 style="color: #ef233c; margin:0;">ElectroStock</h2></div>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 25px; border-left: 4px solid #ef233c;">
            <h3 style="margin:0 0 5px; color:#2b2d42;">Client</h3>
            <p style="margin:0;">{{ $facture->client->nom }} {{ $facture->client->prenom }} | CIN: {{ $facture->client->cin }} | Tél: {{ $facture->client->tel }}</p>
        </div>

        <table>
            <thead><tr><th>Produit</th><th style="text-align:center;">Qté</th><th style="text-align:right;">Prix Unit.</th><th style="text-align:right;">Total</th></tr></thead>
            <tbody>
                @foreach ($facture->details as $detail)
                <tr>
                    <td>{{ $detail->produit->libelle }}</td>
                    <td style="text-align:center;">{{ $detail->qte_prod }}</td>
                    <td style="text-align:right;">{{ number_format($detail->prix_unitaire_prod, 2) }} DH</td>
                    <td style="text-align:right; font-weight:bold;">{{ number_format($detail->qte_prod * $detail->prix_unitaire_prod, 2) }} DH</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 30px; font-size: 22px; font-weight: bold; color: #ef233c; border-top: 2px solid #eee; padding-top: 15px;">
            Total : {{ number_format($facture->montant_total, 2) }} DH
        </div>
    </div>
@endsection
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture N° {{ $facture->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; color: #333; margin: 40px; font-size: 14px; }
        .invoice-box { border: 1px solid #eee; padding: 30px; border-radius: 8px; }
        .header-invoice { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 3px solid #2b2d42; padding-bottom: 15px; }
        .header-invoice h1 { margin: 0; color: #2b2d42; font-size: 28px; }
        .client-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 25px; border-left: 4px solid #ef233c; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th { background-color: #2b2d42; color: white; padding: 10px; text-align: left; font-size: 13px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .total-section { text-align: right; margin-top: 20px; font-size: 22px; font-weight: bold; color: #ef233c; border-top: 2px solid #eee; padding-top: 15px; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #888; }
    </style>
</head>
<body>

    <div class="invoice-box">
        <!-- En-tête -->
        <div class="header-invoice">
            <div>
                <h1>FACTURE</h1>
                <p><strong>N° :</strong> {{ $facture->id }}</p>
                <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</p>
            </div>
            <div style="text-align: right;">
                <h2 style="color: #ef233c; margin:0;">ElectroStock</h2>
                <p style="margin:0; font-size: 12px;">Gestion de produits électroniques</p>
            </div>
        </div>

        <!-- Client -->
        <div class="client-info">
            <h3 style="margin-top:0; margin-bottom:5px; color:#2b2d42; font-size: 16px;">Client</h3>
            <p style="margin:2px 0;"><strong>Nom :</strong> {{ $facture->client->nom }} {{ $facture->client->prenom }}</p>
            <p style="margin:2px 0;"><strong>CIN :</strong> {{ $facture->client->cin }} &nbsp;&nbsp; <strong>Tél :</strong> {{ $facture->client->tel }}</p>
        </div>

        <!-- Tableau -->
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Produit</th>
                    <th style="width: 15%; text-align:center;">Qté</th>
                    <th style="width: 15%; text-align:right;">Prix Unit.</th>
                    <th style="width: 20%; text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facture->details as $detail)
                    <tr>
                        <td>{{ $detail->produit->libelle }}</td>
                        <td style="text-align:center;">{{ $detail->qte_prod }}</td>
                        <td style="text-align:right;">{{ number_format($detail->prix_unitaire_prod, 2) }} DH</td>
                        <td style="text-align:right; font-weight: bold;">{{ number_format($detail->qte_prod * $detail->prix_unitaire_prod, 2) }} DH</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total-section">
            Net à payer : {{ number_format($facture->montant_total, 2) }} DH
        </div>
    </div>

    <div class="footer">
        <p>Merci pour votre achat ! - ElectroStock © {{ date('Y') }}</p>
    </div>

</body>
</html>
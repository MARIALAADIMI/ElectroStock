@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Tableau de Bord')

@section('content')
    <div class="stats-container" style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <div class="stat-card"
            style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex: 1; min-width: 200px; text-align: center; border-left: 5px solid #007bff;">
            <h3 style="margin: 0; color: #555; font-size: 14px; text-transform: uppercase;">Total Stock</h3>
            <p style="margin: 10px 0 0; font-size: 28px; font-weight: bold; color: #333;">{{ $Totalstock }}</p>
        </div>
        <div class="stat-card"
            style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex: 1; min-width: 200px; text-align: center; border-left: 5px solid #17a2b8;">
            <h3 style="margin: 0; color: #555; font-size: 14px; text-transform: uppercase;">Produits</h3>
            <p style="margin: 10px 0 0; font-size: 28px; font-weight: bold; color: #333;">{{ $TotalProduits }}</p>
        </div>
        <div class="stat-card"
            style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex: 1; min-width: 200px; text-align: center; border-left: 5px solid #28a745;">
            <h3 style="margin: 0; color: #555; font-size: 14px; text-transform: uppercase;">Clients</h3>
            <p style="margin: 10px 0 0; font-size: 28px; font-weight: bold; color: #333;">{{ $TotalClient }}</p>
        </div>
        <div class="stat-card"
            style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex: 1; min-width: 200px; text-align: center; border-left: 5px solid #ffc107;">
            <h3 style="margin: 0; color: #555; font-size: 14px; text-transform: uppercase;">Chiffre d'affaires</h3>
            <p style="margin: 10px 0 0; font-size: 28px; font-weight: bold; color: #333;">
                {{ number_format($TotalRevenu, 2) }} MAD</p>
        </div>
    </div>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 66.66%; min-width: 400px;">
            <div class="card">
                <h2>Graphique des Ventes par Mois ({{ date('Y') }})</h2>
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div style="flex: 33.33%; min-width: 250px;">
            <div class="card">
                <h2>Alertes Stock</h2>
                <ul style="list-style: none; padding: 0; margin: 0; max-height: 300px; overflow-y: auto;">
                    @foreach ($ReptureStock as $p)
                        <li class="alert-rupture"
                            style="padding: 10px; margin-bottom: 5px; border-radius: 4px; display: flex; justify-content: space-between; background-color: #f8d7da; color: #721c24;">
                            <span>{{ $p->libelle }}</span><span><strong>Rupture (0)</strong></span>
                        </li>
                    @endforeach
                    @foreach ($StockFaible as $p)
                        <li
                            style="padding: 10px; margin-bottom: 5px; border-radius: 4px; display: flex; justify-content: space-between; background-color: #fff3cd; color: #856404;">
                            <span>{{ $p->libelle }}</span><span><strong>Faible ({{ $p->qte }})</strong></span>
                        </li>
                    @endforeach
                    @if ($ReptureStock->isEmpty() && $StockFaible->isEmpty())
                        <li style="padding: 10px; background:#d4edda; color:#155724; text-align:center;">Aucune alerte, tout
                            est OK !</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">

        <div style="flex: 1; min-width: 350px;">
            <div class="card">
                <h2>Top 5 Produits les Plus Vendus</h2>

                @if ($topProduits->count())
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#f8f9fa;">
                                <th style="padding:10px; text-align:left;">Produit</th>
                                <th style="padding:10px; text-align:center;">Qté Vendue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topProduits as $produit)
                                <tr style="border-top:1px solid #ddd;">
                                    <td style="padding:10px;">
                                        {{ $produit->produit->libelle ?? 'Produit supprimé' }}
                                    </td>
                                    <td style="padding:10px; text-align:center;">
                                        {{ $produit->total_vendu }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucune vente enregistrée.</p>
                @endif
            </div>
        </div>

        <div style="flex: 1; min-width: 350px;">
            <div class="card">
                <h2>Dernières Factures</h2>

                @if ($recentFactures->count())
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#f8f9fa;">
                                <th style="padding:10px;">N°</th>
                                <th style="padding:10px;">Client</th>
                                <th style="padding:10px;">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentFactures as $facture)
                                <tr style="border-top:1px solid #ddd;">
                                    <td style="padding:10px;">
                                        #{{ $facture->id }}
                                    </td>
                                    <td style="padding:10px;">
                                        {{ $facture->client->nom ?? 'Client inconnu' }}
                                    </td>
                                    <td style="padding:10px;">
                                        {{ number_format($facture->montant_total, 2) }} MAD
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucune facture trouvée.</p>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salesData = @json($RevenusByMounth);
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov',
                        'Déc'
                    ],
                    datasets: [{
                        label: 'Ventes (MAD)',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' MAD';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Client;
use App\Models\Facture;
use App\Models\DetailFacture;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        // 1. Statistiques globales (Existant)
        $Totalstock = Produit::sum('qte');
        $TotalProduits = Produit::count();
        $TotalClient = Client::count();
        $TotalRevenu = Facture::sum('montant_total');

        // 2. Alertes Stock (Existant)
        $ReptureStock = Produit::where('qte', 0)->get();
        $StockFaible = Produit::where('qte', '>', 0)->where('qte', '<', 10)->get();

        // 3. Graphique des ventes par mois (Existant)
        $currentYear = date('Y');
        $ventesParMois = array_fill(0, 12, 0);
        $salesData = Facture::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(montant_total) as total')
            )
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($salesData as $data) {
            $ventesParMois[$data->month - 1] = $data->total;
        }
        $RevenusByMounth = $ventesParMois;

        // 4. NOUVEAU : Top 5 des produits les plus vendus
        $topProduits = DetailFacture::select('id_produit', DB::raw('SUM(qte_prod) as total_vendu'))
            ->groupBy('id_produit')
            ->orderByDesc('total_vendu')
            ->with('produit') // Eager load pour éviter les requêtes N+1
            ->take(5)
            ->get();

        // 5. NOUVEAU : Les 5 dernières factures
        $recentFactures = Facture::with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'Totalstock', 
            'TotalProduits', 
            'TotalClient', 
            'TotalRevenu', 
            'ReptureStock', 
            'StockFaible', 
            'RevenusByMounth',
            'topProduits',
            'recentFactures'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DetailFacture;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $Totalstock = Produit::sum('qte');
        $TotalProduits = Produit::count();
        $TotalClient = Client::count();
        $TotalRevenu = Facture::sum('montant_total');

        $ReptureStock = Produit::where('qte', 0)->get();
        $StockFaible = Produit::where('qte', '>', 0)->where('qte', '<', 10)->get();

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

        $topProduits = DetailFacture::select('id_produit', DB::raw('SUM(qte_prod) as total_vendu'))
            ->groupBy('id_produit')
            ->orderByDesc('total_vendu')
            ->with('produit')
            ->take(5)
            ->get();

        $recentFactures = Facture::with('client')
            ->latest()
            ->take(5)
            ->get();

        $stockOk = Produit::where('qte', '>=', 10)->count();
        $stockFaible = Produit::where('qte', '>', 0)->where('qte', '<', 10)->count();
        $stockRupture = Produit::where('qte', '=', 0)->count();

       $topProduitsCA = DetailFacture::select('id_produit', DB::raw('SUM(qte_prod * prix_unitaire_prod) as total_ca'))
            ->groupBy('id_produit')
            ->orderByDesc('total_ca')
            ->with('produit')
            ->take(5)
            ->get();

        $clientsParMois = array_fill(0, 12, 0);
        $clientsData = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        foreach ($clientsData as $month => $total) {
            $clientsParMois[$month - 1] = $total;
        }
        $clientsParMoisArray = array_values($clientsParMois);

        return view('Dashboard', compact(
            'Totalstock', 'TotalProduits', 'TotalClient', 'TotalRevenu',
            'ReptureStock', 'StockFaible', 'RevenusByMounth',
            'stockOk', 'stockFaible', 'stockRupture',
            'topProduitsCA', 'clientsParMoisArray', 'topProduits',
            'recentFactures'
        ));

       
    }
}

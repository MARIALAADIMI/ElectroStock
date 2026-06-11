<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Facture;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Dashboard()
    {
       $Totalstock=Produit::sum('qte');
       $TotalProduits=Produit::count();
       $TotalClient=Client::count();

       $TotalRevenu=Facture::sum('montant_total');

       $currentYear=date('Y');
       $RevenusByMounth= array_fill(0, 12, 0);
       

       $RevenuParMois=Facture::select(
        DB::raw('MONTH(date) as MONTH'),
        DB::raw('SUM(montant_total) as Total')

       )->whereYear('date',$currentYear) 
       ->GroupBy('MONTH')
       ->OrderBy('MONTH')
       ->get();
       foreach ($RevenuParMois as $data) { $RevenusByMounth[$data->month - 1] = $data->total;}


       $ReptureStock=Produit::where('qte',0)->get();
       $StockFaible=Produit::where('qte','<',10)->where('qte','>',0)->get();




       return view('Dashboard',compact('Totalstock','TotalProduits','TotalClient','TotalRevenu','RevenusByMounth','ReptureStock','StockFaible'));
    }
}

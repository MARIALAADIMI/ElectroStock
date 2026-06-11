<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use App\Models\Facture;
use App\Models\DetailFacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $factures = Facture::with('client')
        ->when($query, function ($q) use ($query) {
            $q->where('id', 'like', "%$query%")
              ->orWhereHas('client', function ($q2) use ($query) {
                  $q2->where('nom', 'like', "%$query%")
                  ->orWhere('prenom', 'like', "%$query%")
                  ->orWhere('cin', 'like', "%$query%");
              });
        })
        ->latest()
        ->paginate(10);

        return view('factures.index')->with('factures', $factures);
           
    }

    public function create()
    {
        $clients = Client::all();
        $produits = Produit::where('qte', '>', 0)->get();
        return view('factures.create', compact('clients', 'produits'));
    }


    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.qte' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $facture = Facture::create([
                'client_id' => $request->client_id,
                'date' => now(),
                'montant_total' => 0
            ]);
            $montant_total = 0;

            foreach($request->produits as $item)
            {
                $produit = Produit::find($item['id']);

                if($produit->qte < $item['qte']) {
                    throw new \Exception("Quantité insuffisante pour le produit: " . $produit->libelle);
                }

                $prixLigne = $produit->prix * $item['qte'];
                $montant_total += $prixLigne;

                DetailFacture::create([
                    'id_facture' => $facture->id,
                    'id_produit' => $produit->id,
                    'qte_prod' => $item['qte'],
                    'prix_unitaire_prod' => $produit->prix
                ]);

                $produit->decrement('qte', $item['qte']);
                
            }
            $facture->update(['montant_total' => $montant_total]);

            DB::commit();

        return redirect()->route('factures.index')->with('success', 'Facture créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de la facture: ' . $e->getMessage());
        }
    
    }

    public function show(Facture $facture)
    {
        $facture->load('client', 'details.produit');
        return view('factures.show', compact('facture'));
    }

    public function generatePDF(Facture $facture)
    {
        $facture->load('client', 'details.produit');

        $pdf = Pdf::loadView('factures.pdf', compact('facture'));
        return $pdf->download("facture_{$facture->id}.pdf");
    }

}

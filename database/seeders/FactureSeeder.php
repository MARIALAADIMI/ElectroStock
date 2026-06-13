<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facture;
use App\Models\DetailFacture;
use App\Models\Client;
use App\Models\Produit;
use Carbon\Carbon;

class FactureSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $produits = Produit::where('qte', '>', 0)->get();

        for ($i = 0; $i < 80; $i++) {
            
            if ($produits->isEmpty()) {
                break;
            }
            $dateFacture = Carbon::createFromDate(date('Y'), rand(1, 12), rand(1, 28));

            $facture = Facture::create([
                'client_id' => $clients->random()->id,
                'date' => $dateFacture,
                'montant_total' => 0
            ]);

            $montantTotal = 0;
            
            $maxProduitsDispos = $produits->count();
            $nombreDeLignes = rand(1, min(4, $maxProduitsDispos)); 
            
            $produitsSelectionnes = $produits->random($nombreDeLignes);

            foreach ($produitsSelectionnes as $produit) {
                $qteDemandee = rand(1, 3);
                $qte = min($qteDemandee, $produit->qte);

                if ($qte > 0) {
                    $prixLigne = $produit->prix * $qte;
                    $montantTotal += $prixLigne;

                    DetailFacture::create([
                        'id_facture' => $facture->id,
                        'id_produit' => $produit->id,
                        'prix_unitaire_prod' => $produit->prix,
                        'qte_prod' => $qte,
                    ]);

                    $produit->decrement('qte', $qte);
                }
            }

            $facture->update(['montant_total' => $montantTotal]);
            
            $produits = Produit::where('qte', '>', 0)->get();
        }
    }
}
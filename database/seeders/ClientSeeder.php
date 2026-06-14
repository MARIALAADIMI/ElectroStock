<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Carbon\Carbon; // À ajouter pour gérer les dates

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $noms = ['Alaoui', 'Benali', 'Chraibi', 'Doukkali', 'El Fassi', 'Ghazi', 'Hajji', 'Idrissi', 'Jabri', 'Kabbaj', 'Lahlou', 'Mansouri', 'Naciri', 'Ouali', 'Rahmouni', 'Saidi', 'Tazi', 'Ouazzani', 'Yassine', 'Ziani'];
        $prenoms = ['Mohamed', 'Youssef', 'Ahmed', 'Omar', 'Ali', 'Hassan', 'Ibrahim', 'Khalid', 'Rachid', 'Mehdi', 'Fatima', 'Zineb', 'Khadija', 'Salma', 'Amina', 'Nadia', 'Houda', 'Sara', 'Imane', 'Meriem'];

        for ($i = 0; $i < 40; $i++) {
            $nom = $noms[array_rand($noms)];
            $prenom = $prenoms[array_rand($prenoms)];
            
            // Génère une date aléatoire répartie sur les 365 derniers jours
            $dateAleatoire = Carbon::now()->subDays(rand(0, 365));

            Client::create([
                'cin' => 'CIN' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'nom' => $nom,
                'prenom' => $prenom,
                'tel' => '06' . rand(10000000, 99999999),
                'created_at' => $dateAleatoire,
                'updated_at' => $dateAleatoire,
            ]);
        }
    }
}
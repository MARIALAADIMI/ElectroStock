<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $noms = ['Alaoui', 'Benali', 'Chraibi', 'Doukkali', 'El Fassi', 'Ghazi', 'Hajji', 'Idrissi', 'Jabri', 'Kabbaj', 'Lahlou', 'Mansouri', 'Naciri', 'Ouali', 'Rahmouni', 'Saidi', 'Tazi', 'Ouazzani', 'Yassine', 'Ziani'];
        $prenoms = ['Mohamed', 'Youssef', 'Ahmed', 'Omar', 'Ali', 'Hassan', 'Ibrahim', 'Khalid', 'Rachid', 'Mehdi', 'Fatima', 'Zineb', 'Khadija', 'Salma', 'Amina', 'Nadia', 'Houda', 'Sara', 'Imane', 'Meriem'];

        for ($i = 0; $i < 40; $i++) {
            $nom = $noms[array_rand($noms)];
            $prenom = $prenoms[array_rand($prenoms)];
            
            Client::create([
                'cin' => 'CIN' . str_pad($i + 1, 5, '0', STR_PAD_LEFT), // Génère CIN00001, CIN00002...
                'nom' => $nom,
                'prenom' => $prenom,
                'tel' => '06' . rand(10000000, 99999999), // Génère 0612345678
            ]);
        }
    }
}
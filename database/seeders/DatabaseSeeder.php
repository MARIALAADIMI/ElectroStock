<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DetailFacture;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        User::truncate();
        Produit::truncate();
        Client::truncate();
        Facture::truncate();
        DetailFacture::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory()->create([
            'name' => 'Admin ElectroStock',
            'email' => 'admin@electrostock.ma',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            ProduitSeeder::class,
            ClientSeeder::class,
            FactureSeeder::class,
        ]);
    }
}

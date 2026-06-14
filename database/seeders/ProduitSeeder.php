<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $produits = [
            ['code' => 'SM-A54', 'libelle' => 'Samsung Galaxy A54', 'prix' => 3299.00, 'description' => 'Smartphone milieu de gamme, 128Go', 'qte' => 250, 'image' => null],
            ['code' => 'IP-15P', 'libelle' => 'iPhone 15 Pro Max', 'prix' => 14999.00, 'description' => 'Smartphone haut de gamme Apple', 'qte' => 18, 'image' => null],
            ['code' => 'RP-N11', 'libelle' => 'Redmi Note 11', 'prix' => 2199.00, 'description' => 'Smartphone budget Xiaomi', 'qte' => 5, 'image' => null],
            ['code' => 'SM-S23', 'libelle' => 'Samsung Galaxy S23', 'prix' => 8999.00, 'description' => 'Smartphone haut de gamme Samsung', 'qte' => 0, 'image' => null], // Rupture
            ['code' => 'IP-14', 'libelle' => 'iPhone 14', 'prix' => 10999.00, 'description' => 'Smartphone Apple', 'qte' => 20, 'image' => null],
            ['code' => 'SM-F23', 'libelle' => 'Samsung Galaxy F23', 'prix' => 2499.00, 'description' => 'Smartphone milieu de gamme Samsung', 'qte' => 8, 'image' => null], // Faible
            ['code' => 'LP-AS5', 'libelle' => 'Asus ZenBook 14', 'prix' => 7999.00, 'description' => 'PC Portable ultrafin, 16Go RAM', 'qte' => 25, 'image' => null],
            ['code' => 'LP-D15', 'libelle' => 'Dell Inspiron 15', 'prix' => 7499.00, 'description' => 'PC Portable 15 pouces, 8Go RAM', 'qte' => 15, 'image' => null],
            ['code' => 'LP-MB3', 'libelle' => 'MacBook Air M2', 'prix' => 12999.00, 'description' => 'Ultrabook Apple Puce M2', 'qte' => 4, 'image' => null], // Faible
            ['code' => 'LP-HP5', 'libelle' => 'HP Pavilion 15', 'prix' => 6299.00, 'description' => 'PC Portable étudiant', 'qte' => 0, 'image' => null], // Rupture
            ['code' => 'TV-LG4', 'libelle' => 'LG TV 55" 4K UHD', 'prix' => 5499.00, 'description' => 'Téléviseur Smart TV', 'qte' => 12, 'image' => null],
            ['code' => 'TV-SS7', 'libelle' => 'Samsung TV 65" 4K', 'prix' => 8999.00, 'description' => 'Téléviseur haute gamme', 'qte' => 5, 'image' => null], // Faible
            ['code' => 'AU-SN3', 'libelle' => 'Sony WH-1000XM5', 'prix' => 3299.00, 'description' => 'Casque sans fil à réduction de bruit', 'qte' => 30, 'image' => null],
            ['code' => 'AU-AP2', 'libelle' => 'AirPods Pro 2', 'prix' => 2799.00, 'description' => 'Ecouteurs Apple', 'qte' => 0, 'image' => null], // Rupture
            ['code' => 'TB-IPA', 'libelle' => 'iPad Air 5', 'prix' => 6799.00, 'description' => 'Tablette Apple 10.9 pouces', 'qte' => 9, 'image' => null], // Faible
            ['code' => 'TB-GT8', 'libelle' => 'Samsung Galaxy Tab S8', 'prix' => 7499.00, 'description' => 'Tablette Android haute gamme', 'qte' => 18, 'image' => null],
            ['code' => 'CM-CN1', 'libelle' => 'Canon EOS R50', 'prix' => 8999.00, 'description' => 'Appareil photo hybride', 'qte' => 3, 'image' => null], // Faible
            ['code' => 'PR-HP2', 'libelle' => 'HP LaserJet Pro', 'prix' => 4599.00, 'description' => 'Imprimante laser monochrome', 'qte' => 7, 'image' => null], // Faible
            ['code' => 'MS-LOG', 'libelle' => 'Logitech MX Master 3', 'prix' => 899.00, 'description' => 'Souris sans fil ergonomique', 'qte' => 40, 'image' => null],
            ['code' => 'KB-MEC', 'libelle' => 'Clavier Mécanique RGB', 'prix' => 699.00, 'description' => 'Clavier gamer azerty', 'qte' => 50, 'image' => null],
            ['code' => 'EC-DM', 'libelle' => 'Dell Monitor 27" QHD', 'prix' => 3299.00, 'description' => 'Ecran PC 2K 165Hz', 'qte' => 0, 'image' => null], // Rupture
            ['code' => 'DD-WD1', 'libelle' => 'WD Elements 1To', 'prix' => 399.00, 'description' => 'Disque dur externe USB 3.0', 'qte' => 60, 'image' => null],
            ['code' => 'CL-USC', 'libelle' => 'Clé USB 64Go', 'prix' => 79.00, 'description' => 'Clé USB 3.1', 'qte' => 100, 'image' => null],
            ['code' => 'CG-RTX', 'libelle' => 'Nvidia RTX 4060', 'prix' => 4299.00, 'description' => 'Carte graphique', 'qte' => 2, 'image' => null], // Faible
            ['code' => 'CG-RX6', 'libelle' => 'AMD Radeon RX 6700 XT', 'prix' => 3999.00, 'description' => 'Carte graphique AMD', 'qte' => 0, 'image' => null], // Rupture
            ['code' => 'AL-COO', 'libelle' => 'Cooler Master Hyper 212', 'prix' => 299.00, 'description' => 'Ventirad pour processeur', 'qte' => 15, 'image' => null],
            ['code' => 'AL-PSU', 'libelle' => 'Alimentation Corsair 650W', 'prix' => 499.00, 'description' => 'Alimentation modulaire', 'qte' => 20, 'image' => null],
            ['code' => 'AL-CASE', 'libelle' => 'Boîtier NZXT H510', 'prix' => 699.00, 'description' => 'Boîtier PC moyen tour', 'qte' => 10, 'image' => null], // Faible
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
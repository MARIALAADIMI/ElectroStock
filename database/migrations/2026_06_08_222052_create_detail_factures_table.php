<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_factures', function (Blueprint $table) {
            // IDDETAIL, IDFACTURE, IDPRODUIT, PRIX_UNITAIRE_PROD, QTE_PROD
            $table->id();
            $table->foreignId('id_facture')->constrained('factures')->onDelete('cascade');
            $table->foreignId('id_produit')->constrained('produits')->onDelete('cascade');
            $table->decimal('prix_unitaire_prod', 10, 2);
            $table->integer('qte_prod')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_factures');
    }
};

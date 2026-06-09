<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailFacture extends Model
{
    protected $fillable = ['id_facture', 'id_produit', 'qte_prod', 'prix_unitaire_prod'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_facture');
    }
}
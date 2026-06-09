<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['code', 'libelle', 'prix', 'description', 'qte', 'image'];

    public function detailfactures()
    {
        return $this->hasMany(DetailFacture::class, 'id_produit');
    }
}

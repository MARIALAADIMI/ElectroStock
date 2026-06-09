<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = ['client_id', 'date', 'montant_total'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function details()
    {
        return $this->hasMany(DetailFacture::class, 'id_facture');
    }
}

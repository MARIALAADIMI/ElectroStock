<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['cin', 'nom', 'prenom', 'tel'];

    public function factures()
    {
        return $this->hasMany(Facture::class, 'client_id');
    }

}

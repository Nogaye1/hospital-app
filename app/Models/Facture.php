<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_total', 'date_facture', 'rendezvous_id'
    ];

    public function rendezvous()
    {
        return $this->belongsTo(Rendezvous::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}

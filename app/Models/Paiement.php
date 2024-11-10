<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant', 'date_paiement', 'user_id', 'facture_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}

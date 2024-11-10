<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentMedical extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut', 'date_fin', 'heure_debut', 'heure_fin', 'motif', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}

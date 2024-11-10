<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'adresse',
        'telephone',
        'email',
        'specialite',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation avec le profil (HasOne)
     */
    public function profil()
    {
        return $this->hasOne(Profil::class);
    }

    /**
     * Relation avec les rendez-vous (HasMany)
     */
    public function rendezvous()
    {
        return $this->hasMany(Rendezvous::class);
    }

    /**
     * Relation avec les antécédents médicaux (HasMany)
     */
    public function antecedentsMedicaux()
    {
        return $this->hasMany(AntecedentMedical::class);
    }

    /**
     * Relation avec les paiements (HasMany)
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}

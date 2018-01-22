<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    /**
     * Récupère l'utilisateur auquel la demande appartient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupère les hôtes appartenant à la demande.
     */
    public function hotes()
    {
        return $this->hasMany(Hote::class);
    }

    /**
     * Récupère les services appartenant à la demande.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Récupère les périodes appartenant à la demande.
     */
    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }
    
    /**
     * Récupère les états de la demande.
     */
    public function etats()
    {
        return $this->belongstoMany(EtatDemande::class);
    }
    
}

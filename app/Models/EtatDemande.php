<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatDemande extends Model
{
    /**
     * Récupère les demandes correspondantes à l'etatdemande actuel avec etatdemande_id.
     */
    public function demande($etatdemande_id)
    {
        return $this->belongsToMany(Demande::class)->with($etatdemande_id);
    }

    /**
     * Récupère la liste des demandes par état.
     */
    public function listdemande()
    {
        return $this->belongsToMany(Demande::class);
    }
}

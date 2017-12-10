<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatDemande extends Model
{
    /**
     * Récupère la demande correspondant à l'etatdemande actuel avec etatdemande_id.
     */
    public function demande($etatdemande_id)
    {
        return $this->belongsTo(Demande::class)->with($etatdemande_id);
    }

    /**
     * Récupère la liste des demande par état.
     */
    public function listdemande()
    {
        return $this->hasMany(Demande::class);
    }
}

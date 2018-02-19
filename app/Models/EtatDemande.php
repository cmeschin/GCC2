<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatDemande extends Model
{
    
    /**
     * Récupère les demandes correspondantes à l'etatdemande.
     */
    public function demandes()
    {
        return $this->belongsToMany(Demande::class);
    }

}

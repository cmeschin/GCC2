<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatDemande extends Model
{
    
    /**
     * Récupère les demandes correspondantes à l'etatdemande.
     */
    public function getDemandes()
    {
        return $this->belongsToMany(Demande::class);
    }
    
    /**
     * Récupère les demandes correspondantes à l'etatdemande.
     */
    public function getIdEtatDemande($etatdemande)
    {
        return $this->with('etat',$etatdemande)->get('id');
    }
    

}

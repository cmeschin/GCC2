<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtatDemande extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


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

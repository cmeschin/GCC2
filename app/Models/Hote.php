<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hote extends Model
{
    /**
     * récupère la demande appartenant à l'hote.
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
    
    /**
     * Récupère les services appartenant à l'hote.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Récupère les categories appartenant aux hôtes.
     */
    public function categories()
    {
        return $this->belongstoMany(HoteCategorie::class);
    }
    
    /**
     * Récupère les groupes appartenant aux hôtes.
     */
    public function groupes()
    {
        return $this->belongstoMany(HoteGroupe::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * Récupère la demande appartenant au service.
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
    
    /**
     * Récupère l'hôte appartenant au service.
     */
    public function hote()
    {
        return $this->belongsTo(Hote::class);
    }

    /**
     * Récupère la période appartenant au service.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    
    /**
     * récupère l'action appartenant au service.
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
    
    /**
     * Récupère les commentaires du service.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    
}

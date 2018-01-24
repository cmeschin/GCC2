<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeDemande extends Model
{
    /**
     * Récupère les demandes appartenant au type.
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
    
}

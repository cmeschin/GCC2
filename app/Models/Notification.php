<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Récupère le type de la demande.
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
    
}

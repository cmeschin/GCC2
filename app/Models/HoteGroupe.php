<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoteGroupe extends Model
{
    /**
     * Récupère les hotes appartenant aux groupes.
     */
    public function hotes()
    {
        return $this->belongstoMany(Hote::class);
    }
    
}

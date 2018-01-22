<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoteCategorie extends Model
{
    /**
     * Récupère les hotes appartenant aux catégories.
     */
    public function hotes()
    {
        return $this->belongstoMany(Hote::class);
    }
    
}

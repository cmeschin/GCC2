<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    /**
     * Récupère la demande appartenant a la periode.
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    /**
     * Récupère les services appartenant a la periode.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
}

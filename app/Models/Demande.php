<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    /**
     * Get the user that owns the demande.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hosts that belongs the demande.
     */
    public function hote()
    {
        return $this->hasMany(Hote::class);
    }

    /**
     * Get the services that belongs the demande.
     */
    public function service()
    {
        return $this->hasMany(Service::class);
    }

}

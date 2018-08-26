<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * Get the services that owns the action.
     */
    public function getServices()
    {
        return $this->hasMany(Service::class);
    }
    
    /**
     * Get the hosts that owns the action.
     */
    public function getHotes()
    {
        return $this->hasMany(Hote::class);
    }

    /**
     * Get the periodes that owns the action.
     */
    public function getPeriodes()
    {
        return $this->hasMany(Periode::class);
    }
    
}

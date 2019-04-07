<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HoteGroupe extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Récupère les hotes appartenant aux groupes.
     */
    public function hotes()
    {
        return $this->belongstoMany(Hote::class);
    }
    
}

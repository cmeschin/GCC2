<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HoteCategorie extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Récupère les hotes appartenant aux catégories.
     */
    public function hotes()
    {
        return $this->belongstoMany(Hote::class);
    }
    
}

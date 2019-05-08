<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hote extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * récupère la demande auquel appartient l'hote.
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    /**
     * récupère les demandes auxquelles appartiennent l'hote.
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    /**
     * Récupère les services appartenant à l'hote.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * récupère l'action appartenant à l'hote.
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
    
    /**
     * Récupère les commentaires de l'hote.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    
}

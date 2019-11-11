<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Récupère l'utilisateur du commentaire
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupère la demande du commentaire
     */
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
    
    /**
     * Récupère l'hôte du commentaire
     */
    public function hote()
    {
        return $this->belongsTo(Hote::class);
    }
    
    /**
     * Récupère le service du commentaire
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    /**
     * Récupère la période du commentaire
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    
}

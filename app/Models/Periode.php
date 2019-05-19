<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
    
    /**
     * récupère l'action appartenant à la periode.
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }

//    public function getPeriodeIdByName($tp_name)
//    {
//        return $this->where('tp_name',$tp_name)->value('tp_id');
//    }
    /**
     * Récupère les commentaires de le periode.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    
}

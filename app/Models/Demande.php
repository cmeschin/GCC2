<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{

    /**
     * Récupère l'utilisateur auquel la demande appartient
     */
    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupère les hôtes appartenant à la demande.
     */
    public function getHotes()
    {
        return $this->hasMany(Hote::class);
    }

    /**
     * Récupère les services appartenant à la demande.
     */
    public function getServices()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Récupère les périodes appartenant à la demande.
     */
    public function getPeriodes()
    {
        return $this->hasMany(Periode::class);
    }
    
    /**
     * Récupère les états de la demande.
     */
    public function getEtats()
    {
        return $this->belongstoMany(EtatDemande::class);
    }
    
    /**
     * Récupère le type de la demande.
     */
    public function getTypeDemande()
    {
        return $this->belongsTo(TypeDemande::class);
    }
    
    /**
     * Récupère les commentaires de la demande.
     */
    public function getHistories()
    {
        return $this->hasMany(History::class);
    }
    
    /**
     * Récupère les notifications de la demande.
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Function to get last x requests
     * @param $limit
     * @return mixed
     */
    public function getDemandes($limit)
    {
        return $this->orderBy('id', 'desc')->take($limit)->get(['reference','prestation','date_activation']);
    }

    public function getLastProcessed($limit)
    {
        return $this->where('etatdemande_id','=',5)->orderBy('updated_at', 'Desc')->take($limit)->get(['reference','prestation','date_activation']);
    }
}

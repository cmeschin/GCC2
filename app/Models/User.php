<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Récupère les demandes de l'utilisateur
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    /**
     * Récupère les commentaires de l'utilisateur.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }

    /**
     * Récupère les preferences de l'utilisateur.
     */
    public function preferences()
    {
        return $this->hasMany(Preference::class);
    }

    public function role($id)
    {
        return $this->where($id)->get('role');
    }
}

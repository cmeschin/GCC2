<?php

namespace App\Http\Controllers;

use App\Models\Centreon;
use App\Models\EtatDemande;
use App\Models\Preference;
use App\Models\TypeDemande;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Request;

class NouvelleDemandeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function index()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        $typedemandes = $this->get_typedemande();
        $etatdemandes = $this->get_etatdemande();
        $listdiffusions = $this->get_listdiffusion();
        $listprestations = $this->get_prestations();
        return view('nouvelledemande',compact('etatdemandes','typedemandes','listdiffusions','listprestations'));
    }

    public function get_etatdemande()
    {
        $etatdemandes = EtatDemande::all()->pluck('etat','id');
        return $etatdemandes;
    }

    public function get_typedemande()
    {
        $typedemandes = TypeDemande::all()->pluck('type','id');
        return $typedemandes;
    }

    public function get_listdiffusion()
    {
        $listdiffusions = Preference::All('id','user_id','valeur')->where('user_id', Auth::user()->id);
        return $listdiffusions;
    }
    
    public function get_prestations()
    {
        $listprestations = Centreon::All('sg_name');
        return $listprestations;
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
use App\Models\Preference;
use App\Models\TypeDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\DemandeNewRequest;

class NouvelleDemandeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     */
    
    
    public function initialisation()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }
        $refdemande = date("ymdHi") . "_" . Auth::user()->username;
        $typedemandes = $this->get_typedemande();
        
        $etatdemande = Lang::get('validation.custom.state.draft');
        $listdiffusions = $this->get_listdiffusion();
        $listprestations = $this->get_prestations();
        return view('template.infosgenerales',compact('typedemandes','listdiffusions','listprestations','refdemande','etatdemande'));
    }

    public function selection(DemandeNewRequest $request)
    {
        /**
         * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
         */
        if (! auth()->check()) {
            return redirect('/login');
        }

        /**
         * initialiser la demande en enregistrant les infos générales
         * 
         */
        /**
         * Ajout d'une demande
         */
        //dd($request);
        $etatdemande_id = EtatDemande::where('etat', 'draft')->value('id');
        //$dateactivation = date("Y-m-d",,strtotime(str_replace('/', '-',$request->dateactivation)));
        //$dateactivation = Carbon::createFromFormat('Y-m-d H', $request->dateactivation[0],'Europe/Paris')->toDateTimeString();
        $dateactivation = Carbon::now();
        //dd($request->dateactivation);
        //dd($dateactivation);
        //$etatdemande_id = $this->get_etatdemande()->where('etat', 'draft')->value('id');
        $userid = Auth::user()->id;
        $demande = new Demande;
        
        $demande->etatdemande_id    = $etatdemande_id;
        $demande->user_id           = $userid;
        $demande->reference         = $request->refdemande;
        $demande->date_activation   = $dateactivation;
        $demande->listediffusion_id = $request->listeDiffusion[0];
        $demande->typedemande_id    = $request->typeDemande[0];
        $demande->prestation        = $request->prestation[0];
        $demande->commentaire       = $request->description;
        
        $demande->save();
        
        /**
         * Afficher la seconde vue
         */
        //return view('template.selection',compact('refdemande'));
        return view('template.selection');
    }

//     public function selection()
//     {
//         return view('template.selection');
//     }
    
    public function parametrage()
    {
        /**
         * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
         */
        if (! auth()->check()) {
            return redirect('/login');
        }
        //$typedemandes = $this->get_typedemande();
        //$etatdemandes = $this->get_etatdemande();
        //$listdiffusions = $this->get_listdiffusion();
        //$listprestations = $this->get_prestations();
        //return view('template.parametrage');
        return 'parametrage';
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
        $listdiffusions = Preference::All('id','type','cle','user_id','valeur')->where('user_id', Auth::user()->id)->where('type', 'emails');
        return $listdiffusions;
    }
    
    public function get_prestations()
    {
        $listprestations = Centreon::All('sg_name');
        return $listprestations;
    }
}

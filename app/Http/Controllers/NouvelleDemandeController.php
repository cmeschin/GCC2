<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Models\Demande;
use App\Models\EtatDemande;
use App\Models\Preference;
use App\Models\TypeDemande;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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
        $refDemande = date("ymdHis") . "_" . Auth::user()->username;
        $typeDemandes = $this->getTypeDemande();
        
        $etatDemande = Lang::get('validation.custom.state.draft');
        $listDiffusions = $this->getListDiffusion();
        $listPrestations = $this->getPrestations();
        //dd($listPrestations);
        return view('template.infosgenerales',compact('typeDemandes','listDiffusions','listPrestations','refDemande','etatDemande'));
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
        $etatDemandeId = EtatDemande::where('etat', 'draft')->value('id');
        $dateActivation = Carbon::now();
        $userId = Auth::user()->id;
        $demande = new Demande;
        
        $demande->etatdemande_id    = $etatDemandeId;
        $demande->user_id           = $userId;
        $demande->reference         = $request->refDemande;
        $demande->date_activation   = $dateActivation;
        $demande->listediffusion_id = $request->listeDiffusion[0];
        $demande->typedemande_id    = $request->typeDemande[0];
        $demande->prestation        = $request->prestation[0];
        $demande->commentaire       = $request->description;
        
        $demande->save();
        
        /**
         * Afficher la seconde vue
         */
        //return view('template.selection',compact('refdemande'));
        $api = new ApiController;
        $token = $api->getToken();
        
        $servicesByServiceGroup = $api->getServicesByServiceGroup($token,$request->prestation[0]);
        /**
         * @TODO
         *  - extraire la liste des hotes de la variable ci-dessus => fait
         *  - récupérer les services complémentaire appartenant à la categorie 'Systeme' des hôtes extraits ci-dessus => fait
         *  - compléter le tableau précédent. => fait
         *  - récupérer host_address, host_activate, service_activate, service_timeperiod
         *  - renvoyer la vue "selection" avec les infos
         */
        //var_dump($servicesByServiceGroup);
        foreach ($servicesByServiceGroup['result'] as $value){
            // extraction des hôtes du tableau
            $res[]=$value['host name'];
        };
        // suppression des doublons d'hôte
        $hosts = array_unique($res);
        $serviceCategorie="Systeme";
        //dd($hosts);
        
        $servicesByServiceCategorieByHosts[] = $api->getServicesByServiceCategorieByHosts($token,$serviceCategorie, $hosts);
        //var_dump($servicesByServiceCategorieByHosts);
        foreach($servicesByServiceCategorieByHosts as $value){
            $servicesByServiceGroup['result'] = $value;
        };
        //dd($servicesByServiceGroup['result']);
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
    
    public function getEtatDemande()
    {
        $etatdemandes = EtatDemande::all()->pluck('etat','id');
        return $etatdemandes;
    }

    public function getTypeDemande()
    {
        $typedemandes = TypeDemande::all()->pluck('type','id');
        return $typedemandes;
    }

    public function getListDiffusion()
    {
        $listdiffusions = Preference::All('id','type','cle','user_id','valeur')->where('user_id', Auth::user()->id)->where('type', 'emails');
        return $listdiffusions;
    }
    
    public function getPrestations()
    {
        /**
         * Fonction de récupération de la lise des prestations
         * 
         * @TODO : trier la liste par ordre croissant et plus par id (par défaut) 
         */
        //$listprestations = Centreon::All('sg_name');
        $api = new ApiController;
        $token = $api->getToken();
        $result = $api->getServiceGroups($token);
        
        foreach ($result['result'] as $prestation){
            if ($prestation['name'] != null){
                $prestations[]=$prestation['name'];
            };
        };
        sort($prestations);
        //dd($prestations);
        return $prestations;
    }
}

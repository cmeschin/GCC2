<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
use App\Models\Preference;
use App\Models\TypeDemande;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class NouvelleDemandeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        //$this->middleware('ajax', ['only' => 'register']);
        //$this->middleware('ajax');
        if (! auth()->check()) {
            return redirect('/login');
        }
    }

    /**
     * Get all EtatDemande
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEtatDemande()
    {
        $etatdemandes = EtatDemande::all()->pluck('etat','id');
        return $etatdemandes;
    }

    /**
     * Get all listDiffusion
     *
     * @return Preference[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getListDiffusion()
    {
        $listDiffusions = Preference::All('id','type','cle','user_id','valeur')->where('user_id', Auth::user()->id)->where('type', 'emails');
        return $listDiffusions;
    }

    /**
     * Get all prestations
     *
     * @return array
     * @throws GuzzleException
     */
    public function getPrestations()
    {
        $api = new ApiController;
        $token = $api->getApiToken();
        $result = $api->getApiServiceGroups($token);

        foreach ($result['result'] as $prestation){
            if ($prestation['name'] != null){
                $prestations[]=$prestation['name'];
            };
        };
        sort($prestations);
        //dd($prestations);
        return $prestations;
    }

    /**
     * Get all TypeDemande
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTypeDemande()
    {
        $typedemandes = TypeDemande::all()->pluck('type','id');
        return $typedemandes;
    }

    /**
     * Fonction d'initialisation de la page informations générales pour une nouvelle demande
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws GuzzleException
     */
    public function initialisation()
    {
//        if (! auth()->check()) {
//            return redirect('/login');
//        }
        $refDemande = date("ymdHis") . "_" . Auth::user()->username;
        $typeDemandes = $this->getTypeDemande();

        $etatDemande = Lang::get('validation.custom.state.draft');
        $listDiffusions = $this->getListDiffusion();
        $listPrestations = $this->getPrestations();
        //dd($listPrestations);
        return view('template.infosgenerales',compact('typeDemandes','listDiffusions','listPrestations','refDemande','etatDemande'));
    }

    /**
     * Fonction chargée de traiter la selection et de charger les formulaires de paramétrage
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     *
     * @TODO
     */
    public function parametrage(DemandeNewRequest $request)
    {
        //$typedemandes = $this->get_typedemande();
        //$etatdemandes = $this->get_etatdemande();
        //$listdiffusions = $this->get_listdiffusion();
        //$listprestations = $this->get_prestations();
        return view('template.parametrage');
        //return 'parametrage';
    }

    /**
     * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
     *
     * @param DemandeNewRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws GuzzleException
     */
    public function selection(DemandeNewRequest $request)
    {
//        if (! auth()->check()) {
//            return redirect('/login');
//        }

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

        // initialiser la demande en enregistrant les infos générales
        $demande->save();

        $api = new ApiController;
        $centreon = new Centreon;
        $token = $api->getApiToken();
        $prestation = $request->prestation[0];

        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$prestation);
        /**
         * @TODO
         *  - extraire la liste des hotes de la variable ci-dessus => fait
         *  - récupérer les services complémentaire appartenant à la categorie 'Systeme' des hôtes extraits ci-dessus => fait
         *  - compléter le tableau précédent. => fait
         *  - récupérer:
         *      host_address, host_activate,
         *      service_activate,
         *      service_timeperiod => fait
         *  - renvoyer la vue "selection" avec les infos
         */
//        foreach ($servicesByServiceGroup['result'] as $value){
//            // extraction des hôtes du tableau
//            $res[]=$value['host name'];
//        };
//        suppression des doublons d'hôte
//        $hosts = array_unique($res);
        // extrait la liste des hôtes unitairement
        $hosts = array_unique(array_column($servicesByServiceGroup['result'],'host name'));
        //dd($hosts);

        $serviceCategorie = "Systeme";

        $servicesByServiceCategorieByHosts = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts, $prestation);

        //dd($servicesByServiceGroup,$servicesByServiceCategorieByHosts);
        // fusionne les deux tableaux
        $services = array_merge($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts);
        //$services = array_merge_recursive($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts[0]);
        //$services = $servicesByServiceGroup['result'] + $servicesByServiceCategorieByHosts;
        //dd($services);

        //récupérer la liste des service_id
        $serviceIds = array_column($services, 'service id');
        //dd($serviceIds);

        $timeperiods = $centreon->getCentreonTimeperiodByServiceIds($serviceIds);
        //dd($timeperiods);

        $serviceDetails = $centreon->getCentreonServiceDetailsByServiceIds($serviceIds);
        //dd($serviceDetails);

        $services = $this->addServiceTimeperiod($services,$timeperiods);

        $services = $this->addServiceDetails($services,$serviceDetails);
        //array_unique(array_column($services,'service id'));
        //sort($services);
        array_multisort(array_column($services, 'host name'),  SORT_ASC,
            array_column($services, 'service description'), SORT_ASC,
            $services);
        //dd($services);

        // Afficher la seconde vue
        return view('template.selection',compact('refDemande','services'));
    }

    /**
     * Add details on each services
     *
     * @param $services
     * @param $serviceDetails
     * @return array("host id", "host name", "service id", "service description", "tp name", "host address",
     *  "host activate", "service activate", "service categorie")
     */
    public function addServiceDetails($services, $serviceDetails)
    {
        //dd($services,$serviceDetails);
        $i = 0;
        foreach($services as $value)
        {
            //\Log::info('Service: ', [$value]);
            for($j=0;$j<count($serviceDetails);$j++){
                $indexHost = array_search($value['host id'],$serviceDetails[$j]);
                if ($indexHost)
                {
                    //\Log::info('Detail: ', [$serviceDetails[$j]]);
                    // get values in serviceDetails array
                    $hostAddress = $serviceDetails[$j]['host_address'];
                    $hostActivate = $serviceDetails[$j]['host_activate'];
                    $serviceActivate = $serviceDetails[$j]['service_activate'];
                    $serviceCategorie = $serviceDetails[$j]['sc_name'];

                    // set new values in services array
                    $services[$i]['host address'] = $hostAddress;
                    $services[$i]['host activate'] = $hostActivate;
                    $services[$i]['service activate'] = $serviceActivate;
                    $services[$i]['sc name'] = $serviceCategorie;

                    // if found exit loop and get new service in services array
                    break;
                }
            }
//            for($k=0;$k<count($serviceDetails);$k++){
//                $indexService = array_search($value['service id'],$serviceDetails[$k]);
//                if ($indexService)
//                {
//                    \Log::info('Detail Service: ', [$serviceDetails[$k]]);
//                    // get values in serviceDetails array
////                    $hostAddress = $serviceDetails[$k]['host_address'];
////                    $hostActivate = $serviceDetails[$k]['host_activate'];
//                    $serviceActivate = $serviceDetails[$k]['service_activate'];
//                    $serviceCategorie = $serviceDetails[$k]['sc_name'];
//
//                    // set new values in services array
////                    $services[$i]['host address'] = $hostAddress;
////                    $services[$i]['host activate'] = $hostActivate;
//                    $services[$i]['service activate'] = $serviceActivate;
//                    $services[$i]['sc name'] = $serviceCategorie;
//
//                    // if found exit loop and get new service in services array
//                    break;
//                }
//            }
            $i++;
        }
        //dd($services);
        return $services;

    }

    /**
     * Add timeperiod on each services
     *
     * @param $services
     * @param $timeperiods
     * @return array("host id", "host name", "service id", "service description", "tp name")
     */
    public function addServiceTimeperiod($services, $timeperiods)
    {
        //dd($services,$timeperiods);
        $i = 0;
        foreach($services as $value)
        {
            for($j=0;$j<count($timeperiods);$j++){
                $index = array_search($value['service id'],$timeperiods[$j]);
                if ($index)
                {
                    $tpName = $timeperiods[$j]['tp_name'];
                    $tpMonday = $timeperiods[$j]['tp_monday'];
                    $tpThursday = $timeperiods[$j]['tp_thursday'];
                    $tpWednesday = $timeperiods[$j]['tp_wednesday'];
                    $tpTuesday = $timeperiods[$j]['tp_tuesday'];
                    $tpFriday = $timeperiods[$j]['tp_friday'];
                    $tpSaturday = $timeperiods[$j]['tp_saturday'];
                    $tpSunday = $timeperiods[$j]['tp_sunday'];

                    $services[$i]['tp name'] = $tpName;
                    $services[$i]['tp monday'] = $tpMonday;
                    $services[$i]['tp thursday'] = $tpThursday;
                    $services[$i]['tp wednesday'] = $tpWednesday;
                    $services[$i]['tp tuesday'] = $tpTuesday;
                    $services[$i]['tp friday'] = $tpFriday;
                    $services[$i]['tp saturday'] = $tpSaturday;
                    $services[$i]['tp sunday'] = $tpSunday;
                    break;
                }
            }
            $i++;
        }
        //dd($services);
        return $services;

    }
}

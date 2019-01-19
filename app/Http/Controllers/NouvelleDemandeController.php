<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Http\Requests\ParametrageNewRequest;
use App\Http\Requests\SelectionNewRequest;
use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
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
        if (! auth()->check()) {
            return redirect('/login');
        }
    }

    /**
     * Fonction d'initialisation de la page informations générales pour une nouvelle demande
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws GuzzleException
     */
    public function initialisation()
    {
        $api = new ApiController;
        $token = $api->getApiToken();
        $refDemande = date("ymdHis") . "_" . Auth::user()->username;
        $typeDemandes = getTypeDemande();
        session(['refDemande' => $refDemande]);
        session(['token' => $token]);

        $etatDemande = Lang::get('validation.custom.state.draft');
        $listDiffusions = getListDiffusion();
        $listPrestations = getPrestations();
        return view('template.infosgenerales',compact('typeDemandes','listDiffusions','listPrestations','refDemande','etatDemande'));
    }

    /**
     * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
     *
     * @param DemandeNewRequest $request
     * @param $refDemande
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws GuzzleException
     */
    public function selection(DemandeNewRequest $request, $refDemande)
    {

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
        $token = session('token'); // récupère le token dans la variable de session
        //dd($token);
        $prestation = $request->prestation[0];

        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$prestation);
        // extrait la liste des hôtes unitairement
        $hosts = array_unique(array_column($servicesByServiceGroup['result'],'host name'));

        $serviceCategorie = "Systeme";

        $servicesByServiceCategorieByHosts = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts, $prestation);

        // fusionne les deux tableaux
        $services = array_merge($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts);
        //$services = array_merge_recursive($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts[0]);
        //$services = $servicesByServiceGroup['result'] + $servicesByServiceCategorieByHosts;

        //récupérer la liste des service_id
        $serviceIds = array_column($services, 'service id');

        $timeperiods = $centreon->getCentreonTimeperiodByServiceIds($serviceIds);
        $uniqueTimeperiods = $centreon->getCentreonUniqueTimeperiodsByServiceIds($serviceIds);

        $hosts = $centreon->getCentreonHostDetailsByHosts($hosts);

        $serviceDetails = $centreon->getCentreonServiceDetailsByServiceIds($serviceIds);

        $services = addServiceTimeperiod($services,$timeperiods);

        $services = addServiceDetails($services,$serviceDetails);
        //array_unique(array_column($services,'service id'));
        //sort($services);
        array_multisort(array_column($services, 'host name'),  SORT_ASC,
            array_column($services, 'service description'), SORT_ASC,
            $services);
//dd($services);
        /**
         * Enregistrement des variables en session
         */
        session(['services' => $services]);
        session(['hosts' => $hosts]);
        session(['timeperiods' => $uniqueTimeperiods]);
//        dd($this->_services);
        // Afficher la seconde vue
        return view('template.selection',compact('refDemande','services', 'uniqueTimeperiods', 'hosts'));
    }

    /**
     * Fonction chargée de traiter la selection et de charger les formulaires de paramétrage
     *
     * @param $refDemande
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function parametrage(SelectionNewRequest $request, $refDemande)
    {
        $api = new ApiController;

        $serviceSelected = $request->input('selection_service');
        $hostSelected = $request->input('selection_host');
        $timeperiodSelected = $request->input('selection_timeperiod');
        /**
         * récupération des variables en session
         */
        //$services = session('services');
        $hosts = session('hosts');
        $timeperiods = session('timeperiods');
        $token = session('token');

        $sites = $api->getApiHostgroups($token,'Site')['result'];
        array_multisort(array_column($sites, 'alias'),  SORT_ASC, $sites);

        $solutions = $api->getApiHostgroups($token,'Solution')['result'];
        array_multisort(array_column($solutions, 'alias'),  SORT_ASC, $solutions);

        $hostTypes = $api->getApiHostcategories($token,'Type_')['result'];
        array_multisort(array_column($hostTypes, 'alias'),  SORT_ASC, $hostTypes);

        $hostOss = $api->getApiHostcategories($token,'OS_')['result'];
        array_multisort(array_column($hostOss, 'alias'),  SORT_ASC, $hostOss);

        $hostFonctions = $api->getApiHostcategories($token,'Fonction_')['result'];
        array_multisort(array_column($hostFonctions, 'alias'),  SORT_ASC, $hostFonctions);

        if (count($serviceSelected) > 0){
            $myServices = addServiceMacros($serviceSelected);
        } else {
            $myServices = array();
        }
        if (count($hostSelected) > 0){
            foreach ($hostSelected as $currentHost)
            {
//                var_dump($currentHost);
                $key = array_search($currentHost, array_column($hosts, 'host_id'));
                $myHosts[] = $hosts[$key];
            }
        } else {
            $myHosts = array();
        }
        if (count($timeperiodSelected) > 0) {
            foreach ($timeperiodSelected as $currentTimeperiod) {
                $key = array_search($currentTimeperiod, array_column($timeperiods, 'timeperiod_id'));
                $myTimeperiods[] = $timeperiods[$key];
            }
        } else {
            $myTimeperiods = array();
        }

        foreach ($sites as &$site){
            $site['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['GroupeSite'] == substr($site['name'],5)){
                    $site['selected'][] = $host['host_name'];
                }
            }
        }

        foreach ($solutions as &$solution){
            $solution['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['GroupeSolution'] == substr($solution['name'],9)){
                    $solution['selected'][] = $host['host_name'];
                }
            }
        }

        foreach ($hostTypes as &$hostType){
            $hostType['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['CategorieType'] == substr($hostType['name'],5)){
                    $hostType['selected'][] = $host['host_name'];
                }
            }
        }

        foreach ($hostOss as &$hostOs){
            $hostOs['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['CategorieOS'] == substr($hostOs['name'],3)){
                    $hostOs['selected'][] = $host['host_name'];
                }
            }
        }

        foreach ($hostFonctions as &$hostFonction){
            $hostFonction['selected'] = array();
            foreach ($myHosts as $host){
                if ( stristr($host['CategorieFonction'],substr($hostFonction['name'],9))){ // cherche la fonction dans la chaine
                    $hostFonction['selected'][] = $host['host_name'];
                }
            }
        }

//        dd($sites,$solutions,$hostTypes,$hostOss,$hostFonctions);
        //dd($hosts,$myHosts,$hostSelected);
        return view('template.parametrage', compact( 'refDemande','myServices', 'myHosts', 'myTimeperiods', 'hosts', 'timeperiods'), array('sites' => $sites, 'solutions' => $solutions, 'hostTypes' => $hostTypes, 'hostOss' => $hostOss, 'hostFonctions' => $hostFonctions));
    }

    public function validation(ParametrageNewRequest $request)
    {
        return 'bingo';
    }
}

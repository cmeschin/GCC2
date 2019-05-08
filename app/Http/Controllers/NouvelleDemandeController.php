<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Http\Requests\ParametrageNewRequest;
use App\Http\Requests\SelectionNewRequest;
use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
use App\Models\Hote;
use App\Models\Service;
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
        $listPrestations = getPrestations($token);
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
        $demande->preference_id     = $request->listeDiffusion[0];
        $demande->typedemande_id    = $request->typeDemande[0];
        $demande->prestation        = $request->prestation[0];
        $demande->commentaire       = $request->description;

        // initialiser la demande en enregistrant les infos générales
        $demande->save();

        // récupérer l'id de la demande
        $idDemande = $demande->where('reference', $refDemande)->pluck('id');

        $api = new ApiController;
        $centreon = new Centreon;
        $token = session('token'); // récupère le token dans la variable de session
        //dd($token);
        $prestation = $request->prestation[0];

        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$prestation);
        // extrait la liste des hôtes unitairement
        $hosts = array_unique(array_column($servicesByServiceGroup['result'],'host_name'));

        $serviceCategorie = "Systeme";

        $servicesByServiceCategorieByHosts = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts, $prestation);

        // fusionne les deux tableaux
        $services = array_merge($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts);
        //$services = array_merge_recursive($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts[0]);
        //$services = $servicesByServiceGroup['result'] + $servicesByServiceCategorieByHosts;

        //récupérer la liste des service_id
        $serviceIds = array_column($services, 'service_id');
//        \Log::debug('ServiceIds: ' . $serviceIds);
//        dd($serviceIds);
        $timeperiods = $centreon->getCentreonTimeperiodByServiceIds($serviceIds);
        $uniqueTimeperiods = $centreon->getCentreonUniqueTimeperiodsByServiceIds($serviceIds);

        $hosts = $centreon->getCentreonHostDetailsByHosts($hosts);
        fixCentreonKbUrl($hosts);

        $serviceDetails = $centreon->getCentreonServiceDetailsByServiceIds($serviceIds);
//        dd($serviceDetails);
        $services = addServiceTimeperiod($services,$timeperiods);

        $services = addServiceDetails($services,$serviceDetails);
        fixCentreonKbUrl($services);
        //array_unique(array_column($services,'service_id'));
        //sort($services);
        // tri le tableau par ordre croissant host - service
        array_multisort(array_column($services, 'host_name'),  SORT_ASC,
            array_column($services, 'service_description'), SORT_ASC,
            $services);
//dd("hosts",$hosts,"services",$services);
        /**
         * Enregistrement des variables en session
         */
        session(['services' => $services]);
        session(['hosts' => $hosts]);
        session(['timeperiods' => $uniqueTimeperiods]);
        session(['idDemande' => $idDemande]);

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
//        $api = new ApiController;

        $serviceSelected = $request->input('selection_service');
        $hostSelected = $request->input('selection_host');
        $timeperiodSelected = $request->input('selection_timeperiod');
        /**
         * récupération des variables en session
         */
        $idDemande = session('idDemande');
        $services = session('services');
        $hosts = session('hosts');
        $timeperiods = session('timeperiods');
        $token = session('token');

        $sites = getSites($token);
        $solutions = getSolutions($token);
        $hostTypes = getHostTypes($token);
        $hostOss = getHostOss($token);
        $hostFonctions = getHostFonctions($token);

        $serviceTemplates = getServiceTemplates($token);

        if ($serviceSelected){
            $i = 0;
            foreach ($serviceSelected as $currentService)
            {
                $key = array_search($currentService, array_column($services, 'service_id'));
                $myServices[] = $services[$key];
                $myServices[$i]['nom'] = defineHoteNom($myServices[$i]['host_name']);
                $myServices[$i]['site'] = defineHoteSite($myServices[$i]['host_name']);
                $myServices[$i]['href'] = defineServiceSearch($myServices[$i]['host_name'],$myServices[$i]['service_description']);
                $i++;
            }
            $myServices = addServiceMacros($myServices);
        } else {
            $myServices = array();
        }
        if ($hostSelected){
            $i = 0;
            foreach ($hostSelected as $currentHost)
            {
                $key = array_search($currentHost, array_column($hosts, 'host_id'));
                $myHosts[] = $hosts[$key];
                $myHosts[$i]['nom'] = defineHoteNom($myHosts[$i]['host_name']);
                $myHosts[$i]['site'] = defineHoteSite($myHosts[$i]['host_name']);
                $myHosts[$i]['href'] = defineHoteSite($myHosts[$i]['host_name']);
                $i++;
            }
        } else {
            $myHosts = array();
        }
        if ($timeperiodSelected) {
            foreach ($timeperiodSelected as $currentTimeperiod) {
                $key = array_search($currentTimeperiod, array_column($timeperiods, 'tp_id'));
                $myTimeperiods[] = $timeperiods[$key];
            }
        } else {
            $myTimeperiods = array();
        }

        foreach ($sites as &$site){
            $site['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['GroupeSite'] == substr($site['name'],5)){
                    $site['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($solutions as &$solution){
            $solution['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['GroupeSolution'] == substr($solution['name'],9)){
                    $solution['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostTypes as &$hostType){
            $hostType['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['CategorieType'] == substr($hostType['name'],5)){
                    $hostType['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostOss as &$hostOs){
            $hostOs['selected'] = array();
            foreach ($myHosts as $host){
                if ($host['CategorieOS'] == substr($hostOs['name'],3)){
                    $hostOs['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostFonctions as &$hostFonction){
            $hostFonction['selected'] = array();
            foreach ($myHosts as $host){
                if ( stristr($host['CategorieFonction'],substr($hostFonction['name'],9))){ // cherche la fonction dans la chaine
                    $hostFonction['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($timeperiods as &$timeperiod){
            $timeperiod['selected'] = array();
            foreach ($myServices as $service){
                if ( $service['tp_name'] == $timeperiod['tp_name'] ){
                    $timeperiod['selected'][] = $service['service_id'];
                }
            }
        }
//dd($myServices);
        foreach ($serviceTemplates as &$serviceTemplate){
            $serviceTemplate['selected'] = array();
            foreach ($myServices as $service){
                if ( $service['service_template_description'] == $serviceTemplate['description'] ){
                    $serviceTemplate['selected'][] = $service['service_id'];
                }
            }
        }

        foreach ($hosts as &$host){
            $host['selected'] = array();
            foreach ($myServices as $service){
                if ( $service['host_id'] == $host['host_id'] ){
                    $host['selected'][] = $service['service_id'];
                }
            }
        }
//        dd("myServices",$myServices,"myHosts",$myHosts,"myTimeperiods",$myTimeperiods,"hosts",$hosts,"services",$services,"timeperiods",$timeperiods,"sites",$sites,"solutions",$solutions,"hostTypes",$hostTypes,"hostOss",$hostOss,"hostFonctions",$hostFonctions,"serviceTemplates",$serviceTemplates);

        /**
         * Enregistrer les données collectées en base
         */

        $registerHotes = New Hote;
        foreach ($myHosts as $host){
            $registerHotes->demande_id = $idDemande;
            $registerHotes->centreon_host_id = $myHosts['host_id'];
            $registerHotes->centreon_host_name = $myHosts['host_name'];
            $registerHotes->nom =
            $registerHotes->ip = $myHosts['host_address'];
        }

        $registerServices = New Service;
        $registerServices->demande_id    = $idDemande;
        $registerServices->user_id           = $userId;
        $demande->reference         = $request->refDemande;
        $demande->date_activation   = $dateActivation;
        $demande->preference_id     = $request->listeDiffusion[0];
        $demande->typedemande_id    = $request->typeDemande[0];
        $demande->prestation        = $request->prestation[0];
        $demande->commentaire       = $request->description;

        // initialiser la demande en enregistrant les infos générales
        $demande->save();

        return view('template.parametrage', compact( 'refDemande','myServices', 'myHosts', 'myTimeperiods',
            'hosts', 'timeperiods','serviceTemplates'),
            array('sites' => $sites, 'solutions' => $solutions, 'hostTypes' => $hostTypes, 'hostOss' => $hostOss, 'hostFonctions' => $hostFonctions));
    }

    public function deleteService($refDemande,$serviceid)
    {
        /**
         * @TODO:
         *      - retirer l'enregistrement du tableau
         *      - retirer le service de myServices
         *      - retirer le service de hosts['selected']
         *      - retirer le service de timeperiods['selected']
         *      - retirer le service de serviceTemplates['selected']
         *
         */
//        Service::where('etat', 'draft')->value('id');
//        $service = Service->Demande()->where('reference', $refDemande)->value(')->find($serviceid)->where('');
//        $service->delete();
    }
    /**
     * Go to validation page
     * @param ParametrageNewRequest $request
     * @return string
     *
     * @TODO: verify valid ip addresses
     */
    public function validation(ParametrageNewRequest $request)
    {
        $ipaddress = $request->host_address;

        return 'bingo';
    }
}

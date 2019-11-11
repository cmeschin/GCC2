<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Http\Requests\ParametrageNewRequest;
use App\Http\Requests\SelectionNewRequest;
use App\Models\Action;
use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
use App\Models\Hote;
use App\Models\Macros;
use App\Models\Periode;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

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

        \Log::debug('récupération du contenu de la prestation: ' . $prestation);
        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$prestation);
        // extrait la liste des hôtes unitairement
        \Log::debug('Extraction de la liste des hôtes');
        $hosts = array_unique(array_column($servicesByServiceGroup['result'],'host_name'));

        $serviceCategorie = "Systeme";

        \Log::debug('Récupération des sondes de la catégorie système pour la liste des hôtes');
        $servicesByServiceCategorieByHosts = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts, $prestation);

        // fusionne les deux tableaux
        \Log::debug('fusion des deux tableaux');
        $services = array_merge($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts);
        //$services = array_merge_recursive($servicesByServiceGroup['result'],$servicesByServiceCategorieByHosts[0]);
        //$services = $servicesByServiceGroup['result'] + $servicesByServiceCategorieByHosts;

        //récupérer la liste des service_id
        \Log::debug('extraction de la liste des ServicesId');
        $serviceIds = array_column($services, 'service_id');
//        \Log::debug('ServiceIds: ' . $serviceIds);
//        dd($serviceIds);
        \Log::debug('récupération de la liste des timeperiodes');
        $timeperiods = $centreon->getCentreonTimeperiodByServiceIds($serviceIds);
        \Log::debug('filtrage des timepériodes uniques');
        $uniqueTimeperiods = $centreon->getCentreonUniqueTimeperiodsByServiceIds($serviceIds);
        \Log::debug('Timeperiode, ajout des détails');
        $uniqueTimeperiods = addTimeperiodDetails($uniqueTimeperiods);

        \Log::debug('Récupération du détail des hotes');
        $hosts = $centreon->getCentreonHostDetailsByHosts($hosts);
        \Log::debug('Ajout du détail des hotes');
        $hosts = addHostDetails($hosts);
        \Log::debug('Fix centreonKbUrl');
        fixCentreonKbUrl($hosts);

        \Log::debug('Récupération du détail des services');
        $serviceDetails = $centreon->getCentreonServiceDetailsByServiceIds($serviceIds);
//        dd($serviceDetails);
        \Log::debug('Services Ajout détail timeperiod');
        $services = addServiceTimeperiod($services,$timeperiods);

        \Log::debug('Services Ajout du detail des services');
        $services = addServiceDetails($services,$serviceDetails);

        \Log::debug('Fix CentreonKbUrl');
        fixCentreonKbUrl($services);
        //array_unique(array_column($services,'service_id'));
        //sort($services);
        // tri le tableau par ordre croissant host - service
        \Log::debug('Tri croissant du tableau Services par Host et service');
        array_multisort(array_column($services, 'host_name'),  SORT_ASC,
            array_column($services, 'service_description'), SORT_ASC,
            $services);
//dd("hosts",$hosts,"services",$services);
        /**
         * Enregistrement des variables en session
         */
        \Log::debug('Enregistrement des variables en session');
        session(['services' => $services]);
        session(['hosts' => $hosts]);
        session(['timeperiods' => $uniqueTimeperiods]);

        // Afficher la seconde vue
        \Log::debug('Affichage de la vue Selection');

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
        $idDemande = Demande::where('reference', $refDemande)->value('id');
        //dd($idDemande);
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

        // Initialisation des tableaux
//        $myServices = array();
//        $myHosts = array();
//        $myTimeperiods = array();

        if ($serviceSelected){
            //$i = 0;
            foreach ($serviceSelected as $currentService)
            {
                $key = array_search($currentService, array_column($services, 'service_id'));
                //dd($key);
//                $myServices[] = $services[$key];
                $services[$key]['selected'] = true;
//                $i++;
            }
            $services = addServiceMacros($services);
        }
        if ($hostSelected){
//            $i = 0;
            foreach ($hostSelected as $currentHost)
            {
                $key = array_search($currentHost, array_column($hosts, 'host_id'));
//                $myHosts[] = $hosts[$key];
                $hosts[$key]['selected'] = true;
//                $i++;
            }
        }
        if ($timeperiodSelected) {
            foreach ($timeperiodSelected as $currentTimeperiod) {
                $key = array_search($currentTimeperiod, array_column($timeperiods, 'tp_id'));
//                $myTimeperiods[] = $timeperiods[$key];
                $timeperiods[$key]['selected'] = true;
            }
        }

//        dd($services,$hosts,$timeperiods);

        foreach ($sites as &$site){
            $site['selected'] = array();
            foreach ($hosts as $host){
                if ($host['GroupeSite'] == substr($site['name'],5) && $host['selected'] == true){
                    $site['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($solutions as &$solution){
            $solution['selected'] = array();
            foreach ($hosts as $host){
                if ($host['GroupeSolution'] == substr($solution['name'],9) && $host['selected'] == true){
                    $solution['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostTypes as &$hostType){
            $hostType['selected'] = array();
            foreach ($hosts as $host){
                if ($host['CategorieType'] == substr($hostType['name'],5) && $host['selected'] == true){
                    $hostType['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostOss as &$hostOs){
            $hostOs['selected'] = array();
            foreach ($hosts as $host){
                if ($host['CategorieOS'] == substr($hostOs['name'],3) && $host['selected'] == true){
                    $hostOs['selected'][] = $host['host_id'];
                }
            }
        }

        foreach ($hostFonctions as &$hostFonction){
            $hostFonction['selected'] = array();
            foreach ($hosts as $host){
                if ( stristr($host['CategorieFonction'],substr($hostFonction['name'],9)) && $host['selected'] == true){ // cherche la fonction dans la chaine
                    $hostFonction['selected'][] = $host['host_id'];
                }
            }
        }

//        foreach ($timeperiods as &$timeperiod){
//            $timeperiod['selected'] = array();
//            foreach ($services as $service){
//                if ( $service['tp_name'] == $timeperiod['tp_name']  && $service['selected'] == true){
//                    $timeperiod['selected'][] = $service['service_id'];
//                }
//            }
//        }
//dd($myServices);
        foreach ($serviceTemplates as &$serviceTemplate){
            $serviceTemplate['selected'] = array();
            foreach ($services as $service){
                if ( $service['service_template_description'] == $serviceTemplate['description']  && $service['selected'] == true){
                    $serviceTemplate['selected'][] = $service['service_id'];
                }
            }
        }

//        foreach ($hosts as &$host){
//            $host['selected'] = array();
//            foreach ($myServices as $service){
//                if ( $service['host_id'] == $host['host_id'] ){
//                    $host['selected'][] = $service['service_id'];
//                }
//            }
//        }

//        dd("hosts",$hosts,"services",$services,"timeperiods",$timeperiods,"sites",$sites,"solutions",$solutions,
//            "hostTypes",$hostTypes,"hostOss",$hostOss,"hostFonctions",$hostFonctions,"serviceTemplates",$serviceTemplates);

        /**
         * Enregistrer les données collectées en base
         */
        DB::begintransaction();

        try {
//dd($hosts);
            $i = 0;
            foreach ($hosts as $host){
                $registerHotes = New Hote;
                \Log::info('HostName ' . $i . ': ' . $host['host_name']);
                // insertion de tous les hôtes de la prestation
                $registerHotes->demande_id          = $idDemande;
                $registerHotes->centreon_host_id    = $host['host_id'];
                $registerHotes->centreon_host_name  = $host['host_name'];
                $registerHotes->nom                 = $host['nom'];
                $registerHotes->description         = $host['host_alias'];
                $registerHotes->ip                  = $host['host_address'];
                $registerHotes->site                = $host['site'];
                $registerHotes->solution            = $host['GroupeSolution'];
                $registerHotes->type                = $host['CategorieType'];
                $registerHotes->os                  = $host['CategorieOS'];
                $registerHotes->actif               = $host['host_activate'];
                $registerHotes->consigne            = $host['ehi_notes_url'];
                $registerHotes->selected            = $host['selected'];
                if ($host['selected'] == true) {
                    $registerHotes->action_id           = Action::where('action','Modify')->value('id');
                }
                $registerHotes->save();
                $i++;
            }

            foreach ($timeperiods as $timeperiod){
                $registerPeriodes = New Periode;
                \Log::info('TimePeriod ' . $i . ': ' . $timeperiod['tp_name']);
                // insertion des périodes sélectionnés
                $registerPeriodes->demande_id   = $idDemande;
                $registerPeriodes->tp_name      = $timeperiod['tp_name'];
                $registerPeriodes->tp_monday      = $timeperiod['tp_monday'];
                $registerPeriodes->tp_tuesday      = $timeperiod['tp_tuesday'];
                $registerPeriodes->tp_wednesday      = $timeperiod['tp_wednesday'];
                $registerPeriodes->tp_thursday      = $timeperiod['tp_thursday'];
                $registerPeriodes->tp_friday      = $timeperiod['tp_friday'];
                $registerPeriodes->tp_saturday      = $timeperiod['tp_saturday'];
                $registerPeriodes->tp_sunday      = $timeperiod['tp_sunday'];
                $registerPeriodes->selected        = $timeperiod['selected'];
                if ($timeperiod['selected'] == true) {
                    $registerPeriodes->action_id           = Action::where('action','Modify')->value('id');
                }
                $registerPeriodes->save();
            }

//            $registerServices = New Service;
//            foreach ($myServices as $myService){
//                // insertion des services sélectionnés
//                $registerServices->demande_id                   = $idDemande;
//                $registerServices->hote_id                      = Hote::where('centreon_host_id',$myService['host_id'])->value('id');
//                $registerServices->centreon_service_id          = $myService['service_id'];
//                $registerServices->centreon_service_template_id = $myService['service_template_id'];
//                $registerServices->nom                          = $myService['service_description'];
//                $registerServices->tp_name                      = $myService['tp_name'];
//                $registerServices->frequence                    = $myService['service_interval'];
//                $registerServices->actif                        = $myService['service_activate'];
//                if ($myService['esi_notes_url']){
//                    $registerServices->consigne                 = $myService['esi_notes_url'];
//                };
//                $registerServices->action_id                    = Action::where('action','Modify')->value('id');
//                $registerServices->selected                     = true;
//
//                $registerServices->save();
//
//                $registerMacros = New Macros;
//
//                foreach($myService['macros']['result'] as $macro){
//                    $registerMacros->service_id = $registerServices->id;
//                    $registerMacros->macro_name = $macro['macro_name'];
//                    $registerMacros->macro_value = $macro['macro_value'];
//                    $registerMacros->is_password = $macro['is_password'];
//                    $registerMacros->description = $macro['description'];
//                    $registerMacros->source = $macro['source'];
//                }
//            }
        }
        catch(ValidationException $e){
            DB::rollback();
            return Redirect::back()->withErrors($e);
            //var_dump($e->getErrors());
        }

        DB::commit();

        return view('template.parametrage', compact( 'refDemande', 'services', 'hosts', 'timeperiods','serviceTemplates'),
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

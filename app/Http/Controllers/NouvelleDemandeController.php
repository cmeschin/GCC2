<?php

namespace App\Http\Controllers;

//use function Adldap\Connections\Provider\auth;
use App\Http\Requests\DemandeNewRequest;
use App\Models\Centreon;
use App\Models\Demande;
use App\Models\EtatDemande;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
        $refDemande = date("ymdHis") . "_" . Auth::user()->username;
        $typeDemandes = getTypeDemande();

        $etatDemande = Lang::get('validation.custom.state.draft');
        $listDiffusions = getListDiffusion();
        $listPrestations = getPrestations();
        //dd($listPrestations);
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
        $token = $api->getApiToken();
        $prestation = $request->prestation[0];

        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$prestation);
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
//        dd($services);

        //récupérer la liste des service_id
        $serviceIds = array_column($services, 'service id');
        //dd($serviceIds);

        $timeperiods = $centreon->getCentreonTimeperiodByServiceIds($serviceIds);
//        dd($timeperiods);
        $uniqueTimeperiods = $centreon->getCentreonUniqueTimeperiodsByServiceIds($serviceIds);
//        dd($uniqueTimeperiods);

        $hosts = $centreon->getCentreonHostDetailsByHosts($hosts);
        //dd($hosts);

        $serviceDetails = $centreon->getCentreonServiceDetailsByServiceIds($serviceIds);
        //dd($serviceDetails);

        $services = addServiceTimeperiod($services,$timeperiods);

        $services = addServiceDetails($services,$serviceDetails);
        //array_unique(array_column($services,'service id'));
        //sort($services);
        array_multisort(array_column($services, 'host name'),  SORT_ASC,
            array_column($services, 'service description'), SORT_ASC,
            $services);
        //dd($services);

        // Afficher la seconde vue
        return view('template.selection',compact('refDemande','services', 'uniqueTimeperiods', 'hosts'));
    }

    /**
     * Fonction chargée de traiter la selection et de charger les formulaires de paramétrage
     *
     * @param $refDemande
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     *
     * @TODO
     * - parcourir le formulaire pour récupérer les éléments sélectionnés en trois tableaux
     *      - services
     *      - hosts
     *      - timeperiods
     */
    public function parametrage(Request $request, $refDemande)
    {
        $productname = $request->input('selection_service[]');
        //$data = Input::get('selection_service[]');
        dd($productname);
        //return $data;
        //$typedemandes = $this->get_typedemande();
        //$etatdemandes = $this->get_etatdemande();
        //$listdiffusions = $this->get_listdiffusion();
        //$listprestations = $this->get_prestations();
        return view('template.parametrage', compact('refDemande', 'data'));
    }
}

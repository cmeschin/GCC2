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

    /**
     * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function parametrage()
    {
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

    /**
     * Fonction chargée de traiter les infos générales et de charger le contenu des hosts et services de la prestation
     *
     * @param DemandeNewRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws GuzzleException
     */
    public function selection(DemandeNewRequest $request)
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

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

        $servicesByServiceGroup = $api->getApiServicesByServiceGroup($token,$request->prestation[0]);
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
        foreach ($servicesByServiceGroup['result'] as $value){
            // extraction des hôtes du tableau
            $res[]=$value['host name'];
        };
        // suppression des doublons d'hôte
        $hosts = array_unique($res);
        $serviceCategorie="Systeme";

        $servicesByServiceCategorieByHosts[] = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts);
        foreach($servicesByServiceCategorieByHosts as $value){
            $servicesByServiceGroup['result'] = $value;
        };

        //récupérer la liste des timeperiod
        foreach ($servicesByServiceGroup['result'] as $value){
            // extraction des hôtes du tableau
            $serviceIds[] = $value['service id'];
        };
        //dd($serviceIds);
        $timeperiods[]=$centreon->getCentreonTimeperiodByServiceIds($serviceIds);
        //dd($timeperiods);

        // Afficher la seconde vue
        return view('template.selection');
    }

    public function addServiceValues($servicesByServiceGroup,$values)
    {

    }
}

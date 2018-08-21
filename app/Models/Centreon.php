<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Centreon extends Model
{
    protected $connection = 'centreon';
    
    //protected $table = 'servicegroup';
    
    
    public function getCentreonServiceGroups()
    {
        /**
         * Fonction de récupérations de toutes les prestations (servicegroups)
         * - déprécié depuis l'utilisation de l'API -> getServiceGroups()
         * @var $centreonServiceGroups
         */
        $centreonServiceGroups = $this->all('sg_name');
        return $centreonServiceGroups;
    }

    /**
     * @param $serviceCategorie
     * @param $hosts
     * @return array
     */
    public function getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts)
    {
        /**
         * Fonction de récupération de tous les services appartenant à la catégorie et aux hotes en paramètres
         * @var
         *  - categorie  (string) (mandatory)
         *  - hosts (array) (mandatory)
         * Return:
         *  - host id
         *  - host name
         *  - service id
         *  - service description
         */
        //var_dump ($serviceCategorie,$hosts);
        $res = DB::connection('centreon')->table('service as s')
        ->select('h.host_id as host id','h.host_name as host name','s.service_id as service id','s.service_description as service description')
        ->leftjoin('host_service_relation as hsr','s.service_id','=','hsr.service_service_id')
        ->leftjoin('host as h','hsr.host_host_id','=','h.host_id')
        ->leftjoin('service as st','s.service_template_model_stm_id','=','st.service_id')
        ->leftjoin('service_categories_relation as scr','st.service_id','=','scr.service_service_id')
        ->leftjoin('service_categories as sc','scr.sc_id','=','sc.sc_id')
        ->where('sc.sc_name',$serviceCategorie)
        ->whereIn('h.host_name',$hosts)
        ->orderBy('h.host_name','asc')
        ->orderBy('s.service_description','asc')
        ;
        
        $centreonServicesByServiceCategorieByHosts = json_decode($res->get(), true);
        //dd($centreonServicesByServiceCategorieByHosts);
        return $centreonServicesByServiceCategorieByHosts;
    }
    
}

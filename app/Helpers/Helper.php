<?php
/**
 * Created by PhpStorm.
 * User: zic
 * Date: 09/10/2018
 * Time: 22:12
 *
 * Declaration des fonctions communes à l'ensemble de l'application
 */

use App\Http\Controllers\ApiController;
use App\Models\EtatDemande;
use App\Models\Preference;
use App\Models\TypeDemande;

/**
 * Add details on each services
 *
 * @param $services
 * @param $serviceDetails
 * @return array("host id", "host name", "service id", "service description", "tp name", "host address",
 *  "host activate", "service activate", "service categorie")
 */
if (!function_exists('addServiceTimeperiod')) {
    function addServiceDetails($services, $serviceDetails)
    {
        //dd($services,$serviceDetails);
        \Log::info('Service: ajout des détails');
        $i = 0;
        foreach($services as $value)
        {
            \Log::debug('Service: ', [$value]);
            for($j=0;$j<count($serviceDetails);$j++){
                $indexService = array_search($value['service id'],$serviceDetails[$j]);
                if ($indexService)
                {
                    \Log::debug('Detail: ', [$serviceDetails[$j]]);
                    // get values in serviceDetails array
                    $hostAddress = $serviceDetails[$j]['host_address'];
                    $hostActivate = $serviceDetails[$j]['host_activate'];
                    $serviceActivate = $serviceDetails[$j]['service_activate'];
                    $serviceCategorie = $serviceDetails[$j]['sc_name'];
                    $serviceInterval = $serviceDetails[$j]['service_normal_check_interval'];

                    // set new values in services array
                    $services[$i]['host address'] = $hostAddress;
                    $services[$i]['host activate'] = $hostActivate;
                    $services[$i]['service activate'] = $serviceActivate;
                    $services[$i]['sc name'] = $serviceCategorie;
                    $services[$i]['service interval'] = $serviceInterval;

                    // if found, exit loop and get new service in services array
                    break;
                }
            }
            $i++;
        }
        \Log::info('Service: détails ajoutés');
        //dd($services);
        return $services;
    }
}

/**
 * Add timeperiod on each services
 *
 * @param $services
 * @param $timeperiods
 * @return array("host id", "host name", "service id", "service description", "tp name")
 */
if (!function_exists('addServiceTimeperiod')) {
    function addServiceTimeperiod($services, $timeperiods)
    {
        //dd($services,$timeperiods);
        $i = 0;
        foreach ($services as $value) {
            for ($j = 0; $j < count($timeperiods); $j++) {
                $index = array_search($value['service id'], $timeperiods[$j]);
                if ($index) {
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

/**
 * Get all EtatDemande
 *
 * @return \Illuminate\Support\Collection
 */
if (!function_exists('getEtatDemande')) {
    function getEtatDemande()
    {
        $etatdemandes = EtatDemande::all()->pluck('etat', 'id');
        return $etatdemandes;
    }
}

/**
 * Get all listDiffusion
 *
 * @return Preference[]|\Illuminate\Database\Eloquent\Collection
 */
if (!function_exists('getListDiffusion')) {
    function getListDiffusion()
    {
        $listDiffusions = Preference::All('id', 'type', 'cle', 'user_id', 'valeur')->where('user_id', Auth::user()->id)->where('type', 'emails');
        return $listDiffusions;
    }
}

/**
 * Get all prestations
 *
 * @return array
 */
if (!function_exists('getPrestations')) {
    function getPrestations()
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
}

/**
 * Get all TypeDemande
 *
 * @return \Illuminate\Support\Collection
 */
if (!function_exists('getTypeDemande')) {
    function getTypeDemande()
    {
        $typedemandes = TypeDemande::all()->pluck('type', 'id');
        return $typedemandes;
    }
}

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
 *  "host activate", "service activate", "service categorie", "service interval")
 */
if (!function_exists('addServiceDetails')) {
    function addServiceDetails($services, $serviceDetails)
    {
        //dd($services,$serviceDetails);
        \Log::info('Service: ajout des détails');
        $i = 0;

        foreach($services as $value)
        {
            //\Log::debug('Service: ', [$value]);
            for($j=0;$j<count($serviceDetails);$j++){
                $indexService = array_search($value['service id'],$serviceDetails[$j]);
                $trouve = False;
                if ($indexService)
                {
                    //\Log::debug('Detail: ', [$serviceDetails[$j]]);
                    // get values in serviceDetails array
                    $hostAddress = $serviceDetails[$j]['host_address'];
                    $hostActivate = $serviceDetails[$j]['host_activate'];
                    $serviceActivate = $serviceDetails[$j]['service_activate'];
                    $serviceCategorie = $serviceDetails[$j]['sc_name'];
                    $serviceInterval = $serviceDetails[$j]['service_normal_check_interval'];
//                    $serviceTemplateId = $serviceDetails[$j]['service_template_id'];
//                    $serviceTemplateDescription = $serviceDetails[$j]['service_template_description'];

                    // set new values in services array
                    $services[$i]['host address'] = $hostAddress;
                    $services[$i]['host activate'] = $hostActivate;
                    $services[$i]['service activate'] = $serviceActivate;
                    $services[$i]['sc name'] = $serviceCategorie;
                    $services[$i]['service interval'] = $serviceInterval;
//                    $services[$i]['service template id'] = $serviceTemplateId;
//                    $services[$i]['service template description'] = $serviceTemplateDescription;

                    // if found, exit loop and get new service in services array
                    $trouve = True;
                    break;
                }
            }
            if (!$trouve)
            {
                \Log::debug('ERREUR Service configuration incomplète: ', [$value]);
            }

            $i++;
        }
        \Log::info('Service: détails ajoutés');
        //dd($services);
        //var_dump($services);
        return $services;
    }
}

/**
 * Add macros of each services
 * @param $services
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
if (!function_exists('addServiceMacros')) {
    function addServiceMacros($serviceSelected)
    {
        \Log::debug('Service: ajout des macros...');
        $api = new ApiController;
        $services = session('services');
        foreach ($serviceSelected as $currentService)
        {
            //dd($services[$i],$serviceSelected, $currentService);
            $key = array_search($currentService, array_column($services, 'service id'));
            $myServices[] = $services[$key];
        }
        //dd($myServices);

        /**
         * get macros for myServices (new tab with only selected services
         */
        $i = 0;
        foreach ($myServices as $myService)
        {
            $macros = $api->getApiServiceMacros($myService);

            $myServices[$i]['macros'] = $macros;
            $i++;
        }
        session(['myServices' => $myServices]);
        return $myServices;
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
        \Log::info('Service: ajout des TimePeriod');
        //dd($services,$timeperiods);
        $i = 0;
        foreach ($services as $value) {
            for ($j = 0; $j < count($timeperiods); $j++) {
                $index = array_search($value['service id'], $timeperiods[$j]);
                $trouve = False;
                if ($index) {
                    $tpName = $timeperiods[$j]['tp_name'];

                    $services[$i]['tp name'] = $tpName;

                    $trouve = True;
                    break;
                }
            }
            if (!$trouve)
            {
                \Log::debug('ERREUR TimePeriod configuration incomplète: ', [$value]);
            }
            $i++;
        }
        \Log::info('Service: TimePeriod ajoutés');
        //dd($services);
        return $services;
   }
}

/**
 * Decode argument for User display
 */
if (!function_exists('decodeArg')) {
    function decodeArg($arg)
    {
        //TODO: decoding argument
        return $arg;
    }
}

/**
 * Encode argument for Admin and param display
 */
if (!function_exists('encodeArg')) {
    function encodeArg($arg)
    {
        //TODO: encoding argument
        return $arg;
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
        $token = session('token');
        //dd($token);
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

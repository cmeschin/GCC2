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
 * @return array("host_id", "host_name", "service_id", "service_description", "tp_name", "host_address",
 *  "host_activate", "service_activate", "service_categorie", "service_interval")
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
                $indexService = array_search($value['service_id'],$serviceDetails[$j]);
                $trouve = False;
                if ($indexService)
                {
                    //\Log::debug('Detail: ', [$serviceDetails[$j]]);
                    // get values in serviceDetails array
                    $services[$i]['host_address'] = $serviceDetails[$j]['host_address'];
                    $services[$i]['host_activate'] = $serviceDetails[$j]['host_activate'];
                    $services[$i]['service_activate'] = $serviceDetails[$j]['service_activate'];
                    $services[$i]['sc_name'] = $serviceDetails[$j]['sc_name'];
                    $services[$i]['service_interval'] = $serviceDetails[$j]['service_normal_check_interval'];
//                    $serviceTemplateId = $serviceDetails[$j]['service_template_id'];
//                    $serviceTemplateDescription = $serviceDetails[$j]['service_template_description'];

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
        fixArrayKey($services);
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
            $key = array_search($currentService, array_column($services, 'service_id'));
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
        fixArrayKey($myServices);
        session(['myServices' => $myServices]);
        return $myServices;
    }
}
/**
 * Add timeperiod on each services
 *
 * @param $services
 * @param $timeperiods
 * @return array("host_id", "host_name", "service_id", "service_description", "tp_name")
 */
if (!function_exists('addServiceTimeperiod')) {
    function addServiceTimeperiod($services, $timeperiods)
    {
        \Log::info('Service: ajout des TimePeriod');
        //dd($services,$timeperiods);
        $i = 0;
        foreach ($services as $value) {
            for ($j = 0; $j < count($timeperiods); $j++) {
                $index = array_search($value['service_id'], $timeperiods[$j]);
                $trouve = False;
                if ($index) {
                    $services[$i]['tp_name'] = $timeperiods[$j]['tp_name'];
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
        fixArrayKey($services);
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
        fixArrayKey($etatdemandes);
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
//        fixArrayKey($listDiffusions);
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
        fixArrayKey($prestations);
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
//        fixArrayKey($typedemandes);
        return $typedemandes;
    }
}

/**
 * Function to replace all spaces by underscores in all keys of arrays recursively
 * @param $arr
 */
if (!function_exists('fixArrayKey')){
    function fixArrayKey(&$arr)
    {
        if (is_array($arr)){
            $arr=array_combine(array_map(function($str){return str_replace(" ","_",$str);},array_keys($arr)),array_values($arr));
            foreach($arr as $key=>$val)
            {
                if(is_array($val)) fixArrayKey($arr[$key]);
            }
        } else {
            dd($arr);
        }
    }
}

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
                    $services[$i]['esi_notes_url'] = $serviceDetails[$j]['esi_notes_url'];

                    $services[$i]['service_template_id'] = $serviceDetails[$j]['service_template_id'];
                    $services[$i]['service_template_description'] = $serviceDetails[$j]['service_template_description'];

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
    function addServiceMacros($serviceSelected,$myServices)
    {
        \Log::debug('Service: ajout des macros...');
        $api = new ApiController;
//        $services = session('services');
//        foreach ($serviceSelected as $currentService)
//        {
//            //dd($services[$i],$serviceSelected, $currentService);
//            $key = array_search($currentService, array_column($services, 'service_id'));
//            $myServices[] = $services[$key];
//        }
        //dd($myServices);

        /**
         * get macros for myServices (new tab with only selected services)
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
//        dd($myServices);
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
 * Get all hosts types
 * @param $token
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
if (!function_exists('getHostTypes')) {
    function getHostTypes($token)
    {
        $api = new ApiController;
        $hostTypes = $api->getApiHostcategories($token,'Type_')['result'];
        array_multisort(array_column($hostTypes, 'alias'),  SORT_ASC, $hostTypes);
        return $hostTypes;
    }
}

/**
 * Get all hosts Oss
 * @param $token
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
if (!function_exists('getHostOss')) {
    function getHostOss($token)
    {
        $api = new ApiController;
        $hostOss = $api->getApiHostcategories($token,'OS_')['result'];
        array_multisort(array_column($hostOss, 'alias'),  SORT_ASC, $hostOss);
        return $hostOss;
    }
}

/**
 * Get all hosts functions
 * @param $token
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
if (!function_exists('getHostFonctions')) {
    function getHostFonctions($token)
    {
        $api = new ApiController;
        $hostFonctions = $api->getApiHostcategories($token,'Fonction_')['result'];
        array_multisort(array_column($hostFonctions, 'alias'),  SORT_ASC, $hostFonctions);
        return $hostFonctions;
    }
}

/**
 * Get all service templates
 * @param $token
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 * TODO: filtrer seulement les services actifs (non locked, activés et custom-TESSI, sinon custom sinon normal)
 */

if (!function_exists('getServiceTemplates')) {
    function getServiceTemplates($token)
    {
        $api = new ApiController;
        $serviceTemplates = $api->getApiServiceTemplates($token)['result'];
        array_multisort(array_column($serviceTemplates, 'description'),  SORT_ASC, $serviceTemplates);
        return $serviceTemplates;
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
    function getPrestations($token)
    {
        $api = new ApiController;
//        $token = session('token');
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
 * Get all Sites
 *
 * @return \Illuminate\Support\Collection
 */
if (!function_exists('getSites')) {
    function getSites($token)
    {
        $api = new ApiController;
        $sites = $api->getApiHostgroups($token,'Site')['result'];
        array_multisort(array_column($sites, 'alias'),  SORT_ASC, $sites);
        return $sites;
    }
}

/**
 * Get all Solutions
 *
 * @return \Illuminate\Support\Collection
 */
if (!function_exists('getSolutions')) {
    function getSolutions($token)
    {
        $api = new ApiController;
        $solutions = $api->getApiHostgroups($token, 'Solution')['result'];
        array_multisort(array_column($solutions, 'alias'), SORT_ASC, $solutions);
        return $solutions;
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

/**
 * Function to rebuild urls of centreonKB hosts and services
 * @param $arr
 */
if (!function_exists('fixCentreonKbUrl')){
    function fixCentreonKbUrl(&$arr)
    {
        if (is_array($arr)){
            if (array_key_exists("service_description", $arr[0])){
                // si le tableau contient la clé service_description => c'est un tableau service
                foreach($arr as $key=>$val){
                    foreach($val as $key2=>$val2){
//                        var_dump($key2,$val2);
                        if ($key2 == 'esi_notes_url'){
                            $newVal2=str_replace("./include/","http://192.168.0.22/centreon/include/",str_replace("\$HOSTNAME\$",$val['host_name'],str_replace("\$SERVICEDESC\$",$val['service_description'],$val2)));
                            $arr[$key][$key2]=$newVal2;
//                            var_dump('#####',$val[$key2],"<br/>");
                        }
                    }
                }
            }elseif(array_key_exists("host_alias", $arr[0])){
                // sinon si le tableau contient la clé host_alias, c'est un tableau host
                foreach($arr as $key=>$val){
                    foreach($val as $key2=>$val2){
//                        var_dump($key2,$val2);
                        if ($key2 == 'ehi_notes_url'){
                            $newVal2=str_replace("./include/","http://192.168.0.22/centreon/include/",str_replace("\$HOSTNAME\$",$val['host_name'],$val2));
                            $arr[$key][$key2]=$newVal2;
//                            var_dump('#####',$val[$key2],"<br/>");
                        }
                    }
                }
            } else {
                // sinon on affiche le tableau pour debug
                dd("cas non géré", $arr[0]);
            }

        } else {
            dd($arr);
        }
    }
}

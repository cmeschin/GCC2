<?php

namespace App\Http\Controllers;

use App\Models\Centreon;
use GuzzleHttp\Client as GuzzleClient;

define("URL",  "http://192.168.0.7/centreon/api/index.php");

class ApiController extends Controller
{

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken()
    {
        /**
         * Fonction de récupération d'un token pour accéder aux éléments de centreon
         *
         */
        /**
         * @TODO variabiliser l'URL et les user/password
         */
        //$URL = "http://192.168.0.7/centreon/api/index.php";
        $parameters="?action=authenticate";
        $apiClient = new GuzzleClient();
        $res = $apiClient->request('POST', URL.$parameters, [
                'form_params' => [
                        'username' => 'centreon',
                        'password' => 'centreon',
                ]
        ]);
        $token = json_decode($res->getBody(), true);
        $token =  $token['authToken'];
        return $token;
    }

    public function getServiceGroups($token)
    {
        /**
         * Fonction de récupération de tous les groupes de service (prestation)
         *
         */
        /**
         * @TODO variabiliser l'URL et les user/password
         */
        //$mytoken = $token;
        //$URL = "http://192.168.0.7/centreon/api/index.php";
        $parameters="?action=action&object=centreon_clapi";
        $headers = [
                'Content-Type' => 'application/json',
                'centreon-auth-token' => $token,
        ];
        
        $apiClient = new GuzzleClient([
                'headers' => $headers
        ]);
        
        $res = $apiClient->request('POST', URL.$parameters, [
                'json' => [
                        'action' => 'show',
                        'object' => 'sg',
                ]
        ]);
        $serviceGroups = json_decode($res->getBody(), true);
        //var_dump($serviceGroups);
        return $serviceGroups;
    }

    /**
     * Fonction de récupération de tous service pour le groupe de service (prestation) donné
     *
     * @param $token
     * @param $serviceGroup
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServicesByServiceGroup($token, $serviceGroup)
    {
        /**
         * @TODO variabiliser l'URL et les user/password
         */
        //$mytoken = $token;
        //$myservicegroup = $servicegroup;
        //$URL = "http://192.168.0.7/centreon/api/index.php";
        $parameters="?action=action&object=centreon_clapi";
        $headers = [
                'Content-Type' => 'application/json',
                'centreon-auth-token' => $token,
        ];
        
        $apiClient = new GuzzleClient([
            'headers' => $headers
        ]);
        
        $res = $apiClient->request('POST', URL.$parameters, [
                'json' => [
                        'action' => 'getservice',
                        'object' => 'sg',
                        'values' => $serviceGroup
                ]
        ]);
        $servicesByServiceGroup = json_decode($res->getBody(), true);
        //var_dump($servicesByServiceGroup);
        return $servicesByServiceGroup;
    }

    /**
     * Fonction de récupération des services par la categorie et la liste des hôtes en paramètre
     *
     * @param $token
     * @param $serviceCategorie
     * @param $hosts
     * @return string
     */
    public function getServicesByServiceCategorieByHosts($token, $serviceCategorie, $hosts)
    {
        $centreon = new Centreon;
        $servicesByServiceCategorieByHosts = $centreon->getCentreonServicesByServiceCategorieByHosts($serviceCategorie,$hosts);

        return $servicesByServiceCategorieByHosts;
        
    }
    
}

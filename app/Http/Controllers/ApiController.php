<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client as GuzzleClient;

define("URL",  "http://192.168.0.22/centreon/api/index.php");

class ApiController extends Controller
{
    /**
     * @TODO variabiliser l'URL et les user/password
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Fonction de récupération de tous les hotes répondant au filtre
     *
     * @param $token
     * @param $host
     * @return array('id','name','alias','address','activate')
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiHost($token,$host)
    {
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
                'object' => 'host',
                'values' => $host
            ]
        ]);
        $host = json_decode($res->getBody(), true);
        return $host;
    }

    /**
     * Fonction de récupération de tous les hotes
     *
     * @param $token
     * @return array('id','name','alias','address','activate')
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiHosts($token)
    {
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
                'object' => 'host'
            ]
        ]);
        $hosts = json_decode($res->getBody(), true);
        //var_dump($serviceGroups);
        return $hosts;
    }

    /**
     * @param $myService (array ['host','service'])
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiServiceMacros($myService)
    {
        $parameters="?action=action&object=centreon_clapi";
        $headers = [
            'Content-Type' => 'application/json',
            'centreon-auth-token' => session('token'),
        ];

        $apiClient = new GuzzleClient([
            'headers' => $headers
        ]);

        $res = $apiClient->request('POST', URL.$parameters, [
            'json' => [
                'action' => 'getmacro',
                'object' => 'service',
                'values' => $myService['host name'] . ';' . $myService['service description']
            ]
        ]);
        $macros = json_decode($res->getBody(), true);
        return $macros;
    }
    /**
     * Fonction de récupération de tous les groupes de service (prestation)
     *
     * @param $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiServiceGroups($token)
    {
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
     * Fonction de récupération de tous les services pour le groupe de service (prestation) donné
     *
     * @param $token
     * @param $serviceGroup
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiServicesByServiceGroup($token, $serviceGroup)
    {
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
     * Fonction de récupération d'un token pour accéder aux éléments de centreon
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiToken()
    {
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

}

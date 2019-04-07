<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client as GuzzleClient;

define("URL",  env(API_URL));

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
        fixArrayKey($host);
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
        fixArrayKey($hosts);
        return $hosts;
    }

    /**
     * Fonction de récupération de tous les hostcategories répondant au filtre
     *
     * @param $token
     * @param $hostcategory
     * @return array('id','name','alias')
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiHostcategories($token,$hostcategory)
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
                'object' => 'HC',
                'values' => $hostcategory
            ]
        ]);
        $hostcategories = json_decode($res->getBody(), true);
        fixArrayKey($hostcategories);
        return $hostcategories;
    }

    /**
     * Fonction de récupération de tous les hostgroups répondant au filtre
     *
     * @param $token
     * @param $hostgroup
     * @return array('id','name','alias')
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiHostgroups($token,$hostgroup)
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
                'object' => 'HG',
                'values' => $hostgroup
            ]
        ]);
        $hostgroups = json_decode($res->getBody(), true);
        fixArrayKey($hostgroups);
        return $hostgroups;
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
                'values' => $myService['host_name'] . ';' . $myService['service_description']
            ]
        ]);
        $macros = json_decode($res->getBody(), true);
        fixArrayKey($macros);
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
        fixArrayKey($serviceGroups);
        return $serviceGroups;
    }

    /**
     * Fonction de récupération de tous les templates de service
     *
     * @param $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApiServiceTemplates($token)
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
                'object' => 'STPL',
            ]
        ]);
        $serviceTemplates = json_decode($res->getBody(), true);
        //var_dump($serviceTemplates);
        fixArrayKey($serviceTemplates);
        return $serviceTemplates;
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
//        var_dump($servicesByServiceGroup);
        fixArrayKey($servicesByServiceGroup);
//        dd($servicesByServiceGroup);
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
                'username' => env(API_USER),
                'password' => env(API_PASSWORD),
            ]
        ]);
        $token = json_decode($res->getBody(), true);
//        $token = $token['authToken'];
        return $token['authToken'];
    }

}

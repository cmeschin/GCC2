<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class ApiController extends Controller
{
    
    public function getToken()
    {
        /**
         * Fonction de récupération d'un token pour accéder aux éléments de centreon
         *
         */
        /**
         * @TODO variabiliser l'URL et les user/password
         */
        $URL = "http://192.168.0.7/centreon/api/index.php";
        $PARAMETERS="?action=authenticate";
        $APICLIENT = new GuzzleClient();
        $res = $APICLIENT->request('POST', $URL.$PARAMETERS, [
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
         * Fonction de récupération des groupes de service (prestation)
         *
         */
        /**
         * @TODO variabiliser l'URL et les user/password
         */
        //$mytoken = $token;
        $URL = "http://192.168.0.7/centreon/api/index.php";
        $PARAMETERS="?action=action&object=centreon_clapi";
        $HEADERS = [
                'Content-Type' => 'application/json',
                //'centreon-auth-token' => $mytoken,
                'centreon-auth-token' => $token,
        ];
        
        $APICLIENT = new GuzzleClient([
                'headers' => $HEADERS
        ]);
        
        $res = $APICLIENT->request('POST', $URL.$PARAMETERS, [
                'json' => [
                        'action' => 'show',
                        'object' => 'sg',
                ]
        ]);
        $servicegroups = json_decode($res->getBody(), true);
        return $servicegroups;
    }

    public function getServicesByServiceGroup($token,$servicegroup)
    {
        //$mytoken = $token;
        //$myservicegroup = $servicegroup;
        $URL = "http://192.168.0.7/centreon/api/index.php";
        $PARAMETERS="?action=action&object=centreon_clapi";
        $HEADERS = [
                'Content-Type' => 'application/json',
                //'centreon-auth-token' => $mytoken,
                'centreon-auth-token' => $token,
        ];
        
        $APICLIENT = new GuzzleClient([
            'headers' => $HEADERS
        ]);
        
        $res = $APICLIENT->request('POST', $URL.$PARAMETERS, [
                'json' => [
                        'action' => 'getservice',
                        'object' => 'sg',
                        'values' => $servicegroup
                ]
        ]);
        $servicesbyservicegroup = json_decode($res->getBody(), true);
        dd($servicesbyservicegroup);
        return $servicesbyservicegroup;
    }
}

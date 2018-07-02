<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class ApiController extends Controller
{
    /**
     * Fonction de récupération d'un token pour accéder aux éléments de centreon
     * 
     */
    /**
     * @TODO variabiliser l'URL et les user/password
     */
    
    public function getToken()
    {
        $apiClient = new GuzzleClient();
        $res = $apiClient->request('POST', 'http://192.168.0.7/centreon/api/index.php?action=authenticate', [
                'form_params' => [
                        'username' => 'centreon',
                        'password' => 'centreon',
                ]
        ]);
        echo $res->getStatusCode();
        // "200"
//        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
//        echo $res->getBody();
        $token = json_decode($res->getBody(), true);
        //dd($token);
        $token =  $token['authToken'];
        return $token;
        // {"type":"User"...'
    }
    
    public function getServicesByServiceGroup($token,$servicegroup)
    {
        $myToken = $token;
        $myServiceGroup = $servicegroup;
        $headers = [
            'Content-Type' => 'application/json',
            'centreon-auth-token' => $myToken,
        ];
        
        var_dump($headers);
        $apiClient = new GuzzleClient([
            'headers' => $headers
        ]);
        var_dump($apiClient);
        
        $res = $apiClient->request('POST', 'http://192.168.0.7/centreon/api/index.php?action=action&object=centreon_clapi', [
                'form_params' => [
                        'action' => 'getservice',
                        'object' => 'sg',
                        'values' => "'" . $myServiceGroup . "'"
                ]
        ]);
        var_dump($res);
        echo $res->getStatusCode();
        // "200"
        //        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        //        echo $res->getBody();
        $serviceByServiceGroup = json_decode($res->getBody(), true);
        //dd($token);
        //$token =  $token['authToken'];
        return $serviceByServiceGroup;
        // {"type":"User"...'
    }
}

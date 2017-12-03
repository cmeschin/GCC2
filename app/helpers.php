<?php
/**
 * Created by PhpStorm.
 * User: zic
 * Date: 03/12/2017
 * Time: 23:50
 */

if (!function_exists('currentRoute')) {
    function currentRoute(...$routes)
    {
        foreach($routes as $route) {
            if(request()->url() == $route) {
                return ' active';
            }
        }
    }
}
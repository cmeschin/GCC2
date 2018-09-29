<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast;


class Centreon extends Model
{
    protected $connection = 'centreon';

    public function getCentreonServiceDetailsByServiceIds($serviceIds)
    {

        $res = DB::connection('centreon')->table('service as s')
            ->select(DB::RAW("CONVERT(h.host_id, CHAR) as 'host id'"), 'h.host_address', 'h.host_activate', DB::RAW("CONVERT(s.service_id, CHAR) as 'service id'"), 's.service_activate', 'sc.sc_name')
            ->leftjoin('host_service_relation as hsr','s.service_id','=','hsr.service_service_id')
            ->leftjoin('host as h','hsr.host_host_id','=','h.host_id')
            ->leftjoin('service as st1','s.service_template_model_stm_id', '=','st1.service_id')
            ->leftjoin('service as st2','st1.service_template_model_stm_id', '=','st2.service_id')
            ->leftjoin('service as st3','st2.service_template_model_stm_id', '=','st3.service_id')
            ->leftjoin('service as st4','st3.service_template_model_stm_id', '=','st4.service_id')
            ->leftjoin('service as st5','st4.service_template_model_stm_id', '=','st5.service_id')
            ->leftjoin('service as st6','st5.service_template_model_stm_id', '=','st6.service_id')
            ->leftjoin('service as st7','st6.service_template_model_stm_id', '=','st7.service_id')
            ->leftjoin('service as st8','st7.service_template_model_stm_id', '=','st8.service_id')
            ->leftjoin('service_categories_relation as scr','scr.service_service_id','=',
                DB::raw("coalesce(
                    st1.service_id,
                    st2.service_id,
                    st3.service_id,
                    st4.service_id,
                    st5.service_id,
                    st6.service_id,
                    st7.service_id,
                    st8.service_id)")
            )
            ->leftjoin('service_categories as sc','scr.sc_id','=','sc.sc_id')
            ->whereNull('sc.level')
            ->where('sc.sc_description', 'NOT LIKE', 'Type_%')
            ->where('h.host_register','=','1')
            ->wherein('s.service_id', $serviceIds)
            ->orderBy('h.host_name','asc')
            ->orderBy('s.service_description','asc')
        ;

        $serviceDetails = json_decode($res->get(), true);
        return $serviceDetails;

    }

    /**
     * Get services by serviceCategorie (one value) and by Hosts (list)
     *
     * @param $serviceCategorie
     * @param $hosts
     * @param $prestation
     * @return array ('host id','host name','service id','service description')
     */
    public function getCentreonServicesByServiceCategorieByHosts($serviceCategorie, $hosts, $prestation)
    {
        $res = DB::connection('centreon')->table('service as s')
        ->select(DB::RAW("CONVERT(h.host_id, CHAR) as 'host id'"), 'h.host_name as host name', DB::RAW("CONVERT(s.service_id, CHAR) as 'service id'"), 's.service_description as service description', DB::RAW('GROUP_CONCAT(sg.sg_name) as sg_name'))
        ->leftjoin('host_service_relation as hsr','s.service_id','=','hsr.service_service_id')
        ->leftjoin('host as h','hsr.host_host_id','=','h.host_id')
        ->leftjoin('service as st','s.service_template_model_stm_id','=','st.service_id')
        ->leftjoin('service_categories_relation as scr','st.service_id','=', 'scr.service_service_id')
        ->leftjoin('service_categories as sc','scr.sc_id','=','sc.sc_id')
        ->leftjoin('servicegroup_relation as sgr', 's.service_id', '=', 'sgr.service_service_id')
        ->leftjoin('servicegroup as sg', 'sgr.servicegroup_sg_id', '=', 'sg.sg_id')
        ->where('sc.sc_name', $serviceCategorie)
        ->whereIn('h.host_name', $hosts)
            ->groupBy('host name', 'service description', 'host id', 'service id')
        ->orderBy('h.host_name','asc')
        ->orderBy('s.service_description','asc')
        ;
        
        $services = json_decode($res->get(), true);
        //dd($services);
        $services = $this->dropDuplicateServicesByPrestation($services,$prestation);
        //dd($services);
        return $services;
    }

    /**
     * Drop duplicate services already get by prestation
     *
     * @param $services
     * @param $prestation
     * @return array cleaned of duplicates
     */
    public function dropDuplicateServicesByPrestation($services, $prestation)
    {
        if ( !is_array( $services ) ) {
            return false;
        }
        foreach ( $services as $element ) {
            //dd($element);
            if ( strstr( $element['sg_name'], $prestation ) ) {
                $key = array_search($element,$services);
                unset($services[$key]);
                //dd($key);
                $delElements[] = $element;
            }
        }
        //dd($delElements,$services);
        return $services;
    }

    /**
     * Get Timeperiods by service Id's (list)
     *
     * @param $serviceIds
     * @return array(service_id, tp_id, tp_name, tp_monday, tp_tuesday, tp_wednesday, tp_thursday, tp_friday, tp_saturday, tp_sunday)
     */
    public function getCentreonTimeperiodByServiceIds($serviceIds)
    {
        $res = DB::connection('centreon')->table('service as s')
            ->select(DB::RAW("CONVERT(s.service_id, CHAR) as 'service_id'"),
                't.tp_id',
                't.tp_name',
                't.tp_monday',
                't.tp_tuesday',
                't.tp_wednesday',
                't.tp_thursday',
                't.tp_friday',
                't.tp_saturday',
                't.tp_sunday'
            )
            ->leftjoin('service as st1','s.service_template_model_stm_id', '=','st1.service_id')
            ->leftjoin('service as st2','st1.service_template_model_stm_id', '=','st2.service_id')
            ->leftjoin('service as st3','st2.service_template_model_stm_id', '=','st3.service_id')
            ->leftjoin('service as st4','st3.service_template_model_stm_id', '=','st4.service_id')
            ->leftjoin('service as st5','st4.service_template_model_stm_id', '=','st5.service_id')
            ->leftjoin('service as st6','st5.service_template_model_stm_id', '=','st6.service_id')
            ->leftjoin('service as st7','st6.service_template_model_stm_id', '=','st7.service_id')
            ->leftjoin('service as st8','st7.service_template_model_stm_id', '=','st8.service_id')
            ->leftjoin('timeperiod as t','t.tp_id', '=',
                DB::raw("coalesce(s.timeperiod_tp_id,
                    st1.timeperiod_tp_id,
                    st2.timeperiod_tp_id,
                    st3.timeperiod_tp_id,
                    st4.timeperiod_tp_id,
                    st5.timeperiod_tp_id,
                    st6.timeperiod_tp_id,
                    st7.timeperiod_tp_id,
                    st8.timeperiod_tp_id)")
            )
            ->whereIn('s.service_id',$serviceIds)
        ;

        $timeperiods = json_decode($res->get(), true);
        return $timeperiods;

    }
}

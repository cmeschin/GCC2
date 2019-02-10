<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Centreon extends Model
{
    protected $connection = 'centreon';

    /**
     * get hosts details by list of hosts
     * @param $hosts
     * @return mixed
     */
    public function getCentreonHostDetailsByHosts($hosts)
    {

        $res = DB::connection('centreon')->table('host as h')
            ->select('h.host_id'
                , 'h.host_name'
                , 'h.host_address'
                , 'h.host_alias'
                , 'h.host_activate'
                , 'ehi.ehi_notes_url'
                , DB::RAW("GROUP_CONCAT(DISTINCT ht.host_name) as Modeles")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(hgtype.hg_name,6)) as GroupeType")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(hgsolution.hg_name,10)) as GroupeSolution")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(hgsite.hg_name,6)) as GroupeSite")
//                , DB::RAW("GROUP_CONCAT(DISTINCT substr(coalesce(hcarchitecture.hc_name,hctarchitecture.hc_name),14)) as CategorieArchitecture")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(coalesce(hcfonction.hc_name,hctfonction.hc_name),10) SEPARATOR ',') as CategorieFonction")
//                , DB::RAW("GROUP_CONCAT(DISTINCT substr(coalesce(hclangue.hc_name,hctlangue.hc_name),8)) as CategorieLangue")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(coalesce(hcos.hc_name,hctos.hc_name),4)) as CategorieOS")
                , DB::RAW("GROUP_CONCAT(DISTINCT substr(coalesce(hctype.hc_name,hcttype.hc_name),6)) as CategorieType"))


            ->leftjoin('host_template_relation as htr','h.host_id','=','htr.host_host_id')
            ->leftjoin('host as ht','htr.host_tpl_id','=','ht.host_id')
            ->leftjoin('hostgroup_relation as hgr','h.host_id','=','hgr.host_host_id')
            ->leftjoin('hostgroup as hgtype', function($join){
                $join->on('hgr.hostgroup_hg_id','=','hgtype.hg_id');
                $join->on( DB::RAW("substr(hgtype.hg_name,1,5)"),'=' ,DB::RAW('"Type_"'));})
            ->leftjoin('hostgroup as hgsolution', function($join){
                $join->on('hgr.hostgroup_hg_id','=','hgsolution.hg_id');
                $join->on( DB::RAW("substr(hgsolution.hg_name,1,9)"),'=' ,DB::RAW('"Solution_"'));})
            ->leftjoin('hostgroup as hgsite', function($join){
                $join->on('hgr.hostgroup_hg_id','=','hgsite.hg_id');
                $join->on( DB::RAW("substr(hgsite.hg_name,1,5)"),'=' ,DB::RAW('"Site_"'));})
            ->leftjoin('hostcategories_relation as hcr','hcr.host_host_id','=','h.host_id')
            ->leftjoin('hostcategories_relation as hcrt','hcrt.host_host_id','=','ht.host_id')
//            ->leftjoin('hostcategories as hcarchitecture', function($join){
//                $join->on('hcr.hostcategories_hc_id','=','hcarchitecture.hc_id');
//                $join->on( DB::RAW("substr(hcarchitecture.hc_name,1,13)"),'=' ,DB::RAW('"Architecture_"'));})
            ->leftjoin('hostcategories as hcfonction', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hcfonction.hc_id');
                $join->on( DB::RAW("substr(hcfonction.hc_name,1,9)"),'=' ,DB::RAW('"Fonction_"'));})
//            ->leftjoin('hostcategories as hclangue', function($join){
//                $join->on('hcr.hostcategories_hc_id','=','hclangue.hc_id');
//                $join->on( DB::RAW("substr(hclangue.hc_name,1,7)"),'=' ,DB::RAW('"Langue_"'));})
            ->leftjoin('hostcategories as hcos', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hcos.hc_id');
                $join->on( DB::RAW("substr(hcos.hc_name,1,3)"),'=' ,DB::RAW('"OS_"'));})
            ->leftjoin('hostcategories as hctype', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hctype.hc_id');
                $join->on( DB::RAW("substr(hctype.hc_name,1,5)"),'=' ,DB::RAW('"Type_"'));})
//            ->leftjoin('hostcategories as hctarchitecture', function($join){
//                $join->on('hcr.hostcategories_hc_id','=','hctarchitecture.hc_id');
//                $join->on( DB::RAW("substr(hctarchitecture.hc_name,1,13)"),'=' ,DB::RAW('"Architecture_"'));})
            ->leftjoin('hostcategories as hctfonction', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hctfonction.hc_id');
                $join->on( DB::RAW("substr(hctfonction.hc_name,1,9)"),'=' ,DB::RAW('"Fonction_"'));})
//            ->leftjoin('hostcategories as hctlangue', function($join){
//                $join->on('hcr.hostcategories_hc_id','=','hctlangue.hc_id');
//                $join->on( DB::RAW("substr(hctlangue.hc_name,1,7)"),'=' ,DB::RAW('"Langue_"'));})
            ->leftjoin('hostcategories as hctos', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hctos.hc_id');
                $join->on( DB::RAW("substr(hctos.hc_name,1,3)"),'=' ,DB::RAW('"OS_"'));})
            ->leftjoin('hostcategories as hcttype', function($join){
                $join->on('hcr.hostcategories_hc_id','=','hcttype.hc_id');
                $join->on( DB::RAW("substr(hcttype.hc_name,1,5)"),'=' ,DB::RAW('"Type_"'));})
            -> leftjoin('extended_host_information as ehi', 'ehi.host_host_id', '=', 'h.host_id')
            ->where('h.host_register','=','1')
            ->wherein('h.host_name', $hosts)
            ->groupby('h.host_name','h.host_id', 'h.host_address', 'h.host_alias', 'h.host_activate','ehi.ehi_notes_url')
            ->orderBy('h.host_name','asc')
        ;

        $hostDetails = json_decode($res->get(), true);
        return $hostDetails;

    }

    public function getCentreonServiceDetailsByServiceIds($serviceIds)
    {

        $res = DB::connection('centreon')->table('service as s')
            ->select(DB::RAW("CONVERT(h.host_id, CHAR) as 'host id'"),
                'h.host_address',
                'h.host_activate',
                DB::RAW("CONVERT(s.service_id, CHAR) as 'service id'"),
                's.service_activate',
                'sc.sc_name',
                DB::RAW("CONCAT(coalesce(
                    s.service_normal_check_interval,
                    st1.service_normal_check_interval,
                    st2.service_normal_check_interval,
                    st3.service_normal_check_interval,
                    st4.service_normal_check_interval,
                    st5.service_normal_check_interval,
                    st6.service_normal_check_interval,
                    st7.service_normal_check_interval,
                    st8.service_normal_check_interval),' Min') as 'service_normal_check_interval'"),
                DB::RAW("CONVERT(st1.service_id, CHAR) as 'service_template_id'"),
                DB::RAW("CONVERT(st1.service_description, CHAR) as 'service_template_description'")
            )
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
        ->select(DB::RAW("CONVERT(h.host_id, CHAR) as 'host id'"),
            'h.host_name as host name',
            DB::RAW("CONVERT(s.service_id, CHAR) as 'service id'"),
            's.service_description as service description',
            DB::RAW('GROUP_CONCAT(sg.sg_name) as sg_name'),
            DB::RAW("CONVERT(s.service_template_model_stm_id, CHAR) as 'service_template_id'"),
            DB::RAW("CONVERT(st.service_description, CHAR) as 'service_template_description'")
        )
        ->leftjoin('host_service_relation as hsr','s.service_id','=','hsr.service_service_id')
        ->leftjoin('host as h','hsr.host_host_id','=','h.host_id')
        ->leftjoin('service as st','s.service_template_model_stm_id','=','st.service_id')
        ->leftjoin('service_categories_relation as scr','st.service_id','=', 'scr.service_service_id')
        ->leftjoin('service_categories as sc','scr.sc_id','=','sc.sc_id')
        ->leftjoin('servicegroup_relation as sgr', 's.service_id', '=', 'sgr.service_service_id')
        ->leftjoin('servicegroup as sg', 'sgr.servicegroup_sg_id', '=', 'sg.sg_id')
        ->where('sc.sc_name', $serviceCategorie)
        ->whereIn('h.host_name', $hosts)
            ->groupBy('host name', 'service description', 'host id', 'service id', 'service_template_id', 'service_template_description')
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
    /**
     * Get Timeperiods by service Id's (list)
     *
     * @param $serviceIds
     * @return array(service_id, tp_id, tp_name, tp_monday, tp_tuesday, tp_wednesday, tp_thursday, tp_friday, tp_saturday, tp_sunday)
     */
    public function getCentreonUniqueTimeperiodsByServiceIds($serviceIds)
    {
        $res = DB::connection('centreon')->table('service as s')
            ->select(DB::RAW('DISTINCT t.tp_id'),
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
            ->orderby('t.tp_name','asc')
        ;

        $uniqueTimeperiods = json_decode($res->get(), true);
        return $uniqueTimeperiods;

    }

}

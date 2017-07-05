<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollOptionDetail;


class PollOptionDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PollOptionDetail;
    }

    public function getOptionsOther($poll_option_id)
    {
        $pollOptionDetails = \DB::table('poll_option_details')->select('otro')->where('poll_option_details.poll_option_id', $poll_option_id)->groupBy('otro')->get();
        return $pollOptionDetails;
    }

    public function searchPollOptionDetail($pollOptionDetail,$tipo="0")
    {
        if ($tipo=="0"){
            $result_poll_detail = PollOptionDetail::where('poll_option_id', $pollOptionDetail->poll_option_id)->where('store_id',$pollOptionDetail->store_id)->where('company_id',$pollOptionDetail->company_id)->where('product_id',$pollOptionDetail->product_id)->where('publicity_id',$pollOptionDetail->publicity_id)->first();
        }
        if ($tipo=="1"){
            $result_poll_detail = PollOptionDetail::where('poll_option_id', $pollOptionDetail->poll_option_id)->where('store_id',$pollOptionDetail->store_id)->where('company_id',$pollOptionDetail->company_id)->where('product_id',$pollOptionDetail->product_id)->where('visit_id',$pollOptionDetail->visit_id)->first();
        }

        return $result_poll_detail;
    }

    public function getPollOptionDetail($store_id,$poll_option_id,$company_id,$product_id,$publicity_id)
    {
        $result_poll_option_detail = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('store_id',$store_id)->where('company_id',$company_id)->where('product_id',$product_id)->where('publicity_id',$publicity_id)->get();
        return $result_poll_option_detail;
    }

    public function getResponseOptionPublicity($store_id,$poll_id,$publicity_id,$company_id)
    {
        //$pollOptionDetail = \DB::table('poll_option_details')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->select('poll_options.id','poll_options.options','poll_option_details.created_at','poll_option_details.updated_at')->where('poll_options.poll_id', $poll_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.publicity_id', $publicity_id)->where('poll_option_details.store_id', $store_id)->get();
        $pollOptionDetail = \DB::table('poll_option_details')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->select('poll_options.id','poll_options.options','poll_option_details.id as poll_option_details_id','poll_option_details.product_id','poll_option_details.priority','poll_option_details.otro as coment_otro','poll_option_details.created_at','poll_option_details.updated_at')->where('poll_options.poll_id', $poll_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.publicity_id', $publicity_id)->where('poll_option_details.store_id', $store_id)->get();
        return $pollOptionDetail;
    }

    public function getTotalOptionOther($poll_option_id,$other,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        if (is_numeric($city)) {
            if ($city == 1) {
                $ciudadB = "Lima";
            }
            if ($city == 2) {
                $ciudadB = "Arequipa";
            }
            if ($city == 3) {
                $ciudadB = "Ica";
            }
            if ($city == 4) {
                $ciudadB = "Trujillo";
            }
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case $city == "0":
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('otro', $other)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                break;
            case ($city<>"0") and ($district<>"0") and ($ejecutivo<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($city <> "0" and $district <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->count();
                break;
            case ($city<>"0") and ($rubro<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case ($city <> "0" and $rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                }

                break;
            case ($city <> "0" and $ejecutivo <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->count();
                    }
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->count();
                }

                break;
        }
        return $totalOptions;
    }

    public function getTotalPriority($company_id,$priority,$poll_option_codigo,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0",$horizontal="0")
    {
        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }
        if (is_numeric($ubigeo)) {
            if ($ubigeo == 5) {
                $ciudadB = "Lima";
            }
        }
        if (is_numeric($city)) {

            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();

                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->count();

                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->count();
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->count();
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.ubigeo', $ubigeo)->count();
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.cadenaRuc', $cadena)->count();
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->count();
                break;
            default:
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_option_details.poll_option_id','=','poll_options.id')->where('stores.test', 0)->where('poll_option_details.product_id', $product_id)->where('poll_option_details.company_id', $company_id)->where('poll_option_details.priority', $priority)->where('poll_options.codigo', $poll_option_codigo)->count();
                break;
        }
        return $totalOptions;
    }

    public function getTotalOptionForAll($group_poll_id="0",$ejecutivo="0",$product_id="0",$cadena="0",$poll_id="0",$limit="0",$horizontal="0",$ubigeo="0")
    {
        if ($limit<>"0"){$valLimit=" limit ".$limit;}else{$valLimit="";}//dd($poll_id);
        switch (true) {

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax'  
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax'  
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                $condition ="";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                $condition ="";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";


                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";

                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax'  
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";

                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax'  
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;

            case ($ubigeo == "0") and (is_array($horizontal)):
                $condition ="";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                $condition ="";
                $condition .=" AND `stores`.`type` IN (";
                $c=0;
                foreach ($horizontal as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($horizontal) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                $condition ="";
                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                $condition ="";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                $condition ="";
                $condition .=" AND `stores`.`cadenaRuc` IN (";
                $c=0;
                foreach ($cadena as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($cadena) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";
                $condition .=" AND `stores`.`ubigeo` IN (";
                $c=0;
                foreach ($ubigeo as $cadena1)
                {
                    $condition .= "'".$cadena1."'";
                    $c=$c+1;
                    if (count($ubigeo) > $c)
                    {
                        $condition .=",";
                    }
                }
                $condition .=")";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            case ($ubigeo == "0") and ($cadena == "0") and ($horizontal == "0") and ($ejecutivo <> "0"):
                $condition ="";
                $condition .=" AND `stores`.`ejecutivo` = '".$ejecutivo."'";

                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.")";
                    $where = $where.$condition;
                    $where .=" AND 
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax'  
                group by `poll_options`.`options` order by nro desc".$valLimit;

                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."'";
                    $where = $where.$condition;
                    $where .= " AND 
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;
            default:
                if ($poll_id=="0"){
                    $where = " WHERE
                  `polls`.`id` in (".$group_poll_id.") AND
                  `poll_option_details`.`product_id` = '".$product_id."' and `poll_options`.`options`<>'Apronax' 
                group by `poll_options`.`options` order by nro desc".$valLimit;
                }else{
                    $where = " WHERE
                  `poll_options`.`options` ='".$group_poll_id."' AND
                  `poll_option_details`.`product_id` = '".$product_id."'  AND `polls`.`id` = '".$poll_id."'";
                }
                break;

        }//dd($where);
        $total1 ="SELECT
                  `poll_options`.`options`, count(*) as nro
                FROM
                  `poll_option_details`
                  INNER JOIN `stores` ON (`poll_option_details`.`store_id` = `stores`.`id`)
                  INNER JOIN `poll_options` ON (`poll_option_details`.`poll_option_id` = `poll_options`.`id`)
                  INNER JOIN `polls` ON (`poll_options`.`poll_id` = `polls`.`id`)".$where;//dd($total1);
        $consulta=\DB::select($total1);
        return $consulta;
    }

    public function getTotalOption($poll_option_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0",$horizontal = "0")
    {
        $toda = explode('Toda ',$city);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }
        if (is_numeric($ubigeo)) {
            if ($ubigeo == 5) {
                $ciudadB = "Lima";
            }
        }
        if (is_numeric($city)) {

            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }

        switch (true) {

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case ($city == "0") and ($cadena == "0") and ($ubigeo == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0") and ($horizontal == "0"):
                if ($product_id<>"0"){
                    $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('product_id', $product_id)->count();
                }else{
                    $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->count();
                }
                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.type', $horizontal)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->count();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_option_details.product_id', $product_id)->count();
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                break;



            case $store_id <> "0":
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('store_id', $store_id)->count();
                break;
            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0"):
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->count();
                break;
            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro<>"0"):
                $valor1 = \DB::table('poll_option_details')->where('poll_option_details.poll_option_id', $rubro)->get();
                $valor2 = \DB::table('poll_option_details')->where('poll_option_details.poll_option_id', $poll_option_id)->get();$cont=0;
                //if ($poll_option_id==526){dd($valor2);}
                foreach ($valor1 as $val1)
                {
                    foreach ($valor2 as $val2)
                    {
                        if ($val1->store_id == $val2->store_id){
                            $cont ++;break;
                        }
                    }
                }
                $totalOptions = $cont;
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }else{
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }
                }else{
                    $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                    $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                    $valor3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                }
                //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                //dd($valor1);
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $storesAcum[] = $val2->store_id;break;
                            }
                        }
                    }//dd($storesAcum);
                    $cont=0;
                    if (count($storesAcum)>0){
                        foreach ($storesAcum as $val1)
                        {
                            foreach ($valor3 as $val2)
                            {
                                if ($val1 == $val2->store_id){
                                    $cont ++;break;
                                }
                            }
                        }
                    }

                }else{
                    $cont=0;
                }

                $totalOptions = $cont;//dd($totalOptions);
                break;
            case ($district <> "0") and ($rubro<>"0"):
                $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $rubro)->get();
                $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $district)->get();
                $valor3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $storesAcum[] = $val2->store_id;break;
                            }
                        }
                    }//dd($storesAcum);
                    $cont=0;
                    foreach ($storesAcum as $val1)
                    {
                        foreach ($valor3 as $val2)
                        {
                            if ($val1 == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }else{
                    $cont=0;
                }

                $totalOptions = $cont;//dd($totalOptions);
                break;
            case ($city<>"0") and ($district<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }else{
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }
                }else{
                    $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                    $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                }
                $cont=0;
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }

                $totalOptions = $cont;
                break;
            case ($city <> "0" and $district <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }else{
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }
                }else{
                    $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->get();
                    $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                }
                $cont=0;
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }

                $totalOptions = $cont;
                break;
            case ($city == "0" and $district <> "0"):
                $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $district)->get();
                $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                $cont=0;
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }

                $totalOptions = $cont;
                break;
            case ($city<>"0") and ($rubro<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }else{
                        //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }
                }else{
                    //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                    $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                    $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                }
                $cont=0;
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }

                $totalOptions = $cont;
                break;
            case ($city <> "0" and $rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }else{//dd('v '.$city);
                        //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                    }

                }else{
                    //$totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    $valor1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->get();
                    $valor2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $poll_option_id)->get();
                }
                $cont=0;
                if ((count($valor1)>0) and (count($valor2)>0)){
                    foreach ($valor1 as $val1)
                    {
                        foreach ($valor2 as $val2)
                        {
                            if ($val1->store_id == $val2->store_id){
                                $cont ++;break;
                            }
                        }
                    }
                }

                $totalOptions = $cont;
                break;
            case ($city <> "0" and $ejecutivo <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->count();
                }

                break;
        }


        return $totalOptions;
    }

    public function getTotalOptionPublicity($publicity_id,$poll_option_id,$city="0",$dex="0",$tipoBodega="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opcionesSi = " AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }else{
                        $opcionesSi = " AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }
                }else{
                    $opcionesSi = " AND `stores`.`ubigeo` = '".$city."' AND `stores.distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $opcionesSi = " AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opcionesSi = "  AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }else{
                        $opcionesSi = " AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }
                }else{
                    $opcionesSi = " AND  `stores`.`ubigeo` = '".$city."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                $opcionesSi = " AND  `stores.tipo_bodega` = '".$tipoBodega."' ";
                break;
            case ($city <> "0") and ($dex <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opcionesSi = " AND  `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                    }else{
                        $opcionesSi = " AND  `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                    }
                }else{
                    $opcionesSi = " AND  `stores`.`ubigeo` = '".$city."' AND `stores`.`distributor` = '".$dex."' ";
                }
                break;
            case ($city <> "0") and ($dex == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opcionesSi = " AND  `stores`.`ubigeo` <> '".$ciudadB."' ";
                    }else{
                        $opcionesSi = " AND  `stores`.`ubigeo` = '".$ciudadB."' ";
                    }

                }else{
                    $opcionesSi = " AND  `stores`.`ubigeo` = '".$city."' ";
                }
                break;
            case ($city == "0" and $dex <> "0"):
                $opcionesSi = " AND  `stores`.`distributor` = '".$dex."' ";
                break;
            case ($city == "0") and ($dex == "0"):
                $opcionesSi = '';

                break;
        }
        $sql = "SELECT
  `poll_option_details`.`store_id`
FROM
  `stores`
  RIGHT OUTER JOIN `poll_option_details` ON (`stores`.`id` = `poll_option_details`.`store_id`)
WHERE
`poll_option_details`.`publicity_id` = '".$publicity_id."' AND
  `poll_option_details`.`poll_option_id` = '".$poll_option_id."' AND 
  `stores`.`test` = 0 ".$opcionesSi."
GROUP BY
  `poll_option_details`.`store_id`,
  `poll_option_details`.`publicity_id`,
  `poll_option_details`.`poll_option_id`";
        $consulta=\DB::select($sql);//dd($consulta);
        $total = count($consulta);

        return $total;
    }

    public function getDetailOption($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0,$product_id="0",$ubigeo="0",$cadena="0",$horizontal="0")
    {
        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }
        if (is_numeric($city)) {

            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('poll_option_details.product_id', $product_id)->orderBy('poll_option_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;


            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case ($city <> "0" and $district <> "0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.tipo_bodega','stores.distributor','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.tipo_bodega','stores.distributor','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.rubro', $rubro)->orderBy('poll_option_details.created_at', 'desc')->get();
                }

                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_option_details.created_at', 'desc')->get();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->where('stores.region', $city)->orderBy('poll_option_details.created_at', 'desc')->get();
                }

                break;
            default:
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.tipo_bodega','stores.distributor','stores.ubigeo','stores.region','stores.district','poll_option_details.otro AS comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_id)->where('stores.test', 0)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
        }
        return $detailResult;
    }

    public function getDetailOptionPublicity($poll_option_id,$publicity_id,$city="0",$dex="0",$tipoBodega="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($dex <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($city <> "0") and ($dex == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->orderBy('poll_option_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.ubigeo', $city)->orderBy('poll_option_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0" and $dex <> "0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->where('stores.distributor', $dex)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
            case ($city == "0") and ($dex == "0"):
                $detailResult = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_option_details.otro as comentario','poll_option_details.created_at')->where('poll_option_details.poll_option_id', $poll_option_id)->where('poll_option_details.publicity_id', $publicity_id)->where('stores.test', 0)->orderBy('poll_option_details.created_at', 'desc')->get();
                break;
        }//dd($detailResult);
        return $detailResult;
    }

    public function deleteOptions($store_id,$company_id,$product_id,$publicity_id)
    {
        $affectedRows = PollOptionDetail::where('store_id', $store_id)->where('company_id', $company_id)->where('product_id', $product_id)->where('publicity_id', $publicity_id)->delete();
        if ($affectedRows>0){
            return true;
        }else{
            return false;
        }
    }

} 
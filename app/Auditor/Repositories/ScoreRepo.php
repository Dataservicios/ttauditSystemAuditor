<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 30/12/2014
 * Time: 12:38 PM
 */

namespace Auditor\Repositories;

use Auditor\Entities\Score;

class ScoreRepo extends BaseRepo {

    public function getModel()
    {
        return new Score();
    }

    public function countWinnersBayerProducts($company_id,$audit_id="0",$ubigeo,$cadena,$ejecutivo="0",$horizontal="0")
    {
        if (is_numeric($ubigeo)) {
            if ($ubigeo == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($ubigeo == "0") and  ($cadena =="0") and ($ejecutivo <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case ($ubigeo == "0") and  (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('scores.audit_id', $audit_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case ($ubigeo == "0") and  (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.type', $horizontal)->whereIn('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($ubigeo)) and  (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($ubigeo)) and  (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case ($ubigeo == "0") and  (is_array($horizontal)) and (is_array($cadena)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case ($ubigeo == "0") and  ($cadena =="0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->count();
                }
                break;
            case ($ubigeo == "0") and  (is_array($cadena)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('scores.audit_id', $audit_id)->count();
                }
                break;
            case (is_array($ubigeo)) and  (is_array($cadena)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }

                break;
            case (is_array($ubigeo)) and  ($cadena == "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->count();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->whereIn('stores.type', $horizontal)->count();
                }
                break;
        }


        //dd($polls);
        return $polls;
    }

    public function getDetailWinners($company_id,$audit_id="0",$ubigeo="0",$cadena="0",$ejecutivo="0")
    {
        switch (true) {
            case ($ubigeo == "0") and (($cadena == "HORIZONTAL") or ($cadena == "CADENA")) and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.type', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.type', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo <> "0") and  (($cadena == "HORIZONTAL") or ($cadena == "CADENA")) and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.type', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.type', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo == "0") and  ($cadena =="0") and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo == "0") and  ($cadena <>"0") and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.cadenaRuc', $cadena)->where('scores.audit_id', $audit_id)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo <> "0") and  ($cadena <> "0") and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ubigeo', $ubigeo)->where('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo <> "0") and  ($cadena == "0") and ($ejecutivo<>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case ($ubigeo == "0") and  (($cadena == "HORIZONTAL") or ($cadena == "CADENA")):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.type', $cadena)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.type', $cadena)->get();
                }
                break;
            case ($ubigeo <> "0") and  (($cadena == "HORIZONTAL") or ($cadena == "CADENA")):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.type', $cadena)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.type', $cadena)->get();
                }
                break;
            case ($ubigeo == "0") and  ($cadena =="0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->get();
                }
                break;
            case ($ubigeo == "0") and  ($cadena <>"0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.cadenaRuc', $cadena)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.cadenaRuc', $cadena)->where('scores.audit_id', $audit_id)->get();
                }
                break;
            case ($ubigeo <> "0") and  ($cadena <> "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.cadenaRuc', $cadena)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ubigeo', $ubigeo)->where('stores.cadenaRuc', $cadena)->get();
                }
                break;
            case ($ubigeo <> "0") and  ($cadena == "0"):
                if ($audit_id=="0")
                {
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->get();
                }else{
                    $polls = Score::join('stores', 'scores.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','scores.created_at')->where('scores.company_id', $company_id)->where('stores.test', 0)->where('scores.audit_id', $audit_id)->where('stores.ubigeo', $ubigeo)->get();
                }
                break;
        }

        return $polls;

    }

} 
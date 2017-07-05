<?php
namespace Auditor\Repositories;

use Auditor\Entities\ControlTime;


class ControlTimeRepo extends BaseRepo{

    public function getModel()
    {
        return new ControlTime();
    }

    public function getRegForAuditorCompanyCity($auditor,$company_id,$city)
    {
        $registers = \DB::table('control_time')->join('stores','control_time.store_id','=','stores.id')->select('stores.id', 'stores.fullname','stores.latitude','stores.longitude','control_time.lat_close','control_time.long_close','control_time.lat_open','control_time.long_open','control_time.time_open','control_time.time_close','control_time.user_id','control_time.created_at','control_time.updated_at')->where('control_time.user_id', $auditor)->where('control_time.company_id', $company_id)->where('stores.ubigeo', $city)->get();
        return $registers;
    }

    public function getRecOnTheLastAuditDay($auditor,$date,$id="0")
    {
        if ($id=="0")
        {
            $registers = \DB::table('control_time')->join('stores','control_time.store_id','=','stores.id')->select('control_time.id','stores.id as store_id', 'stores.fullname','stores.latitude','stores.longitude','control_time.lat_close','control_time.long_close','control_time.lat_open','control_time.long_open','control_time.time_open','control_time.time_close','control_time.user_id','control_time.created_at','control_time.updated_at')->where('control_time.user_id', $auditor)->where('control_time.created_at','>=', $date)->get();
        }else{
            $registers = \DB::table('control_time')->join('stores','control_time.store_id','=','stores.id')->select('control_time.id','stores.id as store_id', 'stores.fullname','stores.latitude','stores.longitude','control_time.lat_close','control_time.long_close','control_time.lat_open','control_time.long_open','control_time.time_open','control_time.time_close','control_time.user_id','control_time.created_at','control_time.updated_at')->where('control_time.user_id', $auditor)->where('control_time.created_at','>=', $date)->where('control_time.id','>', $id)->get();
        }

        return $registers;
    }
    
} 
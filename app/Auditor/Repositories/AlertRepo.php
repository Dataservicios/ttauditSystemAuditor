<?php
namespace Auditor\Repositories;

use Auditor\Entities\Alert;


class AlertRepo extends BaseRepo{

    public function getModel()
    {
        return new Alert;
    }

    public function getLatestAlerts($number,$customer_id="0")
    {
        $typeUser=\Auth::user()->type;
        $user_id=\Auth::user()->id;
        if (($typeUser=='admin') or ($typeUser=='company')){
            if ($customer_id=="0"){
                return Alert::orderBy('created_at', 'desc')->take($number)->get();
            }else{
                return Alert::where('customer_id',$customer_id)->orderBy('created_at', 'desc')->take($number)->get();
            }
        }
        if ($typeUser=='executive'){
            if ($customer_id=="0"){
                return Alert::where('ejecutivo_id',$user_id)->orderBy('created_at', 'desc')->take($number)->get();
            }else{
                return Alert::where('ejecutivo_id',$user_id)->where('customer_id',$customer_id)->orderBy('created_at', 'desc')->take($number)->get();
            }
        }

    }

    public function getCampaigneWithAlerts($customer_id){
        return Alert::join('companies', 'companies.id', '=', 'alerts.company_id')->where('alerts.customer_id', $customer_id)->groupBy('alerts.company_id')->orderBy('companies.fullname','ASC')->get();
    }

    public function getEjecutiveForCampaigne($company_id){
        
    }

} 
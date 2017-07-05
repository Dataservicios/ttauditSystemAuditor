<?php
namespace Auditor\Repositories;

use Auditor\Entities\Road;


class RoadRepo extends BaseRepo{

    public function getModel()
    {
        return new Road;
    }

    public function listRoads($company_id='0',$user_id='0')
    {
        switch (true) {
            case ($company_id == "0") and ($user_id == "0"):
                //dd("ffeo");
                $companies = Road::orderBy('created_at','DESC')->get();
                //dd($companies);
                break;
            case ($company_id == "0") and ($user_id <> "0"):
                //dd("ffeo");
                $companies = Road::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
                //dd($companies);
                break;
            case ($company_id <> "0") and ($user_id <> "0"):
                $companies = Road::where('company_id',$company_id)->where('user_id',$user_id)->orderBy('created_at','DESC')->get();
                break;
            case ($company_id <> "0") :
                $companies = Road::where('company_id',$company_id)->orderBy('created_at','DESC')->get();
                break;
            case ($user_id <> "0") :
                $companies = Road::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
                break;
        }

        return $companies;
    }

} 
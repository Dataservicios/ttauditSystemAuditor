<?php
namespace Auditor\Repositories;

use Auditor\Entities\Visit;


class VisitRepo extends BaseRepo{

    public function getModel()
    {
        return new Visit();
    }

    public function getAll($company_id){
       return Visit::where('company_id', $company_id)->get();
    }

    public function getVisitIdForOrder($order){
        return Visit::where('order')->get();
    }



} 
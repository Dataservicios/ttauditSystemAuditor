<?php
namespace Auditor\Repositories;

use Auditor\Entities\AuditRoadStore;


class AuditRoadStoreRepo extends BaseRepo{

    public function getModel()
    {
        return new AuditRoadStore;
    }


    /**
     * @description Obtiene las rutas por compañia
     * @param $company_id
     * @return mixed
     */
    public function getRoadsForCompany($company_id)
    {
        $roadsForCompany = AuditRoadStore::where('company_id', $company_id)->groupBy('road_id')->get();
        //dd($roadsForCompany);
        return $roadsForCompany;
    }



} 
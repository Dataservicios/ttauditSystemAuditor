<?php
namespace Auditor\Repositories;

use Auditor\Entities\VisitStore;


class VisitStoreRepo extends BaseRepo{

    public function getModel()
    {
        return new VisitStore();
    }

    public function updateRoutingForVisit($store_id,$company_id,$visit_id,$valor){
        $affectedRows = VisitStore::where('store_id', $store_id)->where('company_id', $company_id)->where('visit_id', $visit_id)->update(array('ruteado' => $valor));

        return true;
    }



} 
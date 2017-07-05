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
     * @param $company_id, $test
     * @return mixed
     */
    public function getRoadsForCompany($company_id,$test=0)
    {
        $roadsForCompany = AuditRoadStore::join('roads','audit_road_stores.road_id','=','roads.id')->where('audit_road_stores.company_id', $company_id)->where('roads.test', $test)->groupBy('audit_road_stores.road_id')->get();
        //dd($roadsForCompany);
        return $roadsForCompany;
    }


    /**
     * @description Elimina auditorias en base al agente
     * @param $store_id
     * @return boolean
     */
    public function deleteForStore($store_id,$company_id,$road_id)
    {
        \DB::table('audit_road_stores')->where('store_id', $store_id)->where('company_id', $company_id)->where('road_id', $road_id)->delete();
        //dd($roadsForCompany);
        return true;
    }

    /**
     * @description Insertar agente en ruta
     * @param $store_id, route_id, $audits
     * @return boolean
     */
    public function insertAuditsStore($store_id, $route_id, $company_id, $audits)
    {
        foreach ($audits as $audit) {
            $objeto = new AuditRoadStore;
            $objeto->company_id = $company_id;
            $objeto->road_id = $route_id;
            $objeto->audit_id = $audit->id;
            $objeto->store_id = $store_id;
            $objeto->save();
            /*\DB::table('audit_road_stores')->insert(
                array('company_id' => $company_id, 'road_id' => $route_id, 'audit_id' => $audit->id, 'store_id' => $store_id, 'created_at' => now(), 'updated_at' => now() )
            );*/
        }
        return true;
    }

} 
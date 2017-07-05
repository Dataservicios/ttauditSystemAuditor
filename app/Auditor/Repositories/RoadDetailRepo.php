<?php
namespace Auditor\Repositories;

use Auditor\Entities\RoadDetail;


class RoadDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new RoadDetail;
    }

    public function getDetailStores($road_id)
    {
        $roadDetails = RoadDetail::where('road_id', $road_id)->orderBy('created_at', 'DESC')->get();
        //dd($roadDetails);
        return $roadDetails;
    }

    public function getRoadForStoreCompany($store_id,$company_id)
    {
        $roadDetails = RoadDetail::where('company_id', $company_id)->where('store_id', $store_id)->get();
        //dd($roadDetails);
        return $roadDetails;
    }

    /**
     * @param $matrizRoads
     * @param $type 0 -> todos, 1-> auditados, 2-> sin auditar
     * @return mixed
     */
    public function getQuantityStoresAudits($matrizRoads, $type,$ciudad="0", $distrito="0",$ejecutivo="0",$rubro="0")
    {
        $c=0;
        $sql = "select  ";//dd($matrizRoads[0]);
        foreach ($matrizRoads as $road){
            $c = $c+1;
            if ($c==1){
                $sql .= "(sum(case when r.road_id = '" . $road->road_id . "' then 1 else 0 end) ";
            }else{
                $sql .= " + sum(case when r.road_id = '" . $road->road_id . "' then 1 else 0 end ) ";
            }
        }
        $toda = explode('Toda ',$ciudad);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $ciudad = 1;
        }
        if (is_numeric($ciudad)) {

            if ($ciudad == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true){
            case $ciudad=="0":
                if ($type==0){
                    $sql .=") total FROM road_details r";
                }
                if ($type==1){
                    $sql .=") total FROM road_details r where r.audit=1";
                }
                if ($type==2){
                    $sql .=") total FROM road_details r where r.audit=0";
                }
                break;
            case ($ciudad<>"0") and ($distrito<>"0") and ($ejecutivo<>"0") and ($rubro<>"0"):
                if ($type==0){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.district='".$distrito."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."'";
                }
                if ($type==1){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and  r.audit=1";
                }
                if ($type==2){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and r.audit=0";
                }
                break;
            case ($ciudad<>"0") and ($distrito<>"0") and ($ejecutivo<>"0"):
                if ($type==0){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.district='".$distrito."' and s.ejecutivo='".$ejecutivo."'";
                }
                if ($type==1){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and s.ejecutivo='".$ejecutivo."' and  r.audit=1";
                }
                if ($type==2){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and s.ejecutivo='".$ejecutivo."' and r.audit=0";
                }
                break;
            case ($ciudad<>"0" and $distrito<>"0"):
                if ($type==0){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."'";
                }
                if ($type==1){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and  r.audit=1";
                }
                if ($type==2){
                    $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and district='".$distrito."' and r.audit=0";
                }
                break;
            case ($ciudad<>"0") and ($ejecutivo<>"0") and ($rubro<>"0"):
                if (is_numeric($ciudad)){

                    if ($ciudad==5){
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and r.audit=0";
                        }
                    }else{
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and r.audit=0";
                        }
                    }

                }else{
                    if ($type==0){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."'";
                    }
                    if ($type==1){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and  r.audit=1";
                    }
                    if ($type==2){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."' and s.rubro='".$rubro."' and r.audit=0";
                    }
                }

                break;
            case ($ciudad<>"0") and ($rubro<>"0"):
                if (is_numeric($ciudad)){

                    if ($ciudad==5){
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.rubro='".$rubro."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.rubro='".$rubro."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.rubro='".$rubro."' and r.audit=0";
                        }
                    }else{
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.rubro='".$rubro."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.rubro='".$rubro."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.rubro='".$rubro."' and r.audit=0";
                        }
                    }

                }else{
                    if ($type==0){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.rubro='".$rubro."'";
                    }
                    if ($type==1){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.rubro='".$rubro."' and  r.audit=1";
                    }
                    if ($type==2){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.rubro='".$rubro."' and r.audit=0";
                    }
                }

                break;
            case ($ciudad<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($ciudad)){

                    if ($ciudad==5){
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and r.audit=0";
                        }
                    }else{
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and  r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and s.ejecutivo='".$ejecutivo."' and r.audit=0";
                        }
                    }

                }else{
                    if ($type==0){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."'";
                    }
                    if ($type==1){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."' and  r.audit=1";
                    }
                    if ($type==2){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and s.ejecutivo='".$ejecutivo."' and r.audit=0";
                    }
                }

                break;
            case $ciudad<>"0":
                if (is_numeric($ciudad)){

                    if ($ciudad==5){
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo<>'".$ciudadB."' and r.audit=0";
                        }
                    }else{
                        if ($type==0){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."'";
                        }
                        if ($type==1){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and r.audit=1";
                        }
                        if ($type==2){
                            $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.ubigeo='".$ciudadB."' and r.audit=0";
                        }
                    }


                }else{
                    if ($type==0){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."'";
                    }
                    if ($type==1){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and r.audit=1";
                    }
                    if ($type==2){
                        $sql .=") total FROM road_details r,stores s where r.store_id=s.id and s.region='".$ciudad."' and r.audit=0";
                    }
                }

                break;
        }

        //print_r($sql);
        $storesAudits =  \DB::select($sql);
        /*if ($type==0){
            echo $sql;
        }*/

        return $storesAudits[0]->total;

    }

    /**
     * @description Elimina agente del detalle de una ruta
     * @param $store_id
     * @return boolean
     */
    public function deleteForStore($store_id,$company_id)
    {
        \DB::table('road_details')->where('store_id', $store_id)->where('company_id', $company_id)->delete();
        //dd($roadsForCompany);
        return true;
    }

    /**
     * @description cuenta cuantos registros hay de una tienda en una ruta
     * @param $store_id
     * @return boolean
     */
    public function existAgentInRoute($road_id,$agent_id,$company_id)
    {
        $roadDetails = RoadDetail::where('store_id', $agent_id)->where('road_id', $road_id)->where('company_id', $company_id)->count();
        //dd($polls);
        if ($roadDetails>0){

            return true;
        }else{

            return false;
        }

    }

    /**
     * @description Ingresar Agente en ruta
     * @param $store_id
     * @return boolean
     */
    public function insertStoreInRoute($store_id, $route_id,$company_id)
    {
        $objeto = new RoadDetail;
        $objeto->store_id = $store_id;
        $objeto->road_id = $route_id;
        $objeto->company_id= $company_id;
        $objeto->save();
        /*\DB::table('road_details')->insert(
            array('store_id' => $store_id, 'road_id' => $route_id, 'created_at' => now(), 'updated_at' => now())
        );*/
        return true;
    }

    public function roadsDetail($company_id,$user_id)
    {
        $sql = "SELECT
  `roads_resume`.`road_id`,
  `roads_resume`.`store_id` AS `id`,
  `roads_resume`.`cadenaRuc`,
  CASE
	when `roads_resume`.`cadenaRuc` is null or `roads_resume`.`cadenaRuc` = ''  then `roads_resume`.`DNI` else `roads_resume`.`cadenaRuc` end documento,
  CASE
	when `roads_resume`.`cadenaRuc` is null or `roads_resume`.`cadenaRuc` = '' then 'DNI' else 'RUC' end  tipo_documento,
  `roads_resume`.`fullname`,
  `roads_resume`.`region`,
  `roads_resume`.`tipo_bodega`,
  `roads_resume`.`address`,
  `roads_resume`.`district`,
  `roads_resume`.`audit` AS `status`,
  `roads_resume`.`codclient`,
  `roads_resume`.`urbanization`,
  `roads_resume`.`type`,
  `roads_resume`.`ejecutivo`,
  `roads_resume`.`latitude`,
  `roads_resume`.`longitude`,
  `roads_resume`.`telephone`,
  `roads_resume`.`cell`,
  `roads_resume`.`comment`,
  `roads_resume`.`owner`,
  `roads_resume`.`fnac`,
  `visit_stores`.`visit_id`,
`visit_stores`.`ruteado`
FROM roads_resume
  INNER JOIN `stores` ON (`roads_resume`.`store_id` = `stores`.`id`)
  INNER JOIN `visit_stores` ON (`stores`.`id` = `visit_stores`.`store_id`)
where `roads_resume`.`company_id`='".$company_id."' and `roads_resume`.`user_id`='".$user_id."' and  `roads_resume`.`nivel` = 1 and `visit_stores`.`ruteado`=0 and `roads_resume`.`audit`=0";

        $consulta=\DB::select($sql);
        return  $consulta;
    }

} 
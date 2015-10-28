<?php
namespace Auditor\Repositories;

use Auditor\Entities\RoadDetail;


class RoadDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new RoadDetail;
    }

    /**
     * @param $matrizRoads
     * @param $type 0 -> todos, 1-> auditados, 2-> sin auditar
     * @return mixed
     */
    public function getQuantityStoresAudits($matrizRoads, $type,$ciudad="0", $distrito="0",$ejecutivo="0",$rubro="0")
    {
        $c=0;
        $sql = "select  ";
        foreach ($matrizRoads as $road){
            $c = $c+1;
            if ($c==1){
                $sql .= "(sum(case when r.road_id = '" . $road->road_id . "' then 1 else 0 end) ";
            }else{
                $sql .= " + sum(case when r.road_id = '" . $road->road_id . "' then 1 else 0 end ) ";
            }
        }
        if (is_numeric($ciudad)) {
            if ($ciudad == 1) {
                $ciudadB = "Lima";
            }
            if ($ciudad == 2) {
                $ciudadB = "Arequipa";
            }
            if ($ciudad == 3) {
                $ciudadB = "Ica";
            }
            if ($ciudad == 4) {
                $ciudadB = "Trujillo";
            }
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

        //dd($sql);
        $storesAudits =  \DB::select($sql);
        /*if ($type==0){
            echo $sql;
        }*/

        return $storesAudits[0]->total;

    }

} 
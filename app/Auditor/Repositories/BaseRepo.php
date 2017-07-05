<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 14/12/2014
 * Time: 08:31 PM
 */

namespace Auditor\Repositories;


abstract class BaseRepo {

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract public function getModel();

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function allReg()
    {
        return $this->model->all();
    }


    public function getRoadsResumeForCompany($company_id)
    {
        $sql = "SELECT
`roads_resume`.`road_id` as id,
`roads_resume`.`road` as fullname,
  COUNT(`roads_resume`.`road_id`) AS `pdvs`,
  SUM(`roads_resume`.`audit`) AS `auditados`,
`roads_resume`.`auditor`,
`roads_resume`.`ubigeo` as departamento,
`roads_resume`.`created_at` as creado
FROM
  `roads_resume`
WHERE
  `roads_resume`.`company_id` = '".$company_id."'
GROUP BY
  `roads_resume`.`road_id`,
  `roads_resume`.`user_id`,
  `roads_resume`.`road`,
  `roads_resume`.`auditor`,
  `roads_resume`.`company_id`
ORDER BY
`roads_resume`.`created_at` DESC";

        $consulta=\DB::select($sql);
        return  $consulta;
    }

    public function getStoresRoadsRouting($company_id,$count="1",$test=0,$city="0", $district="0",$ejecutivo="0",$rubro="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$horizontal = "0")
    {//$company_id,$count="1",$test=0,$city="0", $district="0",$ejecutivo="0",$rubro="0",$ubigeo="0",$cadena="0"

        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }//dd($city);
        if (is_numeric($ubigeo)) {
            if ($ubigeo == 5) {
                $ciudadB = "Lima";
            }
        }
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true){
            case ($ubigeo <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                }
                break;
            case ($ubigeo <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->get();
                }
                break;
            case ($ubigeo <> "0") and ($dex <> "0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($ubigeo == "0" and $dex <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->get();
                }
                break;

            case ($ubigeo <> "0") and (!is_array($ubigeo)):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->get();
                    }
                }
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->get();
                }

                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->get();
                }

                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;

            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->get();
                }

                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->get();
                }
                break;


            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->get();
                }
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0")://solo da cantidad
                if (is_numeric($city)){
                    if ($city == 5) {
                        $subSql = "`s`.`ubigeo`<>'".$ciudadB."' AND";
                    }else{
                        $subSql = "`s`.`ubigeo`='".$ciudadB."' AND";
                    }
                }else{
                    $subSql = "`s`.`region`='".$city."' AND";
                }
                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."'  AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalSi=0;
                if (count($consulta)==0){
                    $totalSi=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalSi = $totalSi +1;
                        }
                    }
                }

                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."'  AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalNo=0;
                if (count($consulta)==0){
                    $totalNo=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalNo = $totalNo +1;
                        }
                    }
                }
                break;
            case ($district <> "0") and ($rubro<>"0"):
                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalSi=0;
                if (count($consulta)==0){
                    $totalSi=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalSi = $totalSi +1;
                        }
                    }
                }

                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalNo=0;
                if (count($consulta)==0){
                    $totalNo=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalNo = $totalNo +1;
                        }
                    }
                }
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0" and $district <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }

                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }
                break;
            case (($city == "0") and ($rubro <> "0")):
                if ($count==1){
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->count();
                }else{
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->get();
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->get();
                    }
                }
                break;
            case (($city == "0") and ($ejecutivo <> "0")):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->get();
                    }
                }
                break;

        }


        return $registros;

    }

    public function getStoresAuditRoadsRouting($company_id,$count="1",$test=0,$city="0", $district="0",$ejecutivo="0",$rubro="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$horizontal="0")
    {
        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }//dd($city);
        if (is_numeric($ubigeo)) {
            if ($ubigeo == 5) {
                $ciudadB = "Lima";
            }
        }
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true){
            case ($ubigeo <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                }
                break;
            case ($ubigeo <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->get();
                }
                break;
            case ($ubigeo <> "0") and ($dex <> "0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($ubigeo == "0" and $dex <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.distributor', $dex)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.distributor', $dex)->get();
                }
                break;

            case ($ubigeo <> "0") and (!is_array($ubigeo)):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->get();
                    }
                }
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->get();
                }

                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->whereIn('stores.type', $horizontal)->get();
                }

                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;


            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->get();
                }
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->get();
                }

                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->get();
                }
                break;



            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0"):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->get();
                }
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0")://solo da cantidad
                if (is_numeric($city)){
                    if ($city == 5) {
                        $subSql = "`s`.`ubigeo`<>'".$ciudadB."' AND";
                    }else{
                        $subSql = "`s`.`ubigeo`='".$ciudadB."' AND";
                    }
                }else{
                    $subSql = "`s`.`region`='".$city."' AND";
                }
                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."'  AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalSi=0;
                if (count($consulta)==0){
                    $totalSi=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalSi = $totalSi +1;
                        }
                    }
                }

                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."'  AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalNo=0;
                if (count($consulta)==0){
                    $totalNo=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalNo = $totalNo +1;
                        }
                    }
                }
                break;
            case ($district <> "0") and ($rubro<>"0"):
                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalSi=0;
                if (count($consulta)==0){
                    $totalSi=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalSi = $totalSi +1;
                        }
                    }
                }

                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `roads_resume` ON (`s`.`id` = `roads_resume`.`store_id`)
WHERE
  `roads_resume`.`company_id` = '".$company_id."' AND `roads_resume`.`audit` =1 AND 
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total1);
                $totalNo=0;
                if (count($consulta)==0){
                    $totalNo=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $totalNo = $totalNo +1;
                        }
                    }
                }
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0" and $district <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }

                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }
                break;
            case (($city == "0") and ($rubro <> "0")):
                if ($count==1){
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->count();
                }else{
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('roads_resume','stores.id','=','roads_resume.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->get();
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->get();
                    }
                }
                break;
            case (($city == "0") and ($ejecutivo <> "0")):
                if ($count==1){
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->count();
                    }else{
                        $registros = \DB::table('roads_resume')->join('stores','roads_resume.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('roads_resume.company_id', $company_id)->where('roads_resume.audit', 1)->where('stores.test', $test)->where('stores.region', $city)->get();
                    }
                }
                break;

        }


        return $registros;
    }
} 
<?php
namespace Auditor\Repositories;

use Auditor\Entities\Publicity;


class PublicityRepo extends BaseRepo{

    public function getModel()
    {
        return new Publicity;
    }

    public function getPublicityForCatMat($category_product_id,$campaigne_id)
    {
        $valores = Publicity::where('category_product_id', $category_product_id)->where('company_id',$campaigne_id)->get();
        return $valores;
    }

    public function getPublicityAlicorp($ubigeo,$auditor_id,$publicity_id,$company_id)
    {
        
        $sql1="call sp_reporte_company_".$company_id."('".$ubigeo."','".$auditor_id."','".$publicity_id."')";
        $consulta1 = \DB::select($sql1);//dd($consulta1);
        return $consulta1;
    }

    public function getTotalPublicity($company_id,$publicity_id="0")
    {
        if ($publicity_id=="0")
        {
            if ($company_id==3){
                $sql1="SELECT count(*) as cantidad FROM respuestas_publicities_company_3";
            }
            if ($company_id==18){
                $sql1="SELECT count(*) as cantidad FROM respuestas_publicities_company_18";
            }
            if ($company_id==15){
                $sql1="SELECT count(*) as cantidad FROM respuestas_publicities_company_15";
            }
            if ($company_id==21){
                $sql1="SELECT count(*) as cantidad FROM respuestas_publicities_company_21";
            }
            if ($company_id==22){
                $sql1="SELECT count(*) as cantidad FROM respuestas_publicities_company_22";
            }
        }

        $consulta1 = \DB::select($sql1);
        return $consulta1;
    }

} 
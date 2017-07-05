<?php
namespace Auditor\Repositories;
use Auditor\Entities\CategoryProduct;
use Auditor\Entities\CompanyStore;


class CompanyStoreRepo extends BaseRepo{

    public function getModel()
    {
        return new CompanyStore;
    }

    public function updateRouteForStore($store_id,$company_id,$valor)
    {
        $affectedRows = CompanyStore::where('store_id', '=', $store_id)->where('company_id', '=', $company_id)->update(array('ruteado' => $valor));
        /*$store = \DB::table('stores')
            ->where('id', $store_id)
            ->update(array('ruteado' => $valor));*/
        return true;
    }

    public function existStoreForCampaigne($store_id,$company_id)
    {
        $nro_reg = CompanyStore::where('store_id',$store_id)->where('company_id',$company_id)->count();
        if ($nro_reg>0) return true; else return false;
    }

    public function getQuantityStoresForCompany($company_id,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }
        if (is_numeric($city)) {

            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case $city == "0":
                $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($city <> "0" and $district <> "0"):
                $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->count();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    }else{
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                }


                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }else{
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                }


                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }


                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $total = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region', $city)->count();
                }
                break;
        }
        /*$sql = "SELECT COUNT(company_stores.id) AS regs FROM company_stores INNER JOIN stores ON (company_stores.store_id = stores.id) WHERE company_stores.company_id ='" . $company_id . "'";
        $registros =  \DB::select($sql);*/
        //dd($total);
        return $total;
    }

    public function getStoresForCompany($company_id, $order=0)
    {
        if ($order==0)
        {
            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.codclient', 'stores.fullname')->where('company_stores.company_id', $company_id)->orderBy('stores.codclient', 'desc')->get();
        }

        if ($order==1)
        {
            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.codclient', 'stores.fullname')->where('company_stores.company_id', $company_id)->orderBy('company_stores.created_at', 'desc')->take(50)->get();
        }
        return $registros;
    }

    public function getCountPresenceForCampaigne($company_id)
    {
        $sql = "SELECT Count(*) AS Num_Reg
FROM (SELECT
  presence_details.store_id
FROM
  company_stores
  INNER JOIN presence_details ON (company_stores.store_id = presence_details.store_id)
WHERE
  company_stores.company_id = '".$company_id."'
GROUP BY
  presence_details.store_id) AS ListaReg";
        return  \DB::select($sql);
    }

    public function getCountPublicityForCampaigne($company_id)
    {
        $sql = "SELECT Count(*) AS Num_Reg
FROM (SELECT
  publicity_details.store_id
FROM
  company_stores
  INNER JOIN publicity_details ON (company_stores.store_id = publicity_details.store_id)
WHERE
  company_stores.company_id = '".$company_id."'
GROUP BY
  publicity_details.store_id) AS ListaReg";
        //$total = \DB::table('company_stores')->join('publicity_details','company_stores.store_id','=','publicity_details.store_id')->where('company_stores.company_id', $company_id)->groupBy('publicity_details.store_id')->count();
        return  \DB::select($sql);
    }

    public function getPresenceForCampaigne($company_id, $nro_reg=50)
    {

        if ($nro_reg == "0"){
            $limit = "";
        }else{
            $limit = "LIMIT 0,".$nro_reg;
        }
        $sql = "SELECT
  stores.id,
  stores.fullname,
  COUNT(presence_details.presence_id) AS num_prod,
  presence_details.created_at,
  presence_details.updated_at
FROM
  presence_details
  INNER JOIN stores ON (presence_details.store_id = stores.id)
  INNER JOIN company_stores ON (presence_details.store_id = company_stores.store_id)
WHERE
  company_stores.company_id = '".$company_id."' AND
  stores.test = 0
GROUP BY
  presence_details.store_id
ORDER BY
  presence_details.created_at DESC ".$limit;
        return  \DB::select($sql);
    }

    public function getPublicityForCampaigne($company_id, $nro_reg=50)
    {
        if ($nro_reg == "0"){
            $limit = "";
        }else{
            $limit = "LIMIT 0,".$nro_reg;
        }
        $sql = "SELECT
  stores.id,
  stores.fullname,
  publicity_details.created_at,
  publicity_details.updated_at,
  COUNT(publicity_details.publicity_id) AS Nro_Publi,
(SELECT
  COUNT(publicity_details.layout) AS Layout_Ok
FROM
  company_stores
  INNER JOIN publicity_details ON (company_stores.store_id = publicity_details.store_id)
WHERE
  publicity_details.layout = 1 and comp.store_id=company_stores.store_id
GROUP BY
  company_stores.id) as Nro_layout_ok,
(SELECT
  COUNT(publicity_details.visible) AS visible_Ok
FROM
  company_stores
  INNER JOIN publicity_details ON (company_stores.store_id = publicity_details.store_id)
WHERE
  publicity_details.visible = 1 and comp.store_id=company_stores.store_id
GROUP BY
  company_stores.id) as Nro_visible_ok,
(SELECT
  COUNT(publicity_details.contaminated) AS contaminado_Ok
FROM
  company_stores
  INNER JOIN publicity_details ON (company_stores.store_id = publicity_details.store_id)
WHERE
  publicity_details.contaminated = 1 and comp.store_id=company_stores.store_id
GROUP BY
  company_stores.id) as Nro_contaminado_ok
FROM
  company_stores as comp
  INNER JOIN publicity_details ON (comp.store_id = publicity_details.store_id)
  INNER JOIN stores ON (publicity_details.store_id = stores.id)
WHERE
  comp.company_id = '".$company_id."'
GROUP BY
  publicity_details.store_id
ORDER BY
  publicity_details.created_at DESC ".$limit;
        return  \DB::select($sql);
    }

    public function getStoresPollForCampaigneForAudit($company_id, $audit_id,$nro_reg=50)
    {
        if ($nro_reg == "0"){
            $limit = "";
        }else{
            $limit = "LIMIT 0,".$nro_reg;
        }
        $sql = "SELECT
  stores.id,
  stores.codclient,
  stores.fullname,
  stores.cadenaRuc,
  stores.type,
  poll_details.created_at,
  poll_details.updated_at,
  poll_details.store_id
FROM
  polls
  INNER JOIN company_audits ON (polls.company_audit_id = company_audits.id)
  INNER JOIN poll_details ON (polls.id = poll_details.poll_id)
  INNER JOIN stores ON (poll_details.store_id = stores.id)
WHERE
  company_audits.company_id = '".$company_id."' AND
  company_audits.audit_id = '".$audit_id."' AND
  stores.test = 0
GROUP BY
  poll_details.store_id
ORDER BY
  poll_details.created_at DESC ".$limit;
        return  \DB::select($sql);
    }


    public function getStoresForCampaigne($company_id,$count="1",$test=0,$city="0", $district="0",$ejecutivo="0",$rubro="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$horizontal = "0")
    {//$poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0"
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
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->get();
                }
                break;
            case ($ubigeo <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->get();
                    }
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.tipo_bodega', $tipoBodega)->get();
                }
                break;
            case ($ubigeo <> "0") and ($dex <> "0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->get();
                    }
                }
                break;

            case ($ubigeo == "0" and $dex <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.distributor', $dex)->get();
                }
                break;

            case ($ubigeo <> "0") and (!is_array($ubigeo)):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ubigeo)->get();
                    }
                }
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->get();
                }

                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->get();
                }

                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->get();
                }

                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.type', $horizontal)->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->get();
                }

                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.cadenaRuc', $cadena)->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->get();
                }
                break;


            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0"):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->get();
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
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."'  AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
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
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
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
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
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
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
  `s`.`test` = '".$test."' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `company_stores` ON (`s`.`id` = `company_stores`.`store_id`)
WHERE
  `company_stores`.`company_id` = '".$company_id."' AND
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
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0" and $district <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->get();
                        }
                    }
                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->get();
                    }
                }
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }

                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }else{
                            $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }else{
                        $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->get();
                    }
                }
                break;
            case (($city == "0") and ($rubro <> "0")):
                if ($count==1){
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->count();
                }else{
                    $registros = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('company_stores','stores.id','=','company_stores.store_id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('poll_option_details.poll_option_id', $rubro)->get();
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->get();
                    }
                }
                break;
            case (($city == "0") and ($ejecutivo <> "0")):
                if ($count==1){
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ejecutivo', $ejecutivo)->get();
                }
                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($count==1){
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($count==1){
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->count();
                        }else{
                            $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }

                }else{
                    if ($count==1){
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->count();
                    }else{
                        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc', 'stores.fullname', 'stores.type', 'stores.address', 'stores.district', 'stores.region', 'stores.ubigeo', 'stores.codclient', 'stores.latitude', 'stores.longitude', 'stores.ruteado', 'stores.ejecutivo', 'stores.coordinador', 'stores.rubro', 'stores.test', 'stores.created_at', 'stores.updated_at')->where('company_stores.company_id', $company_id)->where('stores.test', $test)->where('stores.region', $city)->get();
                    }
                }
                break;

        }


        return $registros;
    }

    public function getStoresForRouting($routing,$departamento){
        $regs = CompanyStore::join('stores','company_stores.store_id','=','stores.id')->join('companies','company_stores.company_id','=','companies.id')->join('customers','companies.customer_id','=','customers.id')->join('studies','companies.study_id','=','studies.id')->select('company_stores.id','company_stores.store_id','company_stores.company_id','stores.codclient', 'stores.fullname','stores.cadenaRuc','stores.type','stores.address','stores.urbanization','stores.region','stores.ubigeo','stores.district','stores.codclient','stores.latitude','stores.longitude','companies.active','companies.fullname as campaigne','customers.fullname as customer','customers.id as customer_id','companies.study_id','studies.fullname as estudio')->where('company_stores.ruteado',$routing)->where('stores.ubigeo',$departamento)->where('stores.test',0)->get();
        return $regs;
    }

    public function getStoresForRoutingForCompanyVisit($routing,$departamento,$company_id,$visit_id){
        $regs = CompanyStore::join('stores','company_stores.store_id','=','stores.id')->join('visit_stores','stores.id','=','visit_stores.store_id')->join('companies','company_stores.company_id','=','companies.id')->select('company_stores.id','company_stores.store_id','company_stores.company_id','stores.codclient', 'stores.fullname','stores.cadenaRuc','stores.type','stores.address','stores.urbanization','stores.region','stores.ubigeo','stores.district','stores.codclient','stores.latitude','stores.longitude','companies.active','companies.fullname as campaigne')->where('visit_stores.ruteado',$routing)->where('stores.ubigeo',$departamento)->where('stores.test',0)->where('company_stores.company_id',$company_id)->where('visit_stores.visit_id',$visit_id)->get();
        return $regs;
    }
} 
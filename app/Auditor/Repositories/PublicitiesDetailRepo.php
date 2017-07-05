<?php
namespace Auditor\Repositories;

use Auditor\Entities\PublicityDetail;


class PublicitiesDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PublicityDetail;
    }
    

    public function findDetailForCondition($publicity_id,$store_id,$company_id)
    {
        $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('store_id', $store_id)->where('company_id',$company_id)->get();

        //dd($totalStores);
        return $totalStores;
    }

    public function getRegForStoreCompanyPubli($store_id,$company_id,$publicity_id)
    {
        $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('store_id', $store_id)->where('company_id', $company_id)->get();
        return $totalStores;
    }


    public function getCountStoresForPublicity($company_id,$publicity_id,$cantidad=1,$city="0",$dex="0",$tipoBodega="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        $opciones = "";
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opciones .=" AND  stores.ubigeo<>'". $ciudadB."' AND  stores.tipo_bodega='". $tipoBodega."' AND  stores.distributor='".$dex."'";
                    }else{
                        $opciones .=" AND  stores.ubigeo='". $ciudadB."' AND  stores.tipo_bodega='". $tipoBodega."' AND  stores.distributor='".$dex."'";
                    }

                }else{
                    $opciones .=" AND  stores.ubigeo='". $city."' AND  stores.tipo_bodega='". $tipoBodega."' AND  stores.distributor='".$dex."'";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $opciones .=" AND  stores.tipo_bodega='". $tipoBodega."' AND  stores.distributor='".$dex."'";
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opciones .=" AND  stores.ubigeo<>'". $ciudadB."' AND  stores.tipo_bodega='". $tipoBodega."'";
                    }else{
                        $opciones .=" AND  stores.ubigeo='". $ciudadB."' AND  stores.tipo_bodega='". $tipoBodega."'";
                    }

                }else{
                    $opciones .=" AND  stores.ubigeo='". $city."' AND  stores.tipo_bodega='". $tipoBodega."'";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                $opciones .=" AND  stores.tipo_bodega='". $tipoBodega."'";
                break;
            case ($city <> "0") and ($dex<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opciones .=" AND  stores.ubigeo<>'". $ciudadB."' AND  stores.distributor='".$dex."'";
                    }else{//dd("entro");
                        $opciones .=" AND  stores.ubigeo='". $ciudadB."' AND  stores.distributor='".$dex."'";
                    }

                }else{
                    $opciones .=" AND  stores.ubigeo='". $city."' AND  stores.distributor='".$dex."'";
                }
                break;
            case ($city == "0") and ($dex<>"0"):
                $opciones .=" AND  stores.distributor='".$dex."'";
                break;
            case ($city == "0"):
                $opciones = "";
                break;
            case ($city <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $opciones .=" AND  stores.ubigeo<>'".$ciudadB."'";
                    }else{//dd("entro");
                        $opciones .=" AND  stores.ubigeo='".$ciudadB."'";
                    }

                }else{
                    $opciones .=" AND  stores.ubigeo='".$city."'";
                }
                break;
        }

        $sql = "SELECT
  `publicity_details`.`publicity_id`,
  `publicity_details`.`store_id`,
  `publicity_details`.`sod`
FROM
  `publicity_details`
  RIGHT OUTER JOIN `stores` ON (`publicity_details`.`store_id` = `stores`.`id`)
  RIGHT OUTER JOIN `company_stores` ON (`stores`.`id` = `company_stores`.`store_id`)
WHERE
  `stores`.`test` = 0 AND
  `company_stores`.`company_id` = '".$company_id."' AND
  `publicity_details`.`publicity_id` = '".$publicity_id."' ".$opciones."
GROUP BY
  publicity_details.store_id,`publicity_details`.`publicity_id`,`publicity_details`.`sod`";
        //dd($sql);
        if ($cantidad==1){
            return count(\DB::select($sql));
        }else{
            return \DB::select($sql);
        }

    }

    public function getDetailConditionPublicity($condition,$tipo,$publicity_id)
    {
        if($condition==0){
            $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('visible', $tipo)->get();
        }
        if($condition==1){
            $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('layout', $tipo)->get();
        }
        if($condition==2){
            $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('contaminated', $tipo)->get();
        }
        return $totalStores;
    }

    public function getFewStoresForConditions($publicity_id, $category_id)
    {
        if ($category_id == 42){
            $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('visible', 1)->where('contaminated', 0)->count();
        }else{
            $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('visible', 1)->where('layout', 1)->where('contaminated', 0)->count();
        }

        //dd($totalStores);
        return $totalStores;
    }

    public function getFewStoresForVisible($publicity_id,$valor,$company_id,$city = "0",$dex="0",$type_store = "0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($type_store <> "0")  and ($dex<>"0") :
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                }
                break;
            case ($city == "0") and ($type_store <> "0")  and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0") and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->count();
                break;
            case ($city == "0") and ($type_store <> "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->count();
                break;
            case ($city <> "0") and ($type_store == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->count();
                }
                break;
            case ($city <> "0") and ($type_store <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('visible', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->where('stores.tipo_bodega', $type_store)->count();
                }

                break;
        }

        //dd($totalStores);
        return $totalStores;
    }

    public function getFewStoresForLayout($publicity_id,$valor)
    {
        $totalStores = PublicityDetail::where('publicity_id', $publicity_id)->where('layout', $valor)->count();

        return $totalStores;
    }

    public function getFewStoresForContaminated($publicity_id,$valor,$company_id,$city = "0",$dex="0",$type_store = "0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($type_store <> "0")  and ($dex<>"0") :
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                }
                break;
            case ($city == "0") and ($type_store <> "0")  and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0") and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->count();
                break;
            case ($city == "0") and ($type_store <> "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->count();
                break;
            case ($city <> "0") and ($type_store == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->count();
                }
                break;
            case ($city <> "0") and ($type_store <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('contaminated', $valor)->where('publicity_details.company_id', $company_id)->where('stores.region', $city)->where('stores.tipo_bodega', $type_store)->count();
                }

                break;
        }
        return $totalStores;
    }

    public function getTotalStoresForPublicity($publicity_id,$company_id,$city = "0",$dex="0",$type_store = "0")
    {

        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($type_store <> "0")  and ($dex<>"0") :
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                }
                break;
            case ($city == "0") and ($type_store <> "0")  and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0") and ($dex<>"0") :
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.distributor', $dex)->count();
                break;
            case ($city == "0") and ($type_store == "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->count();
                break;
            case ($city == "0") and ($type_store <> "0"):
                $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.tipo_bodega', $type_store)->count();
                break;
            case ($city <> "0") and ($type_store == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $city)->count();
                }
                break;
            case ($city <> "0") and ($type_store <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }else{
                        $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $type_store)->count();
                    }

                }else{
                    $totalStores = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->where('publicity_details.publicity_id', $publicity_id)->where('result', 1)->where('publicity_details.company_id', $company_id)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $type_store)->count();
                }

                break;
        }
        //dd($totalStores);
        return $totalStores;
    }

    public function getCountPublicitiesDetails()
    {
        $totalOptions = PublicityDetail::select(\DB::raw('count(publicity_id) as num, publicity_id'))->where('result', 1)->groupBy('publicity_id')->orderBy('num', 'desc')->get();
        return $totalOptions;
    }

    public function listPublicitiesDetailsForPublicity($publicity_id)
    {
        $totalOptions = PublicityDetail::where('publicity_id', $publicity_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

    public function getPublicitiesForStore($store_id)
    {
        $totalOptions = PublicityDetail::where('store_id', $store_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

    public function getDetailPublicity($publicity_id,$company_id,$contaminado,$city="0",$dex="0",$type_store="0")
    {//dd($ubigeo);
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex<>"0") and ($type_store<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $type_store)->groupBy('publicity_details.store_id')->get();
                    }else{
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $type_store)->groupBy('publicity_details.store_id')->get();
                    }

                }else{
                    $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.region', $city)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $type_store)->groupBy('publicity_details.store_id')->get();
                }
                break;
            case ($city == "0") and ($dex<>"0") and ($type_store<>"0"):
                $polls = PublicityDetail::join('stores', 'publicity_details.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $type_store)->groupBy('publicity_details.store_id')->get();
                break;
            case ($city == "0") and ($dex=="0") and ($type_store<>"0"):
                $polls = PublicityDetail::join('stores', 'publicity_details.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.tipo_bodega', $type_store)->groupBy('publicity_details.store_id')->get();
                break;
            case ($city <> "0") and ($dex=="0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo','<>', $ciudadB)->groupBy('publicity_details.store_id')->get();
                    }else{
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo', $ciudadB)->groupBy('publicity_details.store_id')->get();
                    }

                }else{
                    $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.region', $city)->groupBy('publicity_details.store_id')->get();
                }
                break;
            case ($city == "0") and ($dex=="0"):
                $polls = PublicityDetail::join('stores', 'publicity_details.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->groupBy('publicity_details.store_id')->get();
                break;
            case ($city <> "0") and ($dex<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->groupBy('publicity_details.store_id')->get();
                    }else{
                        $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->groupBy('publicity_details.store_id')->get();
                    }

                }else{
                    $polls = PublicityDetail::join('stores','publicity_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.region', $city)->where('stores.distributor', $dex)->groupBy('publicity_details.store_id')->get();
                }
                break;
            case ($city == "0") and ($dex<>"0"):
                $polls = PublicityDetail::join('stores', 'publicity_details.store_id', '=', 'stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','stores.address','publicity_details.user_id','publicity_details.created_at')->where('publicity_details.company_id', $company_id)->where('stores.test', 0)->where('publicity_details.publicity_id', $publicity_id)->where('publicity_details.contaminated', $contaminado)->where('stores.distributor', $dex)->groupBy('publicity_details.store_id')->get();
                break;
        }

        return $polls;

    }

} 
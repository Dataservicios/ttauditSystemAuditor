<?php
namespace Auditor\Repositories;

use Auditor\Entities\PresenceDetail;


class PresenceDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PresenceDetail;
    }



    public function getListStoresCountProduct($tipo_bodega,$company_id,$city="0",$dex="0")
    {
        $anexo="";
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $anexo .=" AND  stores.ubigeo<>'". $ciudadB."' AND  stores.distributor='".$dex."'";
                    }else{//dd("entro");
                        $anexo .=" AND  stores.ubigeo='". $ciudadB."' AND  stores.distributor='".$dex."'";
                    }

                }else{
                    $anexo .=" AND  stores.ubigeo='". $city."' AND  stores.distributor='".$dex."'";
                }
                break;
            case ($city == "0") and ($dex<>"0"):
                $anexo .=" AND  stores.distributor='". $dex."'";
                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $anexo .=" AND  stores.ubigeo<>'".$ciudadB."'";
                    }else{//dd("entro");
                        $anexo .=" AND  stores.ubigeo='".$ciudadB."'";
                    }

                }else{
                    $anexo .=" AND  stores.ubigeo='".$city."'";
                }
                break;
        }
        $sql = "SELECT
  `stores`.`id`,
  `stores`.`fullname`,
  COUNT(`presence_details`.`presence_id`) AS `Nro_prod`
FROM
  `presence_details`
  INNER JOIN `stores` ON (`presence_details`.`store_id` = `stores`.`id`)
  INNER JOIN `company_stores` ON (`stores`.`id` = `company_stores`.`store_id`)
WHERE
  `stores`.`tipo_bodega` = '".$tipo_bodega."' AND
  `company_stores`.`company_id` = '".$company_id."' AND
  `stores`.`test` = 0 ".$anexo."
GROUP BY
  `stores`.`id`,
  `stores`.`fullname`";
        return \DB::select($sql);
    }

    public function getCountPresenciasDetails()
    {
        $totalOptions = PresenceDetail::select(\DB::raw('count(presence_id) as num, presence_id'))->where('result_product', 1)->groupBy('presence_id')->orderBy('num', 'desc')->get();
        return $totalOptions;
    }

    public function listPresenciasDetailsForPresence($presence_id)
    {
        $totalOptions = PresenceDetail::where('presence_id', $presence_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

    public function getPresenceForStore($store_id)
    {
        $totalOptions = PresenceDetail::where('store_id', $store_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

    public function getFewStoresForPresence($presence_id)
    {
        $totalStores = PresenceDetail::where('presence_id', $presence_id)->count();

        //dd($totalStores);
        return $totalStores;
    }

    public function getPresenceFound($company_id,$presence_id="0",$city="0",$category_product_id="0",$dex="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($category_product_id <> "0")  and ($dex<>"0") :
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->where('stores.distributor', $dex)->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                        }
                    }

                }else{
                    if ($presence_id=="0"){
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.region', $city)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                    }else{
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($city == "0") and ($category_product_id <> "0")  and ($dex<>"0") :
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->where('presence_details.presence_id', $presence_id)->get();
                }
                break;
            case ($city == "0") and ($category_product_id == "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo','<>', $ciudadB)->get();
                        }
                    }else{
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $ciudadB)->get();
                        }
                    }

                }else{
                    if ($presence_id=="0"){
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.region', $city)->groupBy('presence_details.presence_id')->get();
                    }else{
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->get();
                    }
                }
                break;
            case ($city == "0") and ($category_product_id <> "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('products.category_product_id', $category_product_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->get();
                        }
                    }else{
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->get();
                        }
                    }

                }else{
                    if ($presence_id=="0"){
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('stores.region', $city)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                    }else{
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->get();
                    }
                }

                break;
        }

        //dd($totalStores);
        return $totalStores;
    }

    public function getPriceVisible($company_id,$presence_id="0",$visible=1,$city="0",$category_product_id="0")
    {
        switch (true) {
            case ($city == "0") and ($category_product_id == "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('presence_details.presence_id', $presence_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id == "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('stores.ubigeo', $city)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->get();
                }
                break;
            case ($city == "0") and ($category_product_id <> "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('presence_details.presence_id', $presence_id)->where('products.category_product_id', $category_product_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id <> "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.visible_price', $visible)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->get();
                }
                break;
        }

        //dd($totalStores);
        return $totalStores;
    }

    public function getPriceFound($company_id,$presence_id="0",$result=1,$city="0",$category_product_id="0",$dex="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($category_product_id <> "0")  and ($dex<>"0") :
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                        }
                    }else{
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                        }
                    }

                }else{
                    if ($presence_id=="0"){
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                    }else{
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                    }
                }
                break;
            case ($city == "0") and ($category_product_id <> "0")  and ($dex<>"0") :
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('products.category_product_id', $category_product_id)->where('stores.distributor', $dex)->get();
                }
                break;
            case ($city == "0") and ($category_product_id == "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id == "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo', $city)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->get();
                }
                break;
            case ($city == "0") and ($category_product_id <> "0"):
                if ($presence_id=="0"){
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                }else{
                    $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('products.category_product_id', $category_product_id)->get();
                }
                break;
            case ($city <> "0") and ($category_product_id <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo','<>', $ciudadB)->where('products.category_product_id', $category_product_id)->get();
                        }
                    }else{
                        if ($presence_id=="0"){
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                        }else{
                            $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $ciudadB)->where('products.category_product_id', $category_product_id)->get();
                        }
                    }

                }else{
                    if ($presence_id=="0"){
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->groupBy('presence_details.presence_id')->get();
                    }else{
                        $totalStores = PresenceDetail::join('presences','presence_details.presence_id','=','presences.id')->join('products','presences.product_id','=','products.id')->join('stores','presence_details.store_id','=','stores.id')->where('presence_details.company_id', $company_id)->where('presence_details.result_price', $result)->where('presence_details.presence_id', $presence_id)->where('stores.ubigeo', $city)->where('products.category_product_id', $category_product_id)->get();
                    }
                }
                break;
        }

        //dd($totalStores);
        return $totalStores;
    }

} 
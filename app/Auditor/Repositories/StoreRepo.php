<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 30/12/2014
 * Time: 12:38 PM
 */

namespace Auditor\Repositories;

use Auditor\Entities\CompanyStore;
use Auditor\Entities\Store;

class StoreRepo extends BaseRepo {

    public function getModel()
    {
        return new Store();
    }

    public function listStore()
    {
        $store = Store::paginate();
        return $store;
    }

    public function newStore()
    {
        $store = new Store();
        //$user->type = 'auditor';
        return $store;
    }

    public function getStoreForCod($codclient,$company_id)
    {
        $store = \DB::table('stores')->join('company_stores','company_stores.store_id','=','stores.id')->where('codclient', $codclient)->where('company_id', $company_id)->get();
        return $store;
    }

    public function updateRouteForStore($store_id,$valor)
    {
        $affectedRows = Store::where('id', '=', $store_id)->update(array('ruteado' => $valor));
        /*$store = \DB::table('stores')
            ->where('id', $store_id)
            ->update(array('ruteado' => $valor));*/
        return true;
    }

    public function updateEjcutivoForStore($store_id,$ejecutivo)
    {
        $affectedRows = Store::where('id', '=', $store_id)->update(array('ejecutivo' => $ejecutivo));
        /*$store = \DB::table('stores')
            ->where('id', $store_id)
            ->update(array('ruteado' => $valor));*/
        if ($affectedRows>0)  return true; else return false;
    }

    public function deleteStore($store_id)
    {
        $companyStore = CompanyStore::where('store_id', '=', $store_id)->delete();
        $affectedRows = Store::where('id', '=', $store_id)->delete();

        if ($affectedRows>0)  return true; else return false;
    }

    public function getDepartamentForCampaigne($company_id="0",$format="0")
    {
        if ($company_id=="0"){
            $valor = Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('stores.test', 0)->where('stores.ubigeo','<>', "")->groupBy('stores.ubigeo')->get();
        }else{
            $valor = Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.ubigeo','<>', "")->where('stores.test', 0)->groupBy('stores.ubigeo')->get();
        }
        if ($format==1){
            foreach ($valor as $val)
            {
                $valorArray[] = array($val->ubigeo => ucwords(strtolower($val->ubigeo)));

            }//dd($valorArray);
            return $valorArray;
        }
        if ($format==2){
            foreach ($valor as $val)
            {
                $valorArray[] = ucwords(strtolower($val->ubigeo));

            }//dd($valorArray);
            return $valorArray;
        }
        return $valor;
    }

    public function getDexForCampaigne($company_id="0")
    {
        if ($company_id=="0"){
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('stores.test', 0)->where('stores.distributor','<>', "")->groupBy('stores.distributor')->get();
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.distributor','<>', "")->where('stores.test', 0)->groupBy('stores.distributor')->get();
        }
    }

    public function getTypeStoreForCampaigne($company_id="0")
    {
        if ($company_id=="0"){
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('stores.test', 0)->where('stores.tipo_bodega','<>', "")->groupBy('stores.tipo_bodega')->get();
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.tipo_bodega','<>', "")->where('stores.test', 0)->groupBy('stores.tipo_bodega')->get();
        }
    }

    public function getCityForCampaigne($company_id="0",$ubigeo="0")
    {
        if ($ubigeo=="0")
        {
            if ($company_id=="0"){
                return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('stores.test', 0)->where('stores.region','<>', 'Lima')->where('stores.region','<>', 'Callao')->where('stores.region','<>', '')->groupBy('stores.region')->get();
            }else{
                return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.region','<>', 'Lima')->where('stores.region','<>', 'Callao')->where('stores.region','<>', '')->groupBy('stores.region')->get();
            }
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.ubigeo','<>', '')->groupBy('stores.ubigeo')->get();
        }

    }

    /**
     * @param $company_id
     * @param string $format
     * @return array
     */
    public function getHorizontalForCampaigne($company_id, $format="0")
    {
        $valor = Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.type','<>', 'CADENA')->groupBy('stores.type')->get();
        //dd($valor);
        if ($format==1){
            if (count($valor)>0){
                foreach ($valor as $val)
                {
                    $valorArray[] = array($val->cadenaRuc => ucwords(strtolower($val->type)));

                }
            }else{
                $valorArray = [];
            }

            return $valorArray;
        }
        if ($format==2){
            if (count($valor)>0){
                foreach ($valor as $val)
                {
                    $valorArray[] = ucwords(strtolower($val->type));
                }
            }else{
                $valorArray = [];
            }

            return $valorArray;
        }
        return $valor;
    }

    /**
     * @param $company_id
     * @param string $format
     * @return array
     */
    public function getCadenasForCampaigne($company_id, $format="0")
    {
        $valor = Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->where('stores.type', 'CADENA')->groupBy('stores.cadenaRuc')->get();
        //dd($valor);
        if ($format==1){
            if (count($valor)>0){
                foreach ($valor as $val)
                {
                    if ($val->cadenaRuc <> 'B&S')
                    {
                        $valorArray[] = array($val->cadenaRuc => ucwords(strtolower($val->cadenaRuc)));
                    }else{
                        $valorArray[] = array($val->cadenaRuc => $val->cadenaRuc);
                    }

                }
            }else{
                $valorArray = [];
            }

            return $valorArray;
        }
        if ($format==2){
            if (count($valor)>0){
                foreach ($valor as $val)
                {
                    if ($val->cadenaRuc <> 'B&S')
                    {
                        $valorArray[] = ucwords(strtolower($val->cadenaRuc));
                    }else{
                        $valorArray[] = $val->cadenaRuc;
                    }

                }
            }else{
                $valorArray = [];
            }

            return $valorArray;
        }
        return $valor;
    }

    public function getEjecutivosForCampaigne($company_id)
    {
        return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.test', 0)->groupBy('stores.ejecutivo')->get();
    }

    public function searchStores($texto,$company_id,$type='auditor')
    {
        if ($type=='auditor'){
            $sqlcoord="SELECT 
  `roads_resume`.`store_id` AS `id`,
  `roads_resume`.`fullname`,
  `roads_resume`.`codclient`,
  `roads_resume`.`company_id`,
  `roads_resume`.`user_id`,
  `roads_resume`.`auditor`,
  `companies`.`fullname` AS `company`
FROM
  `roads_resume`
  INNER JOIN `companies` ON (`roads_resume`.`company_id` = `companies`.`id`)
WHERE
  (`roads_resume`.`fullname` LIKE '%".$texto."%' or `roads_resume`.`store_id` LIKE '%".$texto."%' or `roads_resume`.`codclient` LIKE '%".$texto."%') AND 
  `roads_resume`.`company_id` = ".$company_id."
LIMIT 15";
            $stores = \DB::select($sqlcoord);
        }
        if ($type=='promotoria'){
            $sqlcoord="SELECT
  `a`.`store_id` AS id,
`stores`.`fullname`,
`stores`.`codclient`,
`companies`.`id` as `company_id`,
`e`.`id` as `user_id`,
  `e`.`fullname` AS `auditor`,
  `companies`.`fullname` as `company`
FROM
  `poll_details` `a`
LEFT OUTER JOIN `stores` ON (`a`.`store_id` = `stores`.`id`)
  LEFT OUTER JOIN `company_stores` `f` ON (`a`.`store_id` = `f`.`store_id`)
  LEFT OUTER JOIN `users` `e` ON (`a`.`auditor` = `e`.`id`)
  LEFT OUTER JOIN `companies` ON (`f`.`company_id` = `companies`.`id`)
WHERE
  (`stores`.`fullname` LIKE '%".$texto."%' or `stores`.`id` LIKE '%".$texto."%' or `stores`.`codclient` LIKE '%".$texto."%') AND
  `f`.`company_id` = '".$company_id."' 
GROUP BY
  `f`.`company_id`,
  `a`.`store_id`
ORDER BY `a`.`created_at` DESC";
            $stores = \DB::select($sqlcoord);
        }
        if ($type==''){
            $stores = [];
        }

        return $stores;

    }

    public function getCitiesForEjecutive($ejecutive,$company_id='0')
    {
        if ($company_id=='0'){
            return Store::where('stores.ejecutivo', $ejecutive)->groupBy('stores.ubigeo')->get();
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.ejecutivo', $ejecutive)->groupBy('stores.ubigeo')->get();
        }
    }

    /**
     * @param $ejecutive
     * @param string $company_id
     * @return objeto store
     * Busca si existen puntos de tipo cadena asignados a ese ejecutivo aplicado principalmente para Bayer
     * para usarlo con getHorizontalForEjecutive y ver si se mostraran los filtros cadena y horizontal
     */
    public function getCadenasForEjecutive($ejecutive, $company_id='0')
    {
        if ($company_id=='0'){
            //return Store::where('stores.ejecutivo', $ejecutive)->where('stores.type','CADENA')->groupBy('stores.cadenaRuc')->get();
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id','>=', 30)->where('stores.ejecutivo', $ejecutive)->where('stores.type','CADENA')->groupBy('stores.cadenaRuc')->get();
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.ejecutivo', $ejecutive)->where('stores.type','CADENA')->groupBy('stores.cadenaRuc')->get();
        }
    }

    /**
     * @param $ejecutive
     * @param string $company_id
     * @return objeto store
     * Busca si existen puntos de tipo horizontal asignados a ese ejecutivo aplicado principalmente para Bayer
     * para usarlo con getCadenasForEjecutive y ver si se mostraran los filtros cadena y horizontal
     */
    public function getHorizontalForEjecutive($ejecutive, $company_id='0')
    {
        if ($company_id=='0'){
            //return Store::where('stores.ejecutivo', $ejecutive)->where('stores.type','<>','CADENA')->groupBy('stores.type')->get();
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id','>=', 30)->where('stores.ejecutivo', $ejecutive)->where('stores.type','<>','CADENA')->groupBy('stores.type')->get();
        }else{
            return Store::join('company_stores', 'company_stores.store_id', '=', 'stores.id')->where('company_stores.company_id', $company_id)->where('stores.ejecutivo', $ejecutive)->where('stores.type','<>','CADENA')->groupBy('stores.type')->get();
        }
    }
} 
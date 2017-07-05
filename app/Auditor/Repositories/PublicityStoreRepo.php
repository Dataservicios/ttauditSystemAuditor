<?php
namespace Auditor\Repositories;

use Auditor\Entities\PublicityStore;


class PublicityStoreRepo extends BaseRepo{

    public function getModel()
    {
        return new PublicityStore;
    }
    
    public function getPublicityStores($tipo_bodega="0",$company_id=null)
    {
        if ($tipo_bodega<>"0"){
            $totalStores = PublicityStore::where('tipo_bodega', $tipo_bodega)->where('company_id', $company_id)->get();
        }else{
            $totalStores = PublicityStore::where('tipo_bodega', null)->where('company_id', $company_id)->get();
        }

        return $totalStores;
    }

    /**
     * @param $company_id
     * @param $store_id
     * @param $visit_id
     * @return PublicityStore unico que cumple condiciones
     *
     */
    public function getHistoryPublicityStore($company_id, $store_id, $visit_id){
        return $totalPublicity = PublicityStore::where('company_id', $company_id)->where('store_id', $store_id)->where('visit_id',$visit_id)->orderBy('created_at','DESC')->get();
    }

    public function searchPublicityStore($publicityStore,$tipo="0")
    {
        if ($tipo == "0"){
            $result_publicity_store = PublicityStore::where('publicity_id', $publicityStore->publicity_id)->where('store_id',$publicityStore->store_id)->where('company_id',$publicityStore->company_id)->where('visit_id',$publicityStore->visit_id)->first();
        }

        return $result_publicity_store;
    }

    public function existPublicityInStore($publicity_id,$store_id,$company_id,$visit_id){
        $count_publicity_store = PublicityStore::where('publicity_id', $publicity_id)->where('store_id',$store_id)->where('company_id',$company_id)->count();
        if ($count_publicity_store>0){
            return true;
        }else{
            return false;
        }
    }

} 
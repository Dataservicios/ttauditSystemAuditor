<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\ProductStoreRegion;


class ProductStoreRegionRepo extends BaseRepo{

    public function getModel()
    {
        return new ProductStoreRegion();
    }

    /*public function getProductsForCampaigne($campaigne_id)
    {
        $registros = Presence::join('products','presences.product_id','=','products.id')->select('presences.product_id', 'presences.id','products.fullname')->where('products.company_id', $campaigne_id)->get();
        return $registros;
    }*/

    public function getProductsForCampaigneForTypeStore($campaigne_id,$type)
    {
        if ($type<>""){
            $registros = ProductStoreRegion::where('company_id', $campaigne_id)->where('type', $type)->get();
        }else{
            $registros = ProductStoreRegion::where('company_id', $campaigne_id)->get();
        }

        return $registros;
    }

    

} 
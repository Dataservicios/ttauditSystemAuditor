<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\Presence;


class PresenceRepo extends BaseRepo{

    public function getModel()
    {
        return new Presence();
    }

    public function getProductsForCampaigne($campaigne_id,$category_product="0")
    {
        if ($category_product=="0"){
            $registros = Presence::join('products','presences.product_id','=','products.id')->select('presences.product_id', 'presences.id','products.fullname')->where('presences.company_id', $campaigne_id)->get();
        }else{
            $registros = Presence::join('products','presences.product_id','=','products.id')->select('presences.product_id', 'presences.id','products.fullname')->where('presences.company_id', $campaigne_id)->where('products.category_product_id', $category_product)->get();
        }

        return $registros;
    }

} 
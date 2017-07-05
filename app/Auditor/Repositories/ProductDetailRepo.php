<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 14/12/2014
 * Time: 08:49 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\ProductDetail;


class ProductDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new ProductDetail;
    }

    public function getProductsForCampaigne($company_id)
    {
        return ProductDetail::where('company_id',$company_id)->orderBy('orden', 'ASC')->get();
    }

    public function getProductsCompetitionForCampaigne($company_id,$valor="1")
    {
        return ProductDetail::where('company_id',$company_id)->where('competencia',$valor)->orderBy('orden', 'ASC')->get();

    }

    /**
     * @param $arrayCampaignes lista de id de campañas
     * Devuelve listado de productos agrupados usados en todas las campañas
     */
    public function getAllProductsForCampaigne($arrayCampaignes)
    {
        $products = ProductDetail::join('products', 'product_detail.product_id', '=', 'products.id')->whereIn('product_detail.company_id', $arrayCampaignes)->groupBy('product_detail.product_id')->get();
        return $products;
    }

    public function getAllProductForCity($company_id,$competencia)
    {
        $products = ProductDetail::join('products', 'product_detail.product_id','=', 'products.id')->join('product_store_region', 'products.id','=', 'product_store_region.product_id')->select('products.id', 'products.fullname','products.precio','products.imagen','product_store_region.region','product_detail.company_id','product_detail.competencia')->where('product_detail.company_id', $company_id)->where('product_detail.competencia',$competencia)->get();
        return $products;
    }
} 
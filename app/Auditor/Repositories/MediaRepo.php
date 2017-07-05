<?php
namespace Auditor\Repositories;

use Auditor\Entities\Media;


class MediaRepo extends BaseRepo{

    public function getModel()
    {
        return new Media();
    }

    public function photosPollStore($poll_id="0",$store_id="0")
    {
        $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('store_id', $store_id)->where('tipo', 1)->get();
        return $photos;
    }

    public function photosPublicityStore($publicity_id="0",$store_id="0",$company_id="0")
    {
        $photos = \DB::table('medias')->where('publicities_id', $publicity_id)->where('store_id', $store_id)->where('tipo', 1)->where('company_id', $company_id)->get();
        return $photos;
    }

    public function getAllPhotosPublicityStore($store_id="0",$company_id="0")
    {
        $photos = \DB::table('medias')->where('publicities_id','<>', 0)->where('store_id', $store_id)->where('tipo', 1)->where('company_id', $company_id)->get();
        return $photos;
    }

    public function photosProductPollStore($poll_id="0",$store_id="0", $company_id="0",$product_id="0",$publicity_id="0",$category_product_id="0",$visit_id="0")
    {
        if ($category_product_id=="0"){
            if ($publicity_id=="0")
            {
                if ($company_id=="0")
                {
                    if ($product_id=="0"){
                        $photos = Media::where('poll_id', $poll_id)->where('store_id', $store_id)->where('tipo', 1)->get();
                    }else{
                        $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('product_id', $product_id)->where('store_id', $store_id)->where('tipo', 1)->groupBy('store_id')->get();
                    }

                }else{
                    $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('product_id', $product_id)->where('store_id', $store_id)->where('company_id', $company_id)->where('tipo', 1)->get();
                }
            }else{
                if ($company_id=="0")
                {
                    $photos = \DB::table('medias')->where('publicities_id', $publicity_id)->where('store_id', $store_id)->where('tipo', 1)->groupBy('store_id')->get();
                }else{
                    $photos = \DB::table('medias')->where('publicities_id', $publicity_id)->where('store_id', $store_id)->where('company_id', $company_id)->where('visit_id',$visit_id)->where('tipo',1)->get();
                }
            }
        }else{
            if ($company_id=="0")
            {
                $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('store_id', $store_id)->where('category_product_id', $category_product_id)->where('tipo', 1)->get();

            }else{
                $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('store_id', $store_id)->where('category_product_id', $category_product_id)->where('company_id', $company_id)->where('tipo', 1)->get();
            }
        }



        //dd($company_id);
        return $photos;
    }

    public function photosForStoreCompany($store_id,$company_id)
    {
        $photos = Media::where('store_id', $store_id)->where('company_id', $company_id)->where('tipo', 1)->get();
        return $photos;
    }
    

} 
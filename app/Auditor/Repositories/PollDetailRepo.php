<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollDetail;


class PollDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PollDetail;
    }

    public function searchPollDetail($pollDetail,$tipo="0")
    {
        if ($tipo == "0"){
            $result_poll_detail = PollDetail::where('poll_id', $pollDetail->poll_id)->where('store_id',$pollDetail->store_id)->where('company_id',$pollDetail->company_id)->where('product_id',$pollDetail->product_id)->where('publicity_id',$pollDetail->publicity_id)->first();
        }
        if ($tipo == "1"){
            $result_poll_detail = PollDetail::where('poll_id', $pollDetail->poll_id)->where('store_id',$pollDetail->store_id)->where('company_id',$pollDetail->company_id)->where('product_id',$pollDetail->product_id)->where('publicity_id',$pollDetail->publicity_id)->where('category_product_id',$pollDetail->category_product_id)->first();
        }
        if ($tipo == "2"){
            $result_poll_detail = PollDetail::where('poll_id', $pollDetail->poll_id)->where('store_id',$pollDetail->store_id)->where('company_id',$pollDetail->company_id)->where('product_id',$pollDetail->product_id)->where('publicity_id',$pollDetail->publicity_id)->where('stock_product_pop_id',$pollDetail->stock_product_pop_id)->where('visit_id',$pollDetail->visit_id)->first();
        }
        if ($tipo == "3"){
            $result_poll_detail = PollDetail::where('poll_id', $pollDetail->poll_id)->where('store_id',$pollDetail->store_id)->where('company_id',$pollDetail->company_id)->where('visit_id',$pollDetail->visit_id)->get();
        }

        return $result_poll_detail;
    }

    public function getProductsForPollDetail()
    {
        return PollDetail::join('products','poll_details.product_id','=','products.id')->select('products.id', 'products.fullname','poll_details.product_id')->groupBy('poll_details.product_id')->get();
    }

    public function getIndicatorForIdPoll($poll_id)
    {
        $indicators = \DB::table('poll_details')->select('sino', 'options','limits','media','coment')->where('poll_id', $poll_id)->first();
        //dd($indicators);
        return $indicators;
    }

    /**
     * @param $poll_id
     * @param $store_id
     * @return string
     */
    public function getCommentQuestion($poll_id, $store_id)
    {

        $comentario = PollDetail::where('poll_id', $poll_id)->where('store_id',$store_id)->get();
        if (count($comentario)>0){
            return $comentario[0]->comentario;
        }else{
            return "";
        }

    }

    /**
     * @param $poll_id
     * @param $store_id
     * @param $company_id
     * @return string
     */
    public function getRegForStoreCompanyPoll($store_id,$company_id,$poll_id,$product_id="0")
    {
        if ($company_id == "0"){
            $comentario = PollDetail::where('poll_id', $poll_id)->where('store_id',$store_id)->get();
        }else{
            if ($product_id=="0")
            {
                $comentario = PollDetail::where('poll_id', $poll_id)->where('store_id',$store_id)->where('company_id',$company_id)->get();
            }else{
                $comentario = PollDetail::where('poll_id', $poll_id)->where('store_id',$store_id)->where('company_id',$company_id)->where('product_id',$product_id)->get();
            }

        }

        return $comentario;

    }


    /**
     * Total de preguntas por tienda
     * @param $store_id
     * @return mixed
     */
    public function getTotalPollsStore($store_id)
    {
        $total = \DB::table('poll_details')->where('store_id', $store_id)->groupBy('poll_id')->count();
        //dd($indicators);
        return $total;
    }

    public function getResultForStore($company_id,$store_id,$poll_id,$publicity_id="0",$product_id="0")
    {
        if ($publicity_id=="0"){
            if ($product_id=="0"){
                $comentario = PollDetail::where('poll_id', $poll_id)->where('company_id',$company_id)->where('store_id',$store_id)->get();
            }else{
                $comentario = PollDetail::where('poll_id', $poll_id)->where('company_id',$company_id)->where('store_id',$store_id)->where('product_id',$product_id)->get();
            }
        }else{
            if ($product_id=="0"){
                $comentario = PollDetail::where('poll_id', $poll_id)->where('company_id',$company_id)->where('store_id',$store_id)->where('publicity_id',$publicity_id)->get();
            }else{
                $comentario = PollDetail::where('poll_id', $poll_id)->where('company_id',$company_id)->where('store_id',$store_id)->where('publicity_id',$publicity_id)->where('product_id',$product_id)->get();
            }
        }

        return $comentario;
    }

    /**
     * Total de tiendas por pregunta
     * @param $store_id
     * @return mixed
     */
    public function getTotalStoreForQuestion($poll_id)
    {
        $total = \DB::table('poll_details')->where('poll_id', $poll_id)->groupBy('store_id')->count();
        //dd($indicators);
        return $total;
    }

    public function getDetailSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0,$product_id="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$soloPhotos="0",$horizontal="0")
    {             //getDetailSiNo($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[6],$product_id,$valores[4],$valores[5],$dex="0",$tipoBodega="0");
        //dd($poll_id."-".$city."-".$district."-".$ejecutivo."-".$rubro."-".$result."-".$product_id."-".$ubigeo."-".$cadena);
        $toda = explode('Toda ',$city);//dd($toda);
        if ($toda[0] == ''){
            $ciudadB = $toda[1];
            $city = 1;
        }
        if (is_numeric($city) or is_numeric($ubigeo)) {
            if (($city == 5) or ($ubigeo == 5)) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($dex <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                    }
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0" and $dex <> "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result',$result)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.type', $horizontal)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('stores.test', 0)->where('poll_details.result', $result)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;

            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):

                if ($product_id<>"0"){
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }else {
                    if (is_numeric($city)) {
                        if ($city == 5) {
                            $subSql = "`s`.`ubigeo`<>'" . $ciudadB . "' AND";
                        } else {
                            $subSql = "`s`.`ubigeo`='" . $ciudadB . "' AND";
                        }
                    } else {
                        $subSql = "`s`.`region`='" . $city . "' AND";
                    }
                    $total1 = "SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '" . $poll_id . "' AND
  `s`.`test` = 0 AND " . $subSql . " `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_option_details`.`poll_option_id` = '" . $district . "')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '" . $poll_id . "' AND
  `s`.`test` = 0 AND " . $subSql . " `s`.`ejecutivo` = '".$ejecutivo."' AND 
  `poll_option_details`.`poll_option_id` = '" . $rubro . "'))  a
GROUP BY a.store_id";
                    $consulta = \DB::select($total1);//dd($total1);
                    if (count($consulta) == 0) {
                        $storesDetail = '';
                    } else {
                        foreach ($consulta as $reg) {
                            if ($reg->cantidad > 1) {
                                $storesDetail[] = $reg->store_id;
                            }
                        }
                    }//dd($storesDetail);
                    if (count($storesDetail)>0){
                        foreach ($storesDetail as $stores){
                            $detailResult[] = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.id', $stores)->get();
                        }
                    }else{
                        $detailResult =0;
                    }
                }
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0" and $district <> "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result',$result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.district', $district)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        if ($soloPhotos=="0")
                        {
                            $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.ubigeo', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                        }else{
                            $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.product_id', $product_id)->where('stores.ubigeo', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                        }

                    }

                }else{
                    if ($soloPhotos=="0")
                    {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.product_id', $product_id)->where('stores.region', $city)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }
                break;
            default:
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id','stores.cadenaRuc','stores.type', 'stores.codclient','stores.tipo_bodega','stores.distributor','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('stores.test', 0)->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('poll_details.product_id', $product_id)->orderBy('poll_details.created_at', 'desc')->get();
                break;
        }//dd($detailResult);
        return $detailResult;
    }

    public function getTotalSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$horizontal = "0")
    {
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
        switch (true) {
            //alicorp
            case ($ubigeo <> "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                break;
            case ($ubigeo <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.tipo_bodega', $tipoBodega)->count();
                }
                break;
            case ($ubigeo == "0") and ($tipoBodega<>"0"):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->count();
                break;
            case ($ubigeo <> "0") and ($dex<>"0"):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->where('stores.distributor', $dex)->count();
                }
                break;
            case ($ubigeo == "0") and ($dex<>"0"):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.distributor', $dex)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.distributor', $dex)->count();
                break;
            case ($ubigeo <> "0") and (!is_array($ubigeo)):
                if (is_numeric($ubigeo)){
                    if ($ubigeo == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ubigeo)->count();
                }
                break;
            //fin alicorp
            //bayer
            case ($ubigeo=='0') and (is_array($horizontal)) and ($cadena=='0') and ($ejecutivo == "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->count();
                }

                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case (is_array($ubigeo))  and (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;

            case (is_array($ubigeo)) and (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                //dd($totalNo);
                break;
            case (is_array($horizontal)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                //dd($totalNo);
                break;
            case (is_array($ubigeo)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($horizontal)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case (is_array($cadena)) and ($ejecutivo <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case ($ubigeo == "0") and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.type', $horizontal)->count();
                }
                break;
            case (is_array($ubigeo)) and (is_array($horizontal)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.type', $horizontal)->count();
                }
                //dd($totalNo);
                break;
            case (is_array($ubigeo)) and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                break;
            case (is_array($ubigeo)) and ($horizontal=="0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->count();
                }
                //dd($totalNo);
                break;
            case (is_array($ubigeo)) and ($cadena == "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.ubigeo', $ubigeo)->count();
                }
                break;
            case ($ubigeo == "0") and (is_array($cadena)):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->whereIn('stores.cadenaRuc', $cadena)->count();
                }
                break;


            //fin bayer

            case $store_id<>"0":
                if ($poll_id==38) {
                    $total2 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 2)->where('store_id', $store_id)->count();
                    $total3 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 3)->where('store_id', $store_id)->count();
                    $total4 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 4)->where('store_id', $store_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 1)->where('store_id', $store_id)->count();
                    $totalNo = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 0)->where('store_id', $store_id)->count();
                }

                break;
            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro=="0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->count();
                }
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->where('poll_details.product_id', $product_id)->count();
                }else{
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
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 1 AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 1 AND ".$subSql."
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
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 0 AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 0 AND ".$subSql."
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

                }
                break;
            case ($district <> "0") and ($rubro<>"0"):
                $total1 ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 1 AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 1 AND
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
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 0 AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`result` = 0 AND
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
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                }else{
                    if (is_numeric($city)){
                        if ($city == 5) {
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        }
                    }else{
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $district)->count();
                    }

                }
                break;
            case ($city <> "0" and $district <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                }else{
                    if (is_numeric($city)){
                        if ($city == 5) {
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $district)->count();
                        }
                    }else{
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $district)->count();
                    }
                }
                break;
            case ($city == "0" and $district <> "0"):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $district)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $district)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $district)->count();
                }
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }
                    }else{
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }
                    }

                }else{
                    if ($product_id<>"0"){
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                    }else{
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }
                }


                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }
                    }else{
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }
                    }

                }else{
                    if ($product_id<>"0"){
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                    }else{
                        $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }
                }
                break;
            case (($city == "0") and ($rubro <> "0")):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $rubro)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $rubro)->count();
                    $totalNo = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('poll_option_details.poll_option_id', $rubro)->count();
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }else{
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }

                }else{
                    if ($product_id<>"0"){
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }


                break;
            case (($city == "0") and ($ejecutivo <> "0")):
                if ($product_id<>"0"){
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->where('poll_details.product_id', $product_id)->count();
                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ejecutivo', $ejecutivo)->count();
                }
                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }
                    }else{//dd("entro");
                        if ($product_id<>"0"){
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_details.product_id', $product_id)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('poll_details.product_id', $product_id)->count();
                        }else{
                            $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                            $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                            //dd($totalSi);
                        }
                    }

                }else{
                    if ($product_id<>"0"){
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->where('poll_details.product_id', $product_id)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->where('poll_details.product_id', $product_id)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.region', $city)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.region', $city)->count();
                    }
                }


                break;
        }
        if ($poll_id==38) {
            $result = array('Afiches' => $total2,'Afiche_plastico'=>$total3,'Letreros'=>$total4);
        }else{
            $result = array('si' => $totalSi,'no'=>$totalNo);
        }


        return $result;
    }

    public function getTotalSiNoPublicity($poll_id,$publicity_id,$city="0",$dex="0",$tipoBodega="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }else{
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }
                }else{
                    //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$city."' AND `stores.distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->count();
                    $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$city."' AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->count();
                $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->count();
                $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`distributor` = '".$dex."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }else{
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    }
                }else{
                    //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->count();
                    $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$city."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                    //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->count();
                    $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$city."' AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->count();
                $opcionesSi = " AND `poll_details`.`result` = 1  AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->count();
                $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores.tipo_bodega` = '".$tipoBodega."' ";
                break;
            case ($city <> "0") and ($dex <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` <> '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                    }else{
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$ciudadB."' AND `stores`.`distributor` = '".$dex."' ";
                    }
                }else{
                    //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->count();
                    $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$city."' AND `stores`.`distributor` = '".$dex."' ";
                    //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->count();
                    $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$city."' AND `stores`.`distributor` = '".$dex."' ";
                }
                break;
            case ($city <> "0") and ($dex == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` <> '".$ciudadB."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` <> '".$ciudadB."' ";
                    }else{
                        //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                        $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$ciudadB."' ";
                        //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->count();
                        $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$ciudadB."' ";
                    }

                }else{
                    //$totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.ubigeo', $city)->count();
                    $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`ubigeo` = '".$city."' ";
                    //$totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.ubigeo', $city)->count();
                    $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`ubigeo` = '".$city."' ";
                }
                break;
            case ($city == "0" and $dex <> "0"):
                //$totalSi = \DB::table('poll_details')->leftJoin('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->where('stores.distributor', $dex)->count();
                $opcionesSi = " AND `poll_details`.`result` = 1 AND `stores`.`distributor` = '".$dex."' ";
                //$totalNo = \DB::table('poll_details')->leftJoin('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->where('stores.distributor', $dex)->count();
                $opcionesNo = " AND `poll_details`.`result` = 0 AND `stores`.`distributor` = '".$dex."' ";
                break;
            case ($city == "0") and ($dex == "0"):
                //$totalSi = \DB::table('poll_details')->leftJoin('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 1)->where('stores.test', 0)->count();
                $opcionesSi = ' AND `poll_details`.`result` = 1 ';
                //$totalNo = \DB::table('poll_details')->leftJoin('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', 0)->where('stores.test', 0)->count();
                $opcionesNo = ' AND `poll_details`.`result` = 0 ';

                break;


        }
        $sql = "SELECT
  `poll_details`.`store_id`
FROM
  `stores`
  RIGHT OUTER JOIN `poll_details` ON (`stores`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`publicity_id` = '".$publicity_id."' AND
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `stores`.`test` = 0 ".$opcionesSi."
GROUP BY
  `poll_details`.`store_id`,
  `poll_details`.`publicity_id`,
  `poll_details`.`poll_id`";
        $consulta=\DB::select($sql);//dd($consulta);
        $totalSi = count($consulta);
        $sql = "SELECT
  `poll_details`.`store_id`
FROM
  `stores`
  RIGHT OUTER JOIN `poll_details` ON (`stores`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`publicity_id` = '".$publicity_id."' AND
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `stores`.`test` = 0 ".$opcionesNo."
GROUP BY
  `poll_details`.`store_id`,
  `poll_details`.`publicity_id`,
  `poll_details`.`poll_id`";
        $consulta=\DB::select($sql);//dd($consulta);
        $totalNo = count($consulta);
        $result = array('si' => $totalSi,'no'=>$totalNo);


        return $result;
    }

    public function getDetailSiNoPublicity($poll_id,$publicity_id,$result=0,$city="0",$dex="0",$tipoBodega="0")
    {
        if (is_numeric($city)) {
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case ($city <> "0") and ($dex <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0") and ($dex<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($tipoBodega<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0") and ($tipoBodega<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.tipo_bodega', $tipoBodega)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($dex <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $city)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city <> "0") and ($dex == "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.ubigeo', $city)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case ($city == "0" and $dex <> "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->where('stores.distributor', $dex)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city == "0") and ($dex == "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.cadenaRuc','stores.type','stores.tipo_bodega','stores.distributor','stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.publicity_id', $publicity_id)->where('poll_details.result', $result)->where('stores.test', 0)->orderBy('poll_details.created_at', 'desc')->get();
                break;
        }//dd($detailResult);
        return $detailResult;
    }

    public function getTotalLimites($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        $toda = explode('Toda ',$city);//dd($toda);
        $valPoll_id=694;
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
            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro =="0"):
                if (($poll_id==13) or ($poll_id==$valPoll_id)){
                    $total1 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->count();
                    $total2 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->count();
                    $total3 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->count();
                    $total4 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->count();
                    $total5 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->count();
                }else{
                    $total1 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->count();
                    $total2 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'Estándar')->count();
                    $total3 = \DB::table('poll_details')->where('poll_id', $poll_id)->where('limite', 'Superior')->count();
                }
                break;
            case ($city == "0") and ($district == "0") and ($ejecutivo == "0") and ($rubro <> "0"):
                $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('poll_option_details.poll_option_id', $rubro)->count();
                $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $rubro)->count();
                $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $rubro)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                if (($poll_id==13) or ($poll_id==$valPoll_id)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                }else{
                    if (is_numeric($city)){
                        if ($city == 5) {
                            $subSql = "`s`.`ubigeo`<>'".$ciudadB."' AND";
                        }else{
                            $subSql = "`s`.`ubigeo`='".$ciudadB."' AND";
                        }
                    }else{
                        $subSql = "`s`.`region`='".$city."' AND";
                    }
                    $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Debajo del estándar' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Debajo del estándar' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                    $consulta=\DB::select($total);
                    $total1=0;
                    if (count($consulta)==0){
                        $total1=0;
                    }else{
                        foreach ($consulta as $reg)
                        {
                            if ($reg->cantidad>1)
                            {
                                $total1 = $total1 +1;
                            }
                        }
                    }

                    $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Estándar' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Estándar' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                    $consulta=\DB::select($total);
                    $total2=0;
                    if (count($consulta)==0){
                        $total2=0;
                    }else{
                        foreach ($consulta as $reg)
                        {
                            if ($reg->cantidad>1)
                            {
                                $total2 = $total2 +1;
                            }
                        }
                    }

                    $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Superior' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `s`.`ejecutivo` = '".$ejecutivo."' AND
  `poll_details`.`limite` = 'Superior' AND ".$subSql."
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                    $consulta=\DB::select($total);
                    $total3=0;
                    if (count($consulta)==0){
                        $total3=0;
                    }else{
                        foreach ($consulta as $reg)
                        {
                            if ($reg->cantidad>1)
                            {
                                $total3 = $total3 +1;
                            }
                        }
                    }

                }

                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo<>"0"):
                if (($poll_id==13) or ($poll_id==$valPoll_id)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    /*$total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();*/
                }

                break;
            case ($district <> "0" and $rubro <> "0"):

                $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Debajo del estándar' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Debajo del estándar' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total);
                $total1=0;
                if (count($consulta)==0){
                    $total1=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $total1 = $total1 +1;
                        }
                    }
                }

                $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Estándar' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Estándar' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total);
                $total2=0;
                if (count($consulta)==0){
                    $total2=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $total2 = $total2 +1;
                        }
                    }
                }

                $total ="SELECT a.store_id , count(*) as cantidad
FROM ((SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Superior' AND
  `poll_option_details`.`poll_option_id` = '".$district."')

UNION ALL

(SELECT
  `s`.`id` as store_id
FROM
  `poll_option_details`
  INNER JOIN `stores` `s` ON (`poll_option_details`.`store_id` = `s`.`id`)
  INNER JOIN `poll_details` ON (`s`.`id` = `poll_details`.`store_id`)
WHERE
  `poll_details`.`poll_id` = '".$poll_id."' AND
  `s`.`test` = 0 AND
  `poll_details`.`limite` = 'Superior' AND
  `poll_option_details`.`poll_option_id` = '".$rubro."'))  a
GROUP BY a.store_id";
                $consulta=\DB::select($total);
                $total3=0;
                if (count($consulta)==0){
                    $total3=0;
                }else{
                    foreach ($consulta as $reg)
                    {
                        if ($reg->cantidad>1)
                        {
                            $total3 = $total3 +1;
                        }
                    }
                }
                break;

            case ($city == "0" and $district <> "0"):
                $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $district)->count();
                $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $district)->count();
                $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $district)->count();

                break;

            case ($city <> "0" and $district <> "0"):
                if (($poll_id==13) or ($poll_id==$valPoll_id)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->count();
                }else{
                    if (is_numeric($city)) {
                        if ($city == 5) {
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo','<>', $ciudadB)->count();
                        }else{
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo', $ciudadB)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo', $ciudadB)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $district)->where('stores.ubigeo', $ciudadB)->count();
                        }
                    }else{
                        $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->count();
                        $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->count();
                        $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $district)->where('stores.region', $city)->count();
                    }
                }

                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)) {
                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();

                            /*$total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();*/
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();

                            /*$total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();*/
                        }
                    }
                }else{
                    if (($poll_id==13) or ($poll_id==$valPoll_id)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $rubro)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();

                        /*$total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();*/
                    }
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)) {

                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                        }else{
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Debajo del estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Estándar')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite', 'Superior')->where('poll_option_details.poll_option_id', $rubro)->where('stores.ubigeo','<>', $ciudadB)->count();

                            /*$total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.ubigeo', '<>',$ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();*/
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                        }else{
                            $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                            $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.ubigeo', $ciudadB)->where('poll_option_details.poll_option_id', $rubro)->count();
                        }
                    }

                }else{
                    if (($poll_id==13) or ($poll_id==$valPoll_id)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                    }else{
                        $total1 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Debajo del estándar')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $total2 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Estándar')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                        $total3 = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->join('poll_details','stores.id','=','poll_details.store_id')->where('poll_details.poll_id', $poll_id)->where('poll_details.limite','Superior')->where('stores.region', $city)->where('poll_option_details.poll_option_id', $rubro)->count();
                    }
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)) {

                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }
                }else{
                    if (($poll_id==13) or ($poll_id==$valPoll_id)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }
                break;
            case $city <> "0":
                if (is_numeric($city)) {

                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->count();

                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo','<>', $ciudadB)->count();
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==$valPoll_id)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->count();

                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo', $ciudadB)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo', $ciudadB)->count();
                        }
                    }

                }else{
                    if (($poll_id==13) or ($poll_id==$valPoll_id)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->count();

                    }else{
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->count();
                    }
                }


                break;
        }

        if (($poll_id==13) or ($poll_id==$valPoll_id)){
            $result = array('Muy_Lento' => $total3,'Lento'=>$total4,'Normal'=>$total2,'Rapida'=>$total1,'Muy_rapido'=>$total5);
        }else{
            $result = array('deb' => $total1,'est'=>$total2,'sup'=>$total3);
        }

        return $result;
    }

} 
<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollDetail;


class PollDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PollDetail;
    }

    public function getIndicatorForIdPoll($poll_id)
    {
        $indicators = \DB::table('poll_details')->select('sino', 'options','limits','media','coment')->where('poll_id', $poll_id)->first();
        //dd($indicators);
        return $indicators;
    }

    public function getTotalPollsStore($store_id)
    {
        $total = \DB::table('poll_details')->where('store_id', $store_id)->groupBy('poll_id')->count();
        //dd($indicators);
        return $total;
    }

    public function getDetailSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0)
    {
        if (is_numeric($city)) {
            if ($city == 1) {
                $ciudadB = "Lima";
            }
            if ($city == 2) {
                $ciudadB = "Arequipa";
            }
            if ($city == 3) {
                $ciudadB = "Ica";
            }
            if ($city == 4) {
                $ciudadB = "Trujillo";
            }
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case $city=="0":
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0" and $district <> "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result',$result)->where('stores.region', $city)->where('stores.district', $district)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.ubigeo', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_details.comentario','poll_details.created_at')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', $result)->where('stores.region', $city)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
        }
        return $detailResult;
    }

    public function getTotalSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0")
    {
        if (is_numeric($city)) {
            if ($city == 1) {
                $ciudadB = "Lima";
            }
            if ($city == 2) {
                $ciudadB = "Arequipa";
            }
            if ($city == 3) {
                $ciudadB = "Ica";
            }
            if ($city == 4) {
                $ciudadB = "Trujillo";
            }
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
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
            case $city == "0":
                $totalSi = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 1)->count();
                $totalNo = \DB::table('poll_details')->where('poll_id', $poll_id)->where('result', 0)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($city <> "0" and $district <> "0"):
                $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.district', $district)->count();
                $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.district', $district)->count();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                }


                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                }


                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }


                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo','<>', $ciudadB)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.ubigeo', $ciudadB)->count();
                        $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalSi = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 1)->where('stores.region', $city)->count();
                    $totalNo = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_details.poll_id', $poll_id)->where('poll_details.result', 0)->where('stores.region', $city)->count();
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

    public function getTotalLimites($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        if (is_numeric($city)) {
            if ($city == 1) {
                $ciudadB = "Lima";
            }
            if ($city == 2) {
                $ciudadB = "Arequipa";
            }
            if ($city == 3) {
                $ciudadB = "Ica";
            }
            if ($city == 4) {
                $ciudadB = "Trujillo";
            }
            if ($city == 5) {
                $ciudadB = "Lima";
            }
        }
        switch (true) {
            case $city == "0":
                if (($poll_id==13) or ($poll_id==53)){
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
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                if (($poll_id==13) or ($poll_id==53)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                }else{
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                }

                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo<>"0"):
                if (($poll_id==13) or ($poll_id==53)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                }else{
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case ($city <> "0" and $district <> "0"):
                if (($poll_id==13) or ($poll_id==53)){
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.district', $district)->count();
                }else{
                    $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.district', $district)->count();
                    $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.district', $district)->count();
                }

                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)) {
                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==53)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==53)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        }
                    }
                }else{
                    if (($poll_id==13) or ($poll_id==53)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)) {

                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==53)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo', '<>',$ciudadB)->where('stores.rubro', $rubro)->count();
                        }
                    }else{
                        if (($poll_id==13) or ($poll_id==53)){
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                        }else{
                            $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                            $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                        }
                    }

                }else{
                    if (($poll_id==13) or ($poll_id==53)){
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','LIKE','%Rapida%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Normal%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total4 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Lento%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total5 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite', 'LIKE','%Muy rapido%')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                    }else{
                        $total1 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Debajo del estándar')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total2 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Estándar')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                        $total3 = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->where('poll_id', $poll_id)->where('limite','Superior')->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                    }
                }
                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)) {

                    if ($city == 5) {
                        if (($poll_id==13) or ($poll_id==53)){
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
                        if (($poll_id==13) or ($poll_id==53)){
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
                    if (($poll_id==13) or ($poll_id==53)){
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
                        if (($poll_id==13) or ($poll_id==53)){
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
                        if (($poll_id==13) or ($poll_id==53)){
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
                    if (($poll_id==13) or ($poll_id==53)){
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

        if (($poll_id==13) or ($poll_id==53)){
            $result = array('Muy_Lento' => $total3,'Lento'=>$total4,'Normal'=>$total2,'Rapida'=>$total1,'Muy_rapido'=>$total5);
        }else{
            $result = array('deb' => $total1,'est'=>$total2,'sup'=>$total3);
        }

        return $result;
    }

} 
<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollOptionDetail;


class PollOptionDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PollOptionDetail;
    }

    public function getOptionsOther($poll_option_id)
    {
        $pollOptionDetails = \DB::table('poll_option_details')->select('otro')->where('poll_option_details.poll_option_id', $poll_option_id)->groupBy('otro')->get();
        return $pollOptionDetails;
    }

    public function getTotalOptionOther($poll_option_id,$other,$city="0",$district="0",$ejecutivo="0",$rubro="0")
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
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('otro', $other)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                break;
            case ($city<>"0") and ($district<>"0") and ($ejecutivo<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($city <> "0" and $district <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.district', $district)->count();
                break;
            case ($city<>"0") and ($rubro<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case ($city <> "0" and $rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                }

                break;
            case ($city <> "0" and $ejecutivo <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.ubigeo', $ciudadB)->count();
                    }
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('otro', $other)->where('stores.region', $city)->count();
                }

                break;
        }
        return $totalOptions;
    }

    public function getTotalOption($poll_option_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0")
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
            case $store_id <> "0":
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->where('store_id', $store_id)->count();
                break;
            case $city == "0":
                $totalOptions = PollOptionDetail::where('poll_option_id', $poll_option_id)->count();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->count();
                break;
            case ($city<>"0") and ($district<>"0") and ($ejecutivo<>"0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->count();
                break;
            case ($city <> "0" and $district <> "0"):
                $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.district', $district)->count();
                break;
            case ($city<>"0") and ($rubro<>"0") and ($ejecutivo<>"0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                    }
                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.rubro', $rubro)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case ($city <> "0" and $rubro <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.rubro', $rubro)->count();
                }

                break;
            case ($city <> "0" and $ejecutivo <> "0"):
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->count();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo','<>', $ciudadB)->count();
                    }else{
                        $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.ubigeo', $ciudadB)->count();
                    }

                }else{
                    $totalOptions = \DB::table('poll_option_details')->join('stores','poll_option_details.store_id','=','stores.id')->where('poll_option_details.poll_option_id', $poll_option_id)->where('stores.region', $city)->count();
                }

                break;
        }


        return $totalOptions;
    }

    public function getDetailOption($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0)
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
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($district <> "0") and ($ejecutivo <> "0") and ($rubro<>"0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case (($city <> "0") and ($district <> "0") and ($ejecutivo <> "0")):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.district', $district)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0" and $district <> "0"):
                $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.district', $district)->orderBy('poll_details.created_at', 'desc')->get();
                break;
            case ($city <> "0") and ($ejecutivo <> "0") and ($rubro <> "0"):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }
                break;
            case (($city <> "0") and ($rubro <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo', $ciudadB)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->where('poll_details.result', $result)->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.rubro', $rubro)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case (($city <> "0") and ($ejecutivo <> "0")):
                if (is_numeric($city)){

                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo','<>', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo', $ciudadB)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->where('stores.ejecutivo', $ejecutivo)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
            case $city <> "0":
                if (is_numeric($city)){
                    if ($city == 5) {
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo','<>', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }else{
                        $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.ubigeo', $ciudadB)->orderBy('poll_details.created_at', 'desc')->get();
                    }

                }else{
                    $detailResult = \DB::table('poll_details')->join('stores','poll_details.store_id','=','stores.id')->join('poll_option_details','poll_option_details.store_id','=','stores.id')->join('poll_options','poll_options.id','=','poll_option_details.poll_option_id')->select('stores.id', 'stores.codclient','stores.fullname','stores.ubigeo','stores.region','stores.district','poll_options.options','poll_details.comentario','poll_details.created_at')->where('poll_details.result', $result)->where('poll_option_details.result', "1")->where('poll_options.poll_id', $poll_id)->where('poll_details.poll_id', $poll_id)->where('stores.region', $city)->orderBy('poll_details.created_at', 'desc')->get();
                }

                break;
        }
        return $detailResult;
    }

} 
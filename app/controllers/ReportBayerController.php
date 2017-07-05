<?php

use Auditor\Repositories\PresenceRepo;
use Auditor\Repositories\PresenceDetailRepo;
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\PublicityRepo;
use Auditor\Repositories\UserRepo;

use Auditor\Repositories\PollRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\ProductRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\ScoreRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\RoadRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\ProductDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\VisitorRepo;


class ReportBayerController extends BaseController{

    protected $PresenceRepo;
    protected $PresenceDetailRepo;
    protected $UserCompanyRepo;
    protected $PublicitiesDetailRepo;
    protected $MediaRepo;
    protected $categoryProductRepo;
    protected $publicityRepo;
    protected $userRepo;

    protected $PollRepo;
    protected $PollDetailRepo;
    protected $ProductRepo;
    protected $CompanyAuditRepo;
    protected $ScoreRepo;
    protected $StoreRepo;
    protected $roadRepo;
    protected $roadDetailRepo;
    protected $companyStoreRepo;
    protected $auditRoadStoreRepo;
    protected $companyRepo;
    protected $customerRepo;
    protected $productDetailRepo;
    protected $PollOptionRepo;
    protected $PollOptionDetailRepo;
    protected $visitorRepo;

    public $urlBase;
    public $urlImagesPublicities;
    public $urlImagesProducts;
    public $urlImages;
    public $urlImageBase;
    public $pollArray;
    public $estudio;


    public function __construct(UserRepo $userRepo,PollOptionDetailRepo $PollOptionDetailRepo,PollOptionRepo $PollOptionRepo,ProductDetailRepo $productDetailRepo,AuditRoadStoreRepo $auditRoadStoreRepo,CompanyStoreRepo $companyStoreRepo, RoadDetailRepo $roadDetailRepo,RoadRepo $roadRepo,ScoreRepo $ScoreRepo,CompanyAuditRepo $CompanyAuditRepo,PollRepo $PollRepo,ProductRepo $ProductRepo,PollDetailRepo $PollDetailRepo,PublicityRepo $publicityRepo, CategoryProductRepo $categoryProductRepo,CustomerRepo $customerRepo,CompanyRepo $companyRepo,MediaRepo $MediaRepo,PublicitiesDetailRepo $PublicitiesDetailRepo,StoreRepo $StoreRepo, UserCompanyRepo $UserCompanyRepo, PresenceDetailRepo $PresenceDetailRepo, PresenceRepo $PresenceRepo, VisitorRepo $visitorRepo)
    {
        $this->PresenceRepo = $PresenceRepo;
        $this->PresenceDetailRepo = $PresenceDetailRepo;
        $this->UserCompanyRepo = $UserCompanyRepo;
        $this->StoreRepo = $StoreRepo;
        $this->PublicitiesDetailRepo = $PublicitiesDetailRepo;
        $this->MediaRepo = $MediaRepo;
        $this->publicityRepo = $publicityRepo;
        $this->categoryProductRepo = $categoryProductRepo;
        $this->userRepo = $userRepo;
        $this->visitorRepo= $visitorRepo;

        $this->PollRepo = $PollRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->ProductRepo = $ProductRepo;
        $this->CompanyAuditRepo = $CompanyAuditRepo;
        $this->ScoreRepo = $ScoreRepo;
        $this->roadRepo = $roadRepo;
        $this->roadDetailRepo = $roadDetailRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->auditRoadStoreRepo = $auditRoadStoreRepo;
        $this->companyRepo = $companyRepo;
        $this->customerRepo = $customerRepo;
        $this->productDetailRepo = $productDetailRepo;
        $this->PollOptionRepo = $PollOptionRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
        $this->urlImagesProducts = '/media/images/bayer/products/';
        $this->pollArray[9] = array('abierto' => 103,'recomendo' => 71, 'exhibicion' => 0,'queRecomendo' => 0);
        $this->pollArray[11] = array('abierto' => 106,'recomendo' => 108, 'exhibicion' => 107,'queRecomendo' => 109);
        $this->pollArray[13] = array('abierto' => 142,'recomendo' => 144, 'exhibicion' => 143,'queRecomendo' => 145);
        $this->pollArray[16] = array('abierto' => 151,'recomendo' => 153, 'exhibicion' => 152,'queRecomendo' => 154);
        $this->pollArray[17] = array('abierto' => 194,'recomendo' => 196, 'exhibicion' => 195,'queRecomendo' => 197);
        $this->pollArray[19] = array('abierto' => 206,'recomendo' => 208, 'exhibicion' => 207,'queRecomendo' => 209,'seRecomendo' => 208,'premio' => 211,'tieneStock' => 210);
        $this->pollArray[30] = array('abierto' => 432,'recomendo' => 434, 'exhibicion' => 433,'queRecomendo' => 435,'seRecomendo' => 434,'premio' => 437,'tieneStock' => 436,'tipoPremio' => 438,'laboratorio' => 439,'tiempo' => 440,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[33] = array('abierto' => 441,'recomendo' => 443, 'exhibicion' => 442,'queRecomendo' => 444,'seRecomendo' => 443,'premio' => 446,'tieneStock' => 445,'tipoPremio' => 447,'laboratorio' => 448,'tiempo' => 449,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[35] = array('abierto' => 481,'recomendo' => 483, 'exhibicion' => 482,'queRecomendo' => 484,'seRecomendo' => 483,'premio' => 486,'tieneStock' => 485,'tipoPremio' => 487,'laboratorio' => 488,'tiempo' => 489,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[39] = array('abierto' => 518,'recomendo' => 520, 'exhibicion' => 519,'queRecomendo' => 521,'seRecomendo' => 520,'premio' => 523,'tieneStock' => 522,'tipoPremio' => 524,'laboratorio' => 525,'tiempo' => 526,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[41] = array('abierto' => 556,'recomendo' => 558, 'exhibicion' => 557,'queRecomendo' => 559,'seRecomendo' => 558,'premio' => 561,'tieneStock' => 560,'tipoPremio' => 562,'laboratorio' => 525,'tiempo' => 526,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[44] = array('abierto' => 573,'recomendo' => 575, 'exhibicion' => 574,'queRecomendo' => 576,'seRecomendo' => 575,'premio' => 578,'tieneStock' => 577,'tipoPremio' => 579,'laboratorio' => 525,'tiempo' => 526,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[60] = array('abierto' => 847,'recomendo' => 849, 'exhibicion' => 848,'queRecomendo' => 850,'seRecomendo' => 849,'premio' => 852,'tieneStock' => 851,'tipoPremio' => 853,'laboratorio' => 525,'tiempo' => 526,'variable' => 853,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[65] = array('abierto' => 939,'recomendo' => 941, 'exhibicion' => 940,'queRecomendo' => 942,'seRecomendo' => 941,'premio' => 944,'tieneStock' => 943,'tipoPremio' => 945,'laboratorio' => 525,'tiempo' => 526,'variable' => 945,'seleccionar' => 946,'semana' => 947,'horario' => 948,'orientacion' => 949,'sugerencias' => 950);
        $this->pollArray[70] = array('abierto' => 1019,'recomendo' => 1021, 'exhibicion' => 1020,'queRecomendo' => 1022,'seRecomendo' => 1021,'premio' => 1024,'tieneStock' => 1023,'tipoPremio' => 1025,'laboratorio' => 525,'tiempo' => 526,'variable' => 1025,'seleccionar' => 1026,'semana' => 1027,'horario' => 1028,'orientacion' => 1029,'sugerencias' => 1030);
        $this->pollArray[73] = array('abierto' => 1214,'recomendo' => 1216, 'exhibicion' => 1215,'queRecomendo' => 1217,'seRecomendo' => 1216,'premio' => 1219,'tieneStock' => 1218,'tipoPremio' => 1220,'laboratorio' => 525,'tiempo' => 526,'variable' => 1220,'seleccionar' => 1221,'semana' => 1222,'horario' => 1223,'orientacion' => 1224,'sugerencias' => 1225);
        $this->pollArray[78] = array('abierto' => 1355,'recomendo' => 1357, 'exhibicion' => 1356,'queRecomendo' => 1358,'seRecomendo' => 1357,'premio' => 1360,'tieneStock' => 1359,'tipoPremio' => 1361,'laboratorio' => 525,'tiempo' => 526,'variable' => 1361,'seleccionar' => 1362,'semana' => 1363,'horario' => 1364,'orientacion' => 1365,'sugerencias' => 1366);
        $this->estudio='Mistery';
        $this->saveSessions();
    }

    public function getRoadsForCampaigne($company_id)
    {
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $titulo = $company[0]->fullname;
        $audit_id=0;
        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $menus = $this->generateMenusBayer($company_id,0,1);

        $roads =$this->auditRoadStoreRepo->getRoadsResumeForCompany($company_id);//dd($roads);
        $cliente='Bayer';

        return View::make('report/listRoads',compact('cliente','titulo','logo','menus','roads','audit_id','company_id'));

    }

    public function getDetailRoad($road_id,$company_id)
    {
        $road = $this->roadRepo->find($road_id);
        $roadDetails = $this->roadDetailRepo->getDetailStores($road_id);$auditados=0;
        $menus = $this->generateMenusBayer($company_id,0,1);

        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $titulo = $company[0]->fullname;
        $audit_id=0;
        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;//dd($roadDetails);

        foreach ($roadDetails as  $roadDetail)
        {//dd($roadDetail);
            if($roadDetail->company_id==$company_id){
                $roadDetalles[] = $roadDetail;
                if($roadDetail->audit==1) $auditados ++;
            }
        }
        //dd($roadDetalles);
        return View::make('report/bayer/showRoad',compact('road','roadDetalles','auditados','menus','titulo','audit_id','logo'));
    }

    public function reportHome($company_id="0",$url="0",$cat="0")
    {
        if ($url=="0")
        {
            if ($company_id=="0"){

                $valoresPost= Input::all();//dd($valoresPost);

                if (count($valoresPost)<>0){
                    $ubigeoext = $valoresPost['ubigeo'];
                    $cadena = $valoresPost['cadena'];
                    $horizontal = $valoresPost['horizontal'];
                    $company_id = $valoresPost['company_id'];
                    $ejecutivo = $valoresPost['ejecutivo'];
                    $company = $this->companyRepo->find($company_id);
                    $titulo = $company->fullname;
                }else{
                    $ubigeoext = "0";
                    $cadena = "0";
                    $horizontal = "0";
                    $ejecutivo = "0";
                    $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
                    $company_id=$company[0]->id;//dd($company_id);
                    $titulo = $company[0]->fullname;
                }
            }else{
                $ubigeoext = "0";
                $cadena = "0";
                $horizontal = "0";
                $ejecutivo = "0";
                $company = $this->companyRepo->find($company_id);//dd($company);
                $titulo = $company->fullname;
            }

        }else{
            $ubigeoext = "0";
            $cadena = "0";
            $horizontal = "0";
            $ejecutivo = "0";
            $company = $this->companyRepo->find($company_id);
            $titulo = $company->fullname;
        }
        $audit_id=0;//dd($cadena);
        if (is_array($ubigeoext)){
            $ubigeoextLink="";$c=0;
            foreach ($ubigeoext as $item) {
                $ubigeoextLink .=$item;
                $c = $c+1;
                if (count($ubigeoext) > $c)
                {
                    $ubigeoextLink .="|";
                }
            }
        }else{
            $ubigeoextLink="0";
        }
        if (is_array($cadena)){
            $cadenaLink="";$c=0;
            foreach ($cadena as $item) {
                $cadenaLink .=$item;
                $c = $c+1;
                if (count($cadena) > $c)
                {
                    $cadenaLink .="|";
                }
            }
        }else{
            $cadenaLink="0";
        }
        if (is_array($horizontal)){
            $horizontalLink="";$c=0;
            foreach ($horizontal as $item) {
                $horizontalLink .=$item;
                $c = $c+1;
                if (count($horizontal) > $c)
                {
                    $horizontalLink .="|";
                }
            }
        }else{
            $horizontalLink="0";
        }

        $valores = "0-0-".$ejecutivo."-0-".$ubigeoextLink.'-'.$cadenaLink;

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id,1,"0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id,1,"0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);

        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $campaignesClient = $this->companyRepo->getCompaniesForClient($customer->id,1,$this->estudio);//Para combo de cambio de campañas collection array de objetos Company
        $campaignes = array(0 => "Seleccionar Período") + $campaignesClient->lists('fullname','id');
        $urlBase = $this->urlBase."/reportBayer/";
        //dd($campaignes);

        $ListUbigeos = $this->StoreRepo->getDepartamentForCampaigne($company_id,2);//dd($company_id);
        /*$ubigeo = array(0 => "Seleccionar")+ array('Lima' => "LIMA")+ array(5 => "PROVINCIAS");
        foreach ($ListUbigeos as $kdenas)
        {
            if (key($kdenas) <> 'Lima')
            {
                $ubigeo = $ubigeo + array(key($kdenas)=>$kdenas[key($kdenas)]);
            }
        }*/
        $ListCadenas = $this->StoreRepo->getCadenasForCampaigne($company_id,2);//dd($ListCadenas);

        /*$cadenas = array('0' => "Seleccionar") + array('HORIZONTAL' => "HORIZONTAL") + array('DETALLISTA' => "Detallista") + array('MINI CADENAS' => "Mini Cadenas")+ array('SUB DISTRIBUIDOR' => "Sub Distribuidor") + array('CADENA' => "CADENAS");
        foreach ($ListCadenas as $kdenas)
        {
            $cadenas = $cadenas + array(key($kdenas)=>$kdenas[key($kdenas)]);
        }*/
        //$ListHorizontales[] = "Detallista";$ListHorizontales[] ="Mini Cadenas";$ListHorizontales[] ="Sub Distribuidor";//dd($ListHorizontales);
        $ListHorizontales = $this->StoreRepo->getHorizontalForCampaigne($company_id,2);
        
        $listEjecutivos = $this->StoreRepo->getEjecutivosForCampaigne($company_id);
        $ejecutivos = array(0 => "Seleccionar") +  $listEjecutivos->lists('ejecutivo','ejecutivo');//dd($ubigeo);


        /*$pollArray[9] = array('abierto' => 103,'recomendo' => 71);
        $pollArray[11] = array('abierto' => 106,'recomendo' => 108, 'exhibicion' => 107);*/

        $menus = $this->generateMenusBayer($company_id,$audit_id,$cat);
        $sino=$this->PollDetailRepo->getTotalSiNo($this->pollArray[$company_id]['abierto'],"0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,"0","0",$horizontal);
        //getTotalSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0")
        $totalAbiertos = $sino['si'];//dd($totalAbiertos);

        $valSiNo[0] = array("tipo" => 'Abierto', "cantidad" => $sino['si'], "color" => '#97C74F');
        $valSiNo[1] = array("tipo" => 'Cerrado', "cantidad" => $sino['no'], "color" => '#1AB1E6');
        $valSINOJson =json_encode($valSiNo);unset($valSiNo);


        $ListProducts = $this->productDetailRepo->getProductsForCampaigne($company_id);$c=0;$prodSI=0;$prodNO=0;//dd($ListProducts[0]);
        foreach ($ListProducts as $product)
        {
            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($this->pollArray[$company_id]['recomendo'],"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);

            $totalProd[] = array('prod' => ucwords($product->product->fullname), "si" => $sinoProd1['si'], "no" => $sinoProd1['no']);

        }//dd($totalProd);
        foreach ($totalProd as $prod)
        {
            $c=$c+1;if ($c==1) $color = '#FFFFFF';if ($c==2) $color = '#FFFFFF';if ($c==3) $color = '#FFFFFF';if ($c==4) $color = '#FFFFFF';
            if ($totalAbiertos == 0)
            {
                $valProdSI[] = array("category" => $prod['prod'], 'Si' => 0,'cant_si' => $prod['si'], 'No' => 0, 'cant_no' => $prod['no'], 'color' => "#ffffff");
            }else{
                $valProdSI[] = array("category" => $prod['prod'], 'Si' => round(($prod['si']*100)/$totalAbiertos,0),'cant_si' => $prod['si'], 'No' => round(($prod['no']*100)/$totalAbiertos,0), 'cant_no' => $prod['no'], 'color' => "#ffffff");
            }
        }
        $valProdJson =json_encode($valProdSI);unset($valProdSI);//dd($valProdJson);

        $numPremiados = $this->ScoreRepo->countWinnersBayerProducts($company_id,"0",$ubigeoext,$cadena,$ejecutivo);
        $premiados[0] = array("tipo" => 'Premiados', "cantidad" => $numPremiados, "color" => '#97C74F');
        $premiados[1] = array("tipo" => 'No Premiados', "cantidad" => $totalAbiertos-$numPremiados, "color" => '#1AB1E6');
        $valPremiados =json_encode($premiados);unset($premiados);
        if (($company_id == 11) or ($company_id == 13) or ($company_id == 16)or ($company_id == 17) or ($company_id == 19) or ($company_id == 30) or ($company_id == 33) or ($company_id == 35) or ($company_id == 39) or ($company_id == 41) or ($company_id == 44) or ($company_id == 60) or ($company_id == 65) or ($company_id == 70) or ($company_id == 73) or ($company_id == 78)){
            $sinoE=$this->PollDetailRepo->getTotalSiNo($this->pollArray[$company_id]['exhibicion'],"0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,"0","0",$horizontal);
            $totalExhibicion = $sinoE['si'];$totalNoExhibicion = $sinoE['no'];

            $valExhi[0] = array("tipo" => 'Si', "cantidad" => $sinoE['si'], "color" => '#97C74F');
            $valExhi[1] = array("tipo" => 'No', "cantidad" => $sinoE['no'], "color" => '#1AB1E6');
            $valExhiJson =json_encode($valExhi);unset($valExhi);

            $options= $this->PollOptionRepo->getOptions($this->pollArray[$company_id]['exhibicion']);

            if ($company_id == 19)
            {
                foreach ($options as $option) {
                    $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,$horizontal);
                    if ($totalExhibicion <> 0) {
                        $porcOpcion = ($cantidadOption / $totalExhibicion) * 100;
                    } else {
                        $porcOpcion = 0;
                    }
                    $ValRespuesta = trim($option->options);
                    $totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                }
            }else{
                foreach ($options as $option) {
                    if ($option->product_id>0)
                    {
                        $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,$horizontal);
                        if ($totalExhibicion <> 0) {
                            $porcOpcion = ($cantidadOption / $totalExhibicion) * 100;
                        } else {
                            $porcOpcion = 0;
                        }
                        $ValRespuesta = ucwords(trim($option->options));
                        if ($cantidadOption>0){
                            $totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                        }
                    }
                }
            }
            arsort($totalOptions);//dd($totalOptions);
            foreach ($totalOptions as $totalOptions1) {
                $totalOrdenado[] = array('respuesta' => ucwords($totalOptions1['respuesta']), 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
            }
            $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);$cantidadTotal=0;
            //dd($options[0]);
            if (($company_id<>30) and ($company_id<>33) and ($company_id<>35) and ($company_id<>39) and ($company_id<>41) and ($company_id<>44) and ($company_id<>60) and ($company_id<>65) and ($company_id<>70) and ($company_id<>73) and ($company_id<>78))
            {
                foreach ($options as $option) {
                    if ($option->product_id==0)
                    {
                        $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,$horizontal);
                        if ($totalExhibicion <> 0) {
                            $porcOpcion = ($cantidadOption / $totalNoExhibicion) * 100;
                        } else {
                            $porcOpcion = 0;
                        }
                        $ValRespuesta = ucwords(trim($option->options_abreviado));
                        $totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                    }
                }//dd($totalOptions);
                arsort($totalOptions);
                foreach ($totalOptions as $totalOptions1) {
                    $totalOrdenado[] = array('respuesta' => ucwords($totalOptions1['respuesta']), 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                }
                $totalOptionsJSON1 = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
            }else{
                $totalOptionsJSON1='';
            }


        }

        $aleatorio=rand();
        if ($company_id == 9){
            return View::make('report/inicioHtmlBayer',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','menus','valSINOJson','valProdJson','audit_id','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','company_id','valPremiados'));
        }
        if ($company_id == 11){
            return View::make('report/inicioBayer11',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
        if ($company_id == 13){
            return View::make('report/inicioBayer13',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
        if ($company_id == 16){
            return View::make('report/inicioBayer16',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
        if ($company_id == 17){
            return View::make('report/inicioBayer17',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
        if ($company_id == 19){
            return View::make('report/inicioBayer19',compact('horizontalLink','ejecutivo','ejecutivos','ListHorizontales','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valores','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
        if ($company_id >= 30){
            $valPolls = $this->pollArray;
            //return View::make('report/inicioBayer30',compact('valPolls','ejecutivos','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoext','cadena','valores','ubigeo','cadenas','titulo','logo','menus','valSINOJson','valProdJson','audit_id','valores','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
            return View::make('report/homeBayer',compact('horizontal','cadena','ubigeoext','horizontalLink','ejecutivo','ListHorizontales','valPolls','ejecutivos','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoextLink','cadenaLink','valores','ListUbigeos','ListCadenas','titulo','logo','menus','valSINOJson','valProdJson','audit_id','aleatorio','company_id','valPremiados','valExhiJson','totalOptionsJSON','totalOptionsJSON1'));
        }
    }

    public function auditReportAbstract($audit_id="0",$company_id="0",$subopcion="0")
    {
        $presence_id = "0";
        if ($audit_id=="0")
        {
            $valoresPost= Input::all();

            if (count($valoresPost)<>0){
                $audit_id = $valoresPost['audit_id'];
                $ubigeoext = $valoresPost['ubigeo'];
                $cadena = $valoresPost['cadena'];
                $horizontal = $valoresPost['horizontal'];
                $ejecutivo = $valoresPost['ejecutivo'];
                $company_id = $valoresPost['company_id'];
                $subopcion = $valoresPost['subopcion'];
            }else{
                $ubigeoext = "0";
                $cadena = "0";
                $ejecutivo = "0";
                $horizontal = "0";
            }
        }else{
            $ubigeoext = "0";
            $cadena = "0";
            $horizontal = "0";
            $ejecutivo = "0";
        }
        if (is_array($ubigeoext)){
            $ubigeoextLink="";$c=0;
            foreach ($ubigeoext as $item) {
                $ubigeoextLink .=$item;
                $c = $c+1;
                if (count($ubigeoext) > $c)
                {
                    $ubigeoextLink .="|";
                }
            }
        }else{
            $ubigeoextLink="0";
        }
        if (is_array($cadena)){
            $cadenaLink="";$c=0;
            foreach ($cadena as $item) {
                $cadenaLink .=$item;
                $c = $c+1;
                if (count($cadena) > $c)
                {
                    $cadenaLink .="|";
                }
            }
        }else{
            if ($subopcion=='Moderno'){
                $cadena = $this->StoreRepo->getCadenasForCampaigne($company_id,2);
                $cadenaLink="";$c=0;
                if (count($cadena)>0){
                    foreach ($cadena as $item){
                        $cadenaLink .=$item;
                        $c = $c+1;
                        if (count($cadena) > $c)
                        {
                            $cadenaLink .="|";
                        }
                    }
                }else{
                    $cadenaLink='0';$cadena = "0";
                }

            }else{
                $cadenaLink="0";
            }
        }
        if (is_array($horizontal)){
            $horizontalLink="";$c=0;
            foreach ($horizontal as $item) {
                $horizontalLink .=$item;
                $c = $c+1;
                if (count($horizontal) > $c)
                {
                    $horizontalLink .="|";
                }
            }
        }else{
            if ($subopcion=='Tradicional'){
                $horizontal = $this->StoreRepo->getHorizontalForCampaigne($company_id,2);
                $horizontalLink="";$c=0;
                if (count($horizontal)>0){
                    foreach ($horizontal as $item){
                        $horizontalLink .=$item;
                        $c = $c+1;
                        if (count($horizontal) > $c)
                        {
                            $horizontalLink .="|";
                        }
                    }
                }else{
                    $horizontalLink="0";$horizontal = "0";
                }
            }else{
                $horizontalLink="0";$horizontal = "0";
            }

        }
        $company = $this->companyRepo->find($company_id);//dd($horizontal);
        $titulo = $company->fullname;
        $valCiudad = "0-0-".$ejecutivo."-0-".$ubigeoextLink.'-'.$cadenaLink;

        /*$cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id,1,"0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id,1,"0","0","0",$ejecutivo,"0",$ubigeoext,$cadena,"0","0",$horizontal);*/

        $listEjecutivos = $this->StoreRepo->getEjecutivosForCampaigne($company_id);//dd($listEjecutivos);
        $ejecutivos = array(0 => "Seleccionar") +  $listEjecutivos->lists('ejecutivo','ejecutivo');//dd($ejecutivos);

        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $campaignesClient = $this->companyRepo->getCompaniesForClient($customer->id,1,$this->estudio);//Para combo de cambio de campañas
        $campaignes = array(0 => "Seleccionar Período") + $campaignesClient->lists('fullname','id');//dd($campaignes);
        $urlBase = $this->urlBase."/report/auditsBayer/".$audit_id."/";

        if($subopcion=='Tradicional'){
            $ListCadenas = [];
        }

        if ($subopcion=='Moderno'){
            $ListHorizontales =[];$cat=4;
        }
        if ($subopcion=='Tradicional'){
            $ListHorizontales = $this->StoreRepo->getHorizontalForCampaigne($company_id,2);$cat=5;
            //$ListHorizontales[] = "Detallista";$ListHorizontales[] ="Sub Distribuidor";
        }
        if ($subopcion=='0'){
            $ListHorizontales = $this->StoreRepo->getHorizontalForCampaigne($company_id,2);$cat=0;
            //$ListHorizontales[] = "Detallista";$ListHorizontales[] ="Sub Distribuidor";$cat=0;//$ListHorizontales[] ="Mini Cadenas";
        }

        $menus = $this->generateMenusBayer($company_id,$audit_id,$cat);
        $ListProducts = $this->productDetailRepo->getProductsForCampaigne($company_id);

        $sino=$this->PollDetailRepo->getTotalSiNo($this->pollArray[$company_id]['abierto'],"0","0",$ejecutivo,"0","0","0",$ubigeoext,$cadena,"0","0",$horizontal);
        $totalAbiertos = $sino['si'];


        $ListUbigeos = $this->StoreRepo->getDepartamentForCampaigne($company_id,2);
        if (($subopcion=='0') or ($subopcion=='Moderno')){
            $ListCadenas = $this->StoreRepo->getCadenasForCampaigne($company_id,2);
            if (count($ListCadenas)==0){
                $ListCadenas=[];
            }
        }



        $polls = $this->PollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id));
        if ($company_id==9){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 103) and ($poll->id <> 105))
                    {
                        if ($product->product_id ==534)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);
                            $valores[] = array('product_id' => $product->product_id,'poll' => $poll->question, 'poll_id' => $poll->id, 'grafico' => $valProdJson );
                        }else{
                            if ($poll->id <> 104)
                            {
                                $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);
                                $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                                $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                                $valProdJson =json_encode($valProd);unset($valProd);
                                $valores[] = array('product_id' => $product->product_id,'poll' => $poll->question, 'poll_id' => $poll->id, 'grafico' => $valProdJson );
                            }
                        }
                    }
                }

            }
        }

        if ($company_id==11){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 106) and ($poll->id <> 111) and ($poll->id <> 107))
                    {
                        if ($poll->id <> 109)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);//dd($ubigeoext .' '.$cadena);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';
                        }else{
                            $options= $this->PollOptionRepo->getOptions($poll->id);$valProdJson='';

                            foreach ($options as $option) {
                                if (($option->product_id == $product->product_id) or ($option->product_id==0))
                                {
                                    $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                    if ($totalAbiertos <> 0) {
                                        $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                                    } else {
                                        $porcOpcion = 0;
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                                }
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => $poll->question, 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON);
                    }
                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }//dd($valores);
        }

        if ($company_id==13){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 106 + 36) and ($poll->id <> 111 +36) and ($poll->id <> 107 +36))
                    {
                        if ($poll->id <> 109 +36)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);//dd($ubigeoext .' '.$cadena);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';$totalPriorityJSON='';
                        }else{
                            $options= $this->PollOptionRepo->getOptions($poll->id);$valProdJson='';

                            foreach ($options as $option) {
                                if (($option->product_id == $product->product_id) or ($option->product_id==0))
                                {
                                    $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                    if ($totalAbiertos <> 0) {
                                        $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                                    } else {
                                        $porcOpcion = 0;
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                                }
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            $cantidadOption=0;
                            foreach ($options as $option) {
                                if ($option->product_id == $product->product_id)
                                {
                                    for ($i = 1; $i <= 10; $i++)
                                    {
                                        $cantidadOption = $this->PollOptionDetailRepo->getTotalPriority($company_id,$i,$option->codigo, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                        if ($i==1){
                                            $valor1 = $cantidadOption;
                                        }
                                        if ($i==2){
                                            $valor2 = $cantidadOption;
                                        }
                                        if ($i==3){
                                            $valor3 = $cantidadOption;
                                        }
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array("tipo" => $ValRespuesta, "Prioridad 1" => $valor1, "Prioridad 2" => $valor2, "Prioridad 3" => $valor3);
                                }
                            }//dd($totalOptions);
                            $totalPriorityJSON = json_encode($totalOptions);unset($totalOptions);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => $poll->question, 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON, 'graficoPriority' => $totalPriorityJSON);
                    }
                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }//dd($valores);
        }

        if ($company_id==16){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 151) and ($poll->id <> 156) and ($poll->id <> 152) and ($poll->id <> 157) and ($poll->id <> 158) and ($poll->id <> 159) and ($poll->id <> 160) and ($poll->id <> 161) and ($poll->id <> 162))
                    {
                        if ($poll->id <> 154)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);//dd($ubigeoext .' '.$cadena);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';$totalPriorityJSON='';
                        }else{
                            $options= $this->PollOptionRepo->getOptions($poll->id);$valProdJson='';//dd($options[0]);

                            foreach ($options as $option) {
                                if (($option->product_id == $product->product_id) or ($option->product_id==0))
                                {
                                    $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                    if ($totalAbiertos <> 0) {
                                        $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                                    } else {
                                        $porcOpcion = 0;
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                                }
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            $cantidadOption=0;
                            foreach ($options as $option) {
                                if ($option->product_id == $product->product_id)
                                {
                                    $totalopciones =0;
                                    for ($i = 1; $i <= 10; $i++)
                                    {
                                        $cantidadOption = $this->PollOptionDetailRepo->getTotalPriority($company_id,$i,$option->codigo, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                        if ($i==1){
                                            $valor1 = $cantidadOption;$totalopciones = $totalopciones +$valor1;
                                        }
                                        if ($i==2){
                                            $valor2 = $cantidadOption;$totalopciones = $totalopciones +$valor2;
                                        }
                                        if ($i==3){
                                            $valor3 = $cantidadOption;$totalopciones = $totalopciones +$valor3;
                                        }
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array("tipo" => $ValRespuesta."[".$totalopciones."]", "Prioridad 1" => $valor1, "Prioridad 2" => $valor2, "Prioridad 3" => $valor3);
                                }
                            }//dd($totalOptions);
                            $totalPriorityJSON = json_encode($totalOptions);unset($totalOptions);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => $poll->question, 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON, 'graficoPriority' => $totalPriorityJSON);
                    }
                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }//dd($valores);
        }

        if ($company_id==17){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 194) and ($poll->id <> 199) and ($poll->id <> 195) and ($poll->id <> 200) )
                    {
                        if ($poll->id <> 197)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);//dd($ubigeoext .' '.$cadena);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';$totalPriorityJSON='';
                        }else{
                            $options= $this->PollOptionRepo->getOptions($poll->id);$valProdJson='';//dd($options[0]);

                            foreach ($options as $option) {
                                if (($option->product_id == $product->product_id) or ($option->product_id==0))
                                {
                                    $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                    if ($totalAbiertos <> 0) {
                                        $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                                    } else {
                                        $porcOpcion = 0;
                                    }
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta,  "porcentaje" => round($porcOpcion, 0));
                                }
                            }
                            arsort($totalOptions);//dd($totalOptions);
                            foreach ($totalOptions as $totalOptions1) {
                                $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                            }
                            $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

                            $cantidadOption=0;
                            foreach ($options as $option) {
                                if ($option->product_id == $product->product_id)
                                {
                                    $totalopciones =0;
                                    for ($i = 1; $i <= 10; $i++)
                                    {
                                        $cantidadOption = $this->PollOptionDetailRepo->getTotalPriority($company_id,$i,$option->codigo, "0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,$horizontal);
                                        if ($i==1){
                                            $valor1 = $cantidadOption;$totalopciones = $totalopciones +$valor1;
                                        }
                                        if ($i==2){
                                            $valor2 = $cantidadOption;$totalopciones = $totalopciones +$valor2;
                                        }
                                        if ($i==3){
                                            $valor3 = $cantidadOption;$totalopciones = $totalopciones +$valor3;
                                        }
                                    }$sumaopciones = $valor1 + $valor2 + $valor3;
                                    $ValRespuesta = trim($option->options);
                                    $totalOptions[] = array("total" => $sumaopciones,"tipo" => $ValRespuesta."[".$totalopciones."]", "Prioridad 1" => $valor1, "Prioridad 2" => $valor2, "Prioridad 3" => $valor3);
                                }
                            }
                            arsort($totalOptions);//dd($totalOptions);
                            foreach ($totalOptions as $totalOptions1) {
                                $totalOrdenado[] = array("tipo" => $totalOptions1['tipo'], "Prioridad 1" => $totalOptions1['Prioridad 1'], "Prioridad 2" => $totalOptions1['Prioridad 2'], "Prioridad 3" => $totalOptions1['Prioridad 3']);
                            }
                            $totalPriorityJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => $poll->question, 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON, 'graficoPriority' => $totalPriorityJSON);
                    }
                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }//dd($valores);
        }

        if ($company_id==19){
            foreach ($ListProducts as $product)
            {//dd($product);
                foreach ($polls as $poll)
                {
                    if (($poll->id <> 206) and ($poll->id <> 211) and ($poll->id <> 207) and ($poll->id <> 212) and ($poll->id <> 213) and ($poll->id <> 214) and ($poll->id <> 215) and ($poll->id <> 216) )
                    {
                        if ($poll->id <> 209)
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);//dd($ubigeoext .' '.$cadena);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';$totalPriorityJSON='';
                        }else{
                           
                            $totalOrdenado = $this->getTotalOptionForPollId($poll->id,$totalAbiertos,$product->product_id,$ejecutivo,$ubigeoext,$cadena,"0",$horizontal);
                            $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

                            $totalOrdenado = $this->getTotalPriorityForPollId($poll->id,$company_id,$product->product_id,$ejecutivo,$ubigeoext,$cadena,$horizontal);
                            $totalPriorityJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => $poll->question, 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON, 'graficoPriority' => $totalPriorityJSON);
                    }
                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }//dd($valores);
        }
        if ($company_id>=30){
            foreach ($ListProducts as $product)
            {
                foreach ($polls as $poll)
                {
                    if (($poll->id <> $this->pollArray[$company_id]['abierto']) and ($poll->id <> $this->pollArray[$company_id]['premio']) and ($poll->id <> $this->pollArray[$company_id]['exhibicion'])  and ($poll->id <> $this->pollArray[$company_id]['tipoPremio']) and ($poll->id <> $this->pollArray[$company_id]['laboratorio']) and ($poll->id <> $this->pollArray[$company_id]['tiempo']) and ($poll->id <> $this->pollArray[$company_id]['variable']) and ($poll->id <> $this->pollArray[$company_id]['seleccionar']) and ($poll->id <> $this->pollArray[$company_id]['semana']) and ($poll->id <> $this->pollArray[$company_id]['horario']) and ($poll->id <> $this->pollArray[$company_id]['orientacion']) and ($poll->id <> $this->pollArray[$company_id]['sugerencias']))
                    {
                        if ($poll->id <> $this->pollArray[$company_id]['queRecomendo'])
                        {
                            $sinoProd1=$this->PollDetailRepo->getTotalSiNo($poll->id,"0","0",$ejecutivo,"0","0",$product->product_id,$ubigeoext,$cadena,"0","0",$horizontal);
                            $valProd[0] = array("tipo" => 'Si', "cantidad" => $sinoProd1['si'], "color" => '#1A8EC7');
                            $valProd[1] = array("tipo" => 'No', "cantidad" => $sinoProd1['no'], "color" => '#1AB1E6');
                            $valProdJson =json_encode($valProd);unset($valProd);$totalOptionsJSON='';$totalPriorityJSON='';
                        }else{

                            /*$totalOrdenado = $this->getTotalOptionForPollId($poll->id,$totalAbiertos,$product->product_id,$ejecutivo,$ubigeoext,$cadena);
                            $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);*/
                            $totalOrdenado = [];
                            $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

                            //$totalOrdenado = $this->getTotalPriorityForPollId($poll->id,$company_id,$product->product_id,$ejecutivo,$ubigeoext,$cadena);
                            $totalOrdenado = [];
                            $totalPriorityJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
                        }
                        $pregunta[] = array('poll_id' => $poll->id, 'poll' => ucwords($poll->question), 'grafico' => $valProdJson, 'graficoOptions' => $totalOptionsJSON, 'graficoPriority' => $totalPriorityJSON);
                    }

                }

                $valores[$product->product_id] = $pregunta;unset($pregunta);
            }

        }

        $urlProducts = $this->urlBase.$this->urlImagesProducts;//dd($valores);
        if ($company_id==9)
        {
            return View::make('report/bayer/auditBayerProductsPoll',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','campaignes','valCiudad','logo','titulo','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores'));
        }

        if ($company_id==11)
        {
            return View::make('report/bayer/auditBayer11',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','titulo','ubigeoextLink','ListUbigeos','campaignes','ListCadenas','cadenaLink','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }

        if ($company_id==13)
        {
            return View::make('report/bayer/auditBayer13',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','campaignes','logo','titulo','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }

        if ($company_id==16)
        {
            return View::make('report/bayer/auditBayer16',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','campaignes','logo','titulo','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }

        if ($company_id==17)
        {
            return View::make('report/bayer/auditBayer17',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','campaignes','logo','titulo','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }

        if ($company_id==19)
        {
            return View::make('report/bayer/auditBayer19',compact('horizontalLink','ListHorizontales','ejecutivos','ejecutivo','urlBase','campaignes','logo','titulo','ubigeoextLink','ListUbigeos','ListCadenas','cadenaLink','valCiudad','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }
        if ($company_id>=30)
        {
            $valPolls = $this->pollArray;//dd($ubigeoext);
            //return View::make('report/bayer/auditBayer30Ajax',compact('ListHorizontales','ejecutivo','totalAbiertos','valPolls','ejecutivos','urlBase','campaignes','logo','titulo','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','ubigeoext','cadena','valCiudad','ListUbigeos','ListCadenas','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
            return View::make('report/bayer/auditsBayerInterno',compact('horizontal','cadena','ubigeoext','subopcion','horizontalLink','ListHorizontales','ejecutivo','totalAbiertos','valPolls','ejecutivos','urlBase','campaignes','logo','titulo','auditsBayerInterno','ubigeoextLink','cadenaLink','valCiudad','ListUbigeos','ListCadenas','menus','audit_id','company_id','ListProducts','urlProducts','valores','valorOptions'));
        }

    }

    
    
    public function homeComparationSellerCampaigns($company_id="0",$product_id="0",$cadena="0",$horizontal="0")
    {
        $sw=0;
        if ($company_id=="0")
        {
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $cadena = $valoresPost['cadena'];
            if ($valoresPost['product'] == 0){
                $sw=0;
                $product_id =534;
            }else{
                $sw=1;
                $product_id = $valoresPost['product'];
            }
            $horizontal= $valoresPost['horizontal'];
        }
        if (is_array($cadena)){
            $cadenaLink="";$c=0;
            foreach ($cadena as $item) {
                $cadenaLink .=$item;
                $c = $c+1;
                if (count($cadena) > $c)
                {
                    $cadenaLink .="|";
                }
            }
        }else{
            $cadenaLink="0";
        }
        if (is_array($horizontal)){
            $horizontalLink="";$c=0;
            foreach ($horizontal as $item) {
                $horizontalLink .=$item;
                $c = $c+1;
                if (count($horizontal) > $c)
                {
                    $horizontalLink .="|";
                }
            }
        }else{
            $horizontalLink="0";
        }
        $producto = $this->ProductRepo->find($product_id);//dd($producto);
        $company = $this->companyRepo->find($company_id);//dd($company);
        $customer =$this->customerRepo->find($company->customer_id);//dd($customer);
        $ejecutivos = $this->userRepo->listUserCustomer($customer->id);$c=0;//dd($ejecutivos);
        //$totalOrdenado = $this->getTotalOptionForPollId($this->pollArray[$company_id]['queRecomendo'],0,$product_id,"Andrea Hopkins","0",$cadena,1);dd($totalOrdenado);
        /*foreach ($ejecutivos as $ejecutivo) {
            if ($ejecutivo->id == 58)
            {
                $totalOrdenado = $this->getTotalOptionForPollId($this->pollArray[$company_id]['queRecomendo'],0,$product_id,$ejecutivo->fullname,"0",$cadena);
                dd($totalOrdenado);
                $totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
            }

        }*/
        if ($sw==1){
            $nombProduct = $producto->fullname;
        }else{
            $nombProduct = "0";
        }

        $titulo = 'Resumen Ejecutivos Bayer - Producto '.$producto->fullname;$audit_id=0;
        $subtitulo = "Recomendación ".$producto->fullname;
        $menus = $this->generateMenusBayer($company_id,$audit_id,2);

        /*$cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0",$cadena);
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id,1,"0","0","0","0","0","0",$cadena);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id,1,"0","0","0","0","0","0",$cadena);*/

        $getCompaignes = $this->companyRepo->getCompaniesForClient($customer->id,"1",$this->estudio);
        foreach ($getCompaignes as $getCompaigne) {
            $arrayCampaines[]= $getCompaigne->id;
        }
        $ListProducts = $this->productDetailRepo->getAllProductsForCampaigne($arrayCampaines);
        $products = array('0' => "Seleccionar") + $ListProducts->lists('fullname','id');

        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $campaignesClient = $this->companyRepo->getCompaniesForClient($customer->id,"1",$this->estudio);//Para combo de cambio de campañas
        $campaignes = array(0 => "Seleccionar Período") + $campaignesClient->lists('fullname','id');
        $urlBase = $this->urlBase."/reportBayer";

        $ListCadenas = $this->StoreRepo->getCadenasForCampaigne($company_id,2);
        $ListHorizontales[] = "Detallista";$ListHorizontales[] ="Mini Cadenas";$ListHorizontales[] ="Sub Distribuidor";
        return View::make('report/bayer/salesBayer',compact('nombProduct','horizontalLink','subtitulo','titulo','logo','cadenaLink','campaignes','urlBase','ListHorizontales','ListCadenas','audit_id','menus','products','ejecutivos','company_id','cadena','product_id'));
    }


    /**
     *Se obtiene el reporte por marcas tanto por get como por post
     */
    public function traderMarkReport($company_id="0",$ejecutivo_id="0",$cadena="0",$horizontal="0",$ubigeoext="0")
    {
        $sw=0;
        if ($company_id=="0")
        {
            $valoresPost= Input::all();//dd($valoresPost);
            $tipo_cadena = $valoresPost['tipo_cadena'];
            $tipo_horizontal = $valoresPost['tipo_horizontal'];
            $company_id = $valoresPost['company_id'];
            $cadena = $valoresPost['cadena'];
            $ejecutivo_id = $valoresPost['ejecutivo'];
            $horizontal = $valoresPost['horizontal'];
            $ubigeoext = $valoresPost['ubigeo'];
            if ($tipo_cadena=='0'){
                unset($cadena);$cadena='0';
            }else{$sw=1;}
            if ($tipo_horizontal=='0'){
                unset($horizontal);$horizontal='0';
            }else{$sw=1;}

        }else{$tipo_cadena='0';$tipo_horizontal='0';}
        if (is_array($ubigeoext)){
            $ubigeoextLink="";$c=0;
            foreach ($ubigeoext as $item) {
                $ubigeoextLink .=$item;
                $c = $c+1;
                if (count($ubigeoext) > $c)
                {
                    $ubigeoextLink .="|";
                }
            }
        }else{
            $ubigeoextLink="0";
        }

        if (is_array($cadena)){
            $cadenaLink="";$c=0;
            foreach ($cadena as $item) {
                $cadenaLink .=$item;
                $c = $c+1;
                if (count($cadena) > $c)
                {
                    $cadenaLink .="|";
                }
            }
        }else{
            $cadenaLink="0";
        }
        if (is_array($horizontal)){
            $horizontalLink="";$c=0;
            foreach ($horizontal as $item) {
                $horizontalLink .=$item;
                $c = $c+1;
                if (count($horizontal) > $c)
                {
                    $horizontalLink .="|";
                }
            }
        }else{
            $horizontalLink="0";
        }
        $mostrar_filtros = 0;
        if ($ejecutivo_id<>'0'){
            $ejecutive_msg = '';
            $get_city = $this->StoreRepo->getCitiesForEjecutive($ejecutivo_id);$c=0;
            $get_cadenas = $this->StoreRepo->getCadenasForEjecutive($ejecutivo_id);
            $get_horizontal = $this->StoreRepo->getHorizontalForEjecutive($ejecutivo_id);//dd($get_horizontal);
            if ((count($get_cadenas)>0) and (count($get_horizontal)>0)){
                $mostrar_filtros = 1;
            }else{
                $mostrar_filtros = 0;
            }
            if (count($get_city)>0){
                $ejecutive_msg = $ejecutivo_id." (";
                foreach ($get_city as $store) {
                    $ejecutive_msg .= $store->ubigeo;$c=$c+1;
                    if ($c<count($get_city)){
                        $ejecutive_msg .= ', ';
                    }
                }
                $ejecutive_msg .= ') ';
            }

            if($sw==1){
                if ($cadenaLink<>'0'){
                    $c=0;
                    if (count($get_cadenas)>0){
                        $ejecutive_msg = $ejecutive_msg." | ";
                        foreach ($get_cadenas as $store) {
                            $ejecutive_msg .= $store->cadenaRuc;$c=$c+1;
                            if ($c<count($get_cadenas)){
                                $ejecutive_msg .= ' - ';
                            }
                        }
                    }
                }

                if ($horizontalLink<>'0'){
                    $c=0;
                    if (count($get_horizontal)>0){
                        $ejecutive_msg = $ejecutive_msg." | ";
                        foreach ($get_horizontal as $store) {
                            $ejecutive_msg .= $store->type;$c=$c+1;
                            if ($c<count($get_horizontal)){
                                $ejecutive_msg .= ' - ';
                            }
                        }
                    }
                }
            }else{
                if (($cadenaLink=='0') and ($horizontalLink=='0')){
                    $c=0;
                    if (count($get_cadenas)>0){
                        $ejecutive_msg = $ejecutive_msg." | ";
                        foreach ($get_cadenas as $store) {
                            $ejecutive_msg .= $store->cadenaRuc;$c=$c+1;
                            if ($c<count($get_cadenas)){
                                $ejecutive_msg .= ' - ';
                            }
                        }
                    }

                    $c=0;
                    if (count($get_horizontal)>0){
                        $ejecutive_msg = $ejecutive_msg." | ";
                        foreach ($get_horizontal as $store) {
                            $ejecutive_msg .= $store->type;$c=$c+1;
                            if ($c<count($get_horizontal)){
                                $ejecutive_msg .= ' - ';
                            }
                        }
                    }
                }
            }



        }

        $company = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($company->customer_id);
        //$ejecutivos = $this->userRepo->listUserCustomer($customer->id);$c=0;

        $titulo = 'Reporte por Marcas Bayer';$audit_id=0;
        $subtitulo = "Competencia";
        $menus = $this->generateMenusBayer($company_id,$audit_id,3);

        $getCompaignes = $this->companyRepo->getCompaniesForClient($customer->id,"1",$this->estudio);
        foreach ($getCompaignes as $getCompaigne) {
            $arrayCampaines[]= $getCompaigne->id;
        }
        $ListProducts = $this->productDetailRepo->getAllProductsForCampaigne($arrayCampaines);//dd($ListProducts[1]);
        $products = array('0' => "Seleccionar") + $ListProducts->lists('fullname','id');

        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $urlBase = $this->urlBase."/reportBayer";
        $ListUbigeos = $this->StoreRepo->getDepartamentForCampaigne($company_id,2);
        //dd($ListCadenas);
        if ($ejecutivo_id<>'0')
        {
            if (count($get_cadenas)>0){
                foreach ($get_cadenas as $store) {
                    $ListCadenas[] = $store->cadenaRuc;
                }
            }else{
                $ListCadenas = [];
            }

            //$ListCadenas = $this->StoreRepo->getCadenasForCampaigne($company_id,2);
            $ListHorizontales[] = "Detallista";$ListHorizontales[] ="Mini Cadenas";$ListHorizontales[] ="Sub Distribuidor";
        }else{
            $ListCadenas = [];
            $ListHorizontales = [];
        }
        $listEjecutivos = $this->StoreRepo->getEjecutivosForCampaigne($company_id);
        $ejecutivos = array(0 => "Seleccionar") +  $listEjecutivos->lists('ejecutivo','ejecutivo');

        return View::make('report/bayer/trademarkReportBayer',compact('mostrar_filtros','ejecutive_msg','ejecutivo_id','tipo_horizontal','tipo_cadena','ubigeoextLink','horizontalLink','cadenaLink','ListUbigeos','ListCadenas','ListHorizontales','ejecutivos','subtitulo','titulo','logo','urlBase','cadenas','audit_id','menus','products','ListProducts','company_id','ejecutivo_id'));

    }

    public function visitors()
    {
        $company_id=60;$audit_id=0;
        $menus = $this->generateMenusBayer($company_id,$audit_id,3);
        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $urlBase = $this->urlBase."/reportVisitors";
        return View::make('report/bayer/visitorsReport',compact('company_id','logo','urlBase','menus','audit_id'));
    }

    public function ajaxGetRecomendSalesForProduct()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $cadena = $valoresPost['cadena'];
        $horizontal = $valoresPost['horizontal'];
        $product_id = $valoresPost['product_id'];
        $ejecutivo = $valoresPost['ejecutivo'];
        $ubigeoext = $valoresPost['ubigeoext'];
        if ($ubigeoext<>"0"){
            $ubigeoextLink = explode('|',$ubigeoext);
        }else{
            $ubigeoextLink="0";
        }
        if ($cadena<>"0"){
            $cadenaLink = explode('|',$cadena);

        }else{
            $cadenaLink="0";
        }
        if ($horizontal<>"0"){
            $horizontalLink = explode('|',$horizontal);
        }else{
            $horizontalLink="0";
        }

        $company = $this->companyRepo->find($company_id);
        $companies = $this->companyRepo->getCompaniesForClient($company->customer_id,"1",$this->estudio);

        $group_poll_id='';$c=0;
        foreach ($companies as $company_data)
        {
            $c=$c+1;
            if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
            {
                if($c==count($companies))
                {
                    $group_poll_id .= $this->pollArray[$company_data->id]['queRecomendo'];
                }else{
                    $group_poll_id .= $this->pollArray[$company_data->id]['queRecomendo'].',';
                }

            }
        }

        $totalOrdenado = $this->PollOptionDetailRepo->getTotalOptionForAll($group_poll_id,$ejecutivo,$product_id,$cadenaLink,"0",4,$horizontalLink,$ubigeoextLink);//dd($horizontalLink);
        if (count($totalOrdenado)>0){
            foreach ($companies as $company_data)
            {
                if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
                {
                    $poll_id=$this->pollArray[$company_data->id]['queRecomendo'];
                    $idCompany = $company_data->id;

                    foreach ($totalOrdenado as $valor)
                    {
                        $nameProduct =$valor->options;
                        $valoresProduct = $this->PollOptionDetailRepo->getTotalOptionForAll($nameProduct,$ejecutivo,$product_id,$cadenaLink,$poll_id,"0",$horizontalLink,$ubigeoextLink);
                        $qCompany =  $valoresProduct[0]->nro;
                        $comp[] = array('cantidad' =>$qCompany,'nombre' => $nameProduct,'company_id'=>$idCompany);
                        //dd($comp);
                    }
                }

            }

            $v1='';
            if (count($comp)>0){

                $cont=0;$acumulado=0;
                foreach ($comp as $item) {
                    $cont=$cont+1;
                    if ($cont==1){
                        $v1 = $item['company_id'];
                    }
                    if ($v1==$item['company_id']){

                    }else{
                        $acumulado=0;$v1=$item['company_id'];
                    }
                    $acumulado = $acumulado + $item['cantidad'];
                    $restringeCampaigne[$item['company_id']] = $acumulado;

                }
                $v1='';
                foreach ($comp as $item) {
                    if ($v1<>$item['company_id'])
                    {
                        if ($restringeCampaigne[$item['company_id']]>0){
                            $compaigne[] = $item['company_id'];
                            $v1=$item['company_id'];
                        }

                    }
                }


                foreach ($compaigne as $campaigne_id)
                {
                    $company_data = $this->companyRepo->find($campaigne_id);
                    if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
                    {
                        $c=0;$nameComp="";
                        foreach ($comp as $item) {//dd($item['company_id']);
                            if ($company_data->id == $item['company_id'])
                            {
                                $c=$c+1;
                                $qComp[] =  $item['cantidad'];
                                if ($c == 4){
                                    $nameComp .= $item['nombre'];
                                }else{
                                    $nameComp .= $item['nombre'].",";
                                }

                            }
                        }//dd($qComp);
                        if (count($qComp)==1)
                        {
                            $total = $qComp[0];
                            if ($total>0)
                            {
                                $prom1 = ($qComp[0]/$total)*100;
                            }else{
                                $prom1 = 0;
                            }
                            $estudio = str_replace("Estudio ", "", $company_data->fullname);
                            $data[] = [
                                "estudio" => $estudio,
                                "competencia0"  => round($prom1,0),
                                "competencias" => 1,
                                "names" => $nameComp,
                                "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                            ];
                        }
                        if (count($qComp)==2)
                        {
                            $total = $qComp[0] + $qComp[1];
                            if ($total>0)
                            {
                                $prom1 = ($qComp[0]/$total)*100;
                                $prom2 = ($qComp[1]/$total)*100;
                            }else{
                                $prom1 = 0;
                                $prom2 = 0;
                            }
                            $estudio = str_replace("Estudio ", "", $company_data->fullname);
                            $data[] = [
                                "estudio" => $estudio,
                                "competencia0"  => round($prom1,0),
                                "competencia1"  => round($prom2,0),
                                "competencias" => 2,
                                "names" => $nameComp,
                                "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                            ];
                        }
                        if (count($qComp)==3)
                        {
                            $total = $qComp[0] + $qComp[1] + $qComp[2];
                            if ($total>0)
                            {
                                $prom1 = ($qComp[0]/$total)*100;
                                $prom2 = ($qComp[1]/$total)*100;
                                $prom3 = ($qComp[2]/$total)*100;
                            }else{
                                $prom1 = 0;
                                $prom2 = 0;
                                $prom3 = 0;
                            }
                            $estudio = str_replace("Estudio ", "", $company_data->fullname);
                            $data[] = [
                                "estudio" => $estudio,
                                "competencia0"  => round($prom1,0),
                                "competencia1"  => round($prom2,0),
                                "competencia2"  => round($prom3,0),
                                "competencias" => 3,
                                "names" => $nameComp,
                                "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                            ];
                        }
                        if (count($qComp)==4)
                        {
                            $total = $qComp[0] + $qComp[1] + $qComp[2] + $qComp[3];
                            if ($total>0)
                            {
                                $prom1 = ($qComp[0]/$total)*100;
                                $prom2 = ($qComp[1]/$total)*100;
                                $prom3 = ($qComp[2]/$total)*100;
                                $prom4 = ($qComp[3]/$total)*100;
                            }else{
                                $prom1 = 0;
                                $prom2 = 0;
                                $prom3 = 0;
                                $prom4 = 0;
                            }
                            $estudio = str_replace("Estudio ", "", $company_data->fullname);
                            $data[] = [
                                "estudio" => $estudio,
                                "competencia0"  => round($prom1,0),
                                "competencia1"  => round($prom2,0),
                                "competencia2"  => round($prom3,0),
                                "competencia3"  => round($prom4,0),
                                "competencias" => 4,
                                "names" => $nameComp,
                                "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                            ];
                        }
                        unset($qComp);
                    }
                }

            }else{
                $data[] = [
                    "estudio" => '',
                    "competencia0"  => 0,
                    "names" => '',
                    "color" =>  "#08A5DE",
                ];
            }
        }else{
            $data[] = [
                "estudio" => '',
                "competencia0"  => 0,
                "names" => '',
                "color" =>  "#08A5DE",
            ];
        }





        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($data);
    }

    public function ajaxGetRecomendSalesForSeller()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $cadena = $valoresPost['cadena'];
        $horizontal = $valoresPost['horizontal'];
        $product_id = $valoresPost['product_id'];
        $ejecutivo = $valoresPost['ejecutivo'];
        $ubigeoext = $valoresPost['ubigeoext'];
        if ($ubigeoext<>"0"){
            $ubigeoextLink = explode('|',$ubigeoext);
        }else{
            $ubigeoextLink="0";
        }
        if ($cadena<>"0"){
            $cadenaLink = explode('|',$cadena);
        }else{
            $cadenaLink="0";
        }
        if ($horizontal<>"0"){
            $horizontalLink = explode('|',$horizontal);
        }else{
            $horizontalLink="0";
        }
        
        $company = $this->companyRepo->find($company_id);
        $companies = $this->companyRepo->getCompaniesForClient($company->customer_id,"1",$this->estudio);//dd($companies);
        $group_poll_id='';$c=0;
        //$totalOrdenado = $this->getTotalOptionForPollId($this->pollArray[13]['queRecomendo'],0,$product_id,$ejecutivo,"0",$cadena,1);dd($totalOrdenado);
        foreach ($companies as $company_data)
        {
            $c=$c+1;
            if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
            {
                if($c==count($companies))
                {
                    $group_poll_id .= $this->pollArray[$company_data->id]['queRecomendo'];
                }else{
                    $group_poll_id .= $this->pollArray[$company_data->id]['queRecomendo'].',';
                }

            }
        }
        if ($product_id==534){
            $totalOrdenado = $this->PollOptionDetailRepo->getTotalOptionForAll($group_poll_id,$ejecutivo,$product_id,$cadenaLink,"0",3,$horizontalLink,$ubigeoextLink);
            if (count($totalOrdenado)>0)
            {
                foreach ($companies as $company_data)
                {
                    if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
                    {
                        $poll_id=$this->pollArray[$company_data->id]['queRecomendo'];$group_poll_id="Apronax";
                        $valoresProduct = $this->PollOptionDetailRepo->getTotalOptionForAll($group_poll_id,$ejecutivo,$product_id,$cadenaLink,$poll_id,"0",$horizontalLink,$ubigeoextLink);//dd($poll_id);
                        $idCompany = $company_data->id;
                        $qCompany = $valoresProduct[0]->nro;//dd($valoresProduct);
                        if ($qCompany==0)
                        {
                            $comp[] = array('cantidad' => 0,'nombre' => 'Apronax','company_id'=>$idCompany);
                        }else{
                            $comp[] = array('cantidad' => $qCompany,'nombre' => 'Apronax','company_id'=>$idCompany);
                        }

                        foreach ($totalOrdenado as $valor)
                        {
                            $nameProduct =$valor->options;
                            $valoresProduct = $this->PollOptionDetailRepo->getTotalOptionForAll($nameProduct,$ejecutivo,$product_id,$cadenaLink,$poll_id,"0",$horizontalLink,$ubigeoextLink);
                            $qCompany =  $valoresProduct[0]->nro;//dd($valor);
                            $comp[] = array('cantidad' =>$qCompany,'nombre' => $nameProduct,'company_id'=>$idCompany);
                            //dd($comp);
                        }
                    }

                }
                $v1='';
                if (count($comp)>0){
                    $cont=0;$acumulado=0;
                    foreach ($comp as $item) {
                        $cont=$cont+1;
                        if ($cont==1){
                            $v1 = $item['company_id'];
                        }
                        if ($v1==$item['company_id']){

                        }else{
                            $acumulado=0;$v1=$item['company_id'];
                        }
                        $acumulado = $acumulado + $item['cantidad'];
                        $restringeCampaigne[$item['company_id']] = $acumulado;

                    }$v1='';
                    foreach ($comp as $item) {
                        if ($v1<>$item['company_id'])
                        {
                            if ($restringeCampaigne[$item['company_id']]>0){
                                $compaigne[] = $item['company_id'];
                                $v1=$item['company_id'];
                            }

                        }

                    }
                    foreach ($compaigne as $campaigne_id)
                    {
                        $company_data = $this->companyRepo->find($campaigne_id);
                        if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
                        {
                            $c=0;$nameComp="";
                            foreach ($comp as $item) {//dd($item['company_id']);
                                if ($company_data->id == $item['company_id'])
                                {
                                    $c=$c+1;
                                    $qComp[] =  $item['cantidad'];
                                    if ($c == 4){
                                        $nameComp .= $item['nombre'];
                                    }else{
                                        $nameComp .= $item['nombre'].",";
                                    }

                                }
                            }//dd($qComp);
                            if (count($qComp)==1)
                            {
                                $total = $qComp[0];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]/$total)*100;
                                }else{
                                    $prom1 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $company_data->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    "competencia0"  => round($prom1,0),
                                    "competencias" => 1,
                                    "names" => $nameComp,
                                    "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                                ];
                            }
                            if (count($qComp)==2)
                            {
                                $total = $qComp[0] + $qComp[1];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]/$total)*100;
                                    $prom2 = ($qComp[1]/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $company_data->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    "competencia0"  => round($prom1,0),
                                    "competencia1"  => round($prom2,0),
                                    "competencias" => 2,
                                    "names" => $nameComp,
                                    "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                                ];
                            }
                            if (count($qComp)==3)
                            {
                                $total = $qComp[0] + $qComp[1] + $qComp[2];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]/$total)*100;
                                    $prom2 = ($qComp[1]/$total)*100;
                                    $prom3 = ($qComp[2]/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                    $prom3 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $company_data->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    "competencia0"  => round($prom1,0),
                                    "competencia1"  => round($prom2,0),
                                    "competencia2"  => round($prom3,0),
                                    "competencias" => 3,
                                    "names" => $nameComp,
                                    "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                                ];
                            }
                            if (count($qComp)==4)
                            {
                                $total = $qComp[0] + $qComp[1] + $qComp[2] + $qComp[3];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]/$total)*100;
                                    $prom2 = ($qComp[1]/$total)*100;
                                    $prom3 = ($qComp[2]/$total)*100;
                                    $prom4 = ($qComp[3]/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                    $prom3 = 0;
                                    $prom4 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $company_data->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    "competencia0"  => round($prom1,0),
                                    "competencia1"  => round($prom2,0),
                                    "competencia2"  => round($prom3,0),
                                    "competencia3"  => round($prom4,0),
                                    "competencias" => 4,
                                    "names" => $nameComp,
                                    "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
                                ];
                            }
                            unset($qComp);
                        }

                    }
                }else{
                    $data[] = [
                        "estudio" => '',
                        "competencia0"  => 0,
                        "names" => '',
                        "color" =>  "#08A5DE",
                    ];
                }

            }else{
                $data[] = [
                    "estudio" => '',
                    "competencia0"  => 0,
                    "names" => '',
                    "color" =>  "#08A5DE",
                ];
            }


        }else{
            $totalOrdenado = $this->PollOptionDetailRepo->getTotalOptionForAll($group_poll_id,$ejecutivo,$product_id,$cadenaLink,"0",4,$horizontalLink,$ubigeoextLink);//dd($totalOrdenado);
            if (count($totalOrdenado)==0)
            {
                $data[] = [
                    "estudio" => '',
                    ''  => 0,
                ];
            }else{
                foreach ($companies as $company_data)
                {
                    if ($this->pollArray[$company_data->id]['queRecomendo']<>0)
                    {
                        $poll_id=$this->pollArray[$company_data->id]['queRecomendo'];
                        $idCompany = $company_data->id;

                        foreach ($totalOrdenado as $valor)
                        {
                            $nameProduct =$valor->options;//dd($nameProduct);
                            $valoresProduct = $this->PollOptionDetailRepo->getTotalOptionForAll($nameProduct,$ejecutivo,$product_id,$cadenaLink,$poll_id,"0",$horizontalLink,$ubigeoextLink);
                            $qCompany =  $valoresProduct[0]->nro;//dd($valoresProduct);
                            if ($qCompany>0){
                                $comp[] = array('cantidad' =>$qCompany,'nombre' => $nameProduct,'company_id'=>$idCompany);
                            }else{
                                $comp[] = array('cantidad' =>0,'nombre' => $nameProduct,'company_id'=>$idCompany);
                            }
                        }
                    }
                }//dd($comp);
                $v1='';
                if (count($comp)>0)
                {
                    $cont=0;$acumulado=0;
                    foreach ($comp as $item) {
                        $cont=$cont+1;
                        if ($cont==1){
                            $v1 = $item['company_id'];
                        }
                        if ($v1==$item['company_id']){

                        }else{
                            $acumulado=0;$v1=$item['company_id'];
                        }
                        $acumulado = $acumulado + $item['cantidad'];
                        $restringeCampaigne[$item['company_id']] = $acumulado;

                    }$v1='';
                    foreach ($comp as $item) {
                        if ($v1<>$item['company_id'])
                        {
                            if ($restringeCampaigne[$item['company_id']]>0){
                                $compaigne[] = $item['company_id'];
                                $v1=$item['company_id'];
                            }

                        }

                    }//dd($compaigne);

                    foreach ($compaigne as $company_data)
                    {
                        if ($this->pollArray[$company_data]['queRecomendo']<>0)
                        {
                            $objCampaigne=$this->companyRepo->find($company_data);
                            $c=0;$nameComp="";$sw=0;//dd($comp);
                            foreach ($comp as $item) {//dd($item['company_id']);
                                if ($company_data == $item['company_id'])
                                {
                                    $c=$c+1;
                                    $qComp[] = array('cantidad' => $item['cantidad'], 'nombre' => $item['nombre']);
                                }else{
                                    $sw=1;
                                }
                            }//dd($qComp);
                            if (count($qComp)==1)
                            {
                                $total = $qComp[0]['cantidad'];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]['cantidad']/$total)*100;
                                }else{
                                    $prom1 = 0;
                                }
                                $data[] = [
                                    "estudio" => $objCampaigne->fullname,
                                    $qComp[0]['nombre']  => round($prom1,0),
                                ];
                            }
                            if (count($qComp)==2)
                            {
                                $total = $qComp[0]['cantidad'] + $qComp[1]['cantidad'];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]['cantidad']/$total)*100;
                                    $prom2 = ($qComp[1]['cantidad']/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $objCampaigne->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    $qComp[0]['nombre']  => round($prom1,0),
                                    $qComp[1]['nombre']  => round($prom2,0),
                                ];
                            }
                            if (count($qComp)==3)
                            {
                                $total = $qComp[0]['cantidad'] + $qComp[1]['cantidad'] + $qComp[2]['cantidad'];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]['cantidad']/$total)*100;
                                    $prom2 = ($qComp[1]['cantidad']/$total)*100;
                                    $prom3 = ($qComp[2]['cantidad']/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                    $prom3 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $objCampaigne->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    $qComp[0]['nombre']  => round($prom1,0),
                                    $qComp[1]['nombre']  => round($prom2,0),
                                    $qComp[2]['nombre']  => round($prom3,0),
                                ];
                            }
                            if (count($qComp)==4)
                            {
                                $total = $qComp[0]['cantidad'] + $qComp[1]['cantidad'] + $qComp[2]['cantidad'] + $qComp[3]['cantidad'];
                                if ($total>0)
                                {
                                    $prom1 = ($qComp[0]['cantidad']/$total)*100;
                                    $prom2 = ($qComp[1]['cantidad']/$total)*100;
                                    $prom3 = ($qComp[2]['cantidad']/$total)*100;
                                    $prom4 = ($qComp[3]['cantidad']/$total)*100;
                                }else{
                                    $prom1 = 0;
                                    $prom2 = 0;
                                    $prom3 = 0;
                                    $prom4 = 0;
                                }
                                $estudio = str_replace("Estudio ", "", $objCampaigne->fullname);
                                $data[] = [
                                    "estudio" => $estudio,
                                    $qComp[0]['nombre']  => round($prom1,0),
                                    $qComp[1]['nombre']  => round($prom2,0),
                                    $qComp[2]['nombre']  => round($prom3,0),
                                    $qComp[3]['nombre']  => round($prom4,0),
                                ];
                            }
                            unset($qComp);
                        }

                    }
                }else{
                    $data[] = [
                        "estudio" => '',
                        ''  => 0,
                    ];
                }
            }
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($data);

    }
    
    public function ajaxGetVisitors()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        //$user_id = $valoresPost['user_id'];
        $company_id=$valoresPost['company_id'];
        //$userObj = $this->userRepo->find($user_id);
        //$campaigneDetail = $this->companyRepo->find($company_id);//dd($campaigneDetail);
        //$customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        /*$users = $this->UserCompanyRepo->getUsersForCompany($company_id);dd($users[0]);
        $countVisities = $this->visitorRepo->getCountVisitForUser(7);dd($countVisities);*/
        $totalOrdenado = $this->getVisitorForUsers($company_id);
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($totalOrdenado);
        
    }

    public function ajaxGetResultQuestion()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $poll_id = $valoresPost['poll_id'];
        $totalAbiertos = $valoresPost['totalAbiertos'];
        $cadena = $valoresPost['cadena'];
        $product_id = $valoresPost['product_id'];
        $ejecutivo = $valoresPost['ejecutivo'];
        $ubigeoext = $valoresPost['ubigeoext'];
        $horizontal = $valoresPost['horizontal'];
        if ($ubigeoext<>"0"){
            $datoUbigeo = explode('|',$ubigeoext);
            if (count($datoUbigeo)>0){
                foreach ($datoUbigeo as $item) {
                    $ubigeoextLink[] = $item;
                }
            }else{
                $ubigeoextLink="0";
            }
        }else{
            $ubigeoextLink="0";
        }
        if ($cadena<>"0"){
            $datoCadena = explode('|',$cadena);
            if (count($datoCadena)>0){
                foreach ($datoCadena as $item) {
                    $cadenaLink[] = $item;
                }
            }else{
                $cadenaLink="0";
            }
        }else{
            $cadenaLink="0";
        }
        if ($horizontal<>"0"){
            $datoHorizontal = explode('|',$horizontal);
            if (count($datoHorizontal)>0){
                foreach ($datoHorizontal as $item) {
                    $horizontalLink[] = $item;
                }
            }else{
                $horizontalLink="0";
            }
        }else{
            $horizontalLink="0";
        }

        $priority = $valoresPost['priority'];
        $company_id = $valoresPost['company_id'];
        //dd($priority);
        if ($priority  ==0)
        {
            $totalOrdenado = $this->getTotalOptionForPollId($poll_id,$totalAbiertos,$product_id,$ejecutivo,$ubigeoextLink,$cadenaLink,"0",$horizontalLink);
        }else{
            $totalOrdenado = $this->getTotalPriorityForPollId($poll_id,$company_id,$product_id,$ejecutivo,$ubigeoextLink,$cadenaLink,$horizontalLink);
        }//dd($totalOrdenado);

        //$totalOptionsJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
        //return $totalOptionsJSON;
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($totalOrdenado);
    }


    public function getDetailQuestionBayer($poll_id,$values,$company_id,$poll_option_id="0",$product_id="0")
    {
        //getDetailQuestionBayer/573/0-0-0-0-0-0-0-0-0-0/44/0
        //getDetailQuestionBayer/{poll_id}/{values}/{company_id}/{poll_option_id?}/{product_id?}

        $audit_id ='0';

        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';//dd($values);
        $valores = explode('-',$values);//$valCiudad = "0-0-0-0-".$ubigeoext.'-'.$cadena; IBK:$valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $city = $valores[0];  //route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];
        $ubigeo = $valores[4];
        $cadena = $valores[5];
        $pregSino = $valores[6];
        $menus = $this->generateMenusBayer($company_id,$audit_id);

        /*$datosStores = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$urlBase,$urlImages,$valores);IBK*/

        $datosStores = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$urlBase,$urlImages,$valores,$product_id,$company_id);
        //tempor
        $c=0;
        if ($company_id==65){
            $valTempor=array(29203,29225,29226,29245,29246,29669,29244,29253,29220,29742,29638,29489,29901,30072,29497,29571,30106);
        }else{
            if ($company_id==60){
                $valTempor=array(29571,30106,29497,30072,29285,29901,29489,29638,29742,29220,29245,29246);
            }else{
                $valTempor=[];
            }
        }

        foreach ($datosStores as $key =>  $datosStore) {
            if (count($valTempor)>0){
                foreach ($valTempor as $key1 =>  $val) {
                    if ($datosStore['store_id']==$val){
                        unset($datosStores[$key]);
                        unset($valTempor[$key1]);
                    }
                }
            }


        }
        //fin tempor

        if ($city==1){
            $city="Todo Lima";
        }
        if ($city==2){
            $city="Todo Arequipa";
        }
        if ($city==3){
            $city="Todo Ica";
        }
        if ($city==4){
            $city="Todo Trujillo";
        }
        $question = $this->PollRepo->find($poll_id);//dd($question);
        $companyObj = $this->companyRepo->find($company_id);
        /*$QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];*/
        $aleatorio = " Reporte ".$question->question.rand();

        return View::make('report/bayer/detailPollSiNo', compact('companyObj','menus','company_id','pregSino','question','city','district','ejecutivo','rubro','audit_id','datosStores','aleatorio'));
    }

    public function getDetailWinnersBayer($poll_id,$values,$company_id)
    {
        $audit_id ='0';

        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';
        $valores = explode('-',$values);//$valCiudad = "0-0-0-0-".$ubigeoext.'-'.$cadena; IBK:$valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $city = $valores[0];  //route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];
        $ubigeo = $valores[4];
        $cadena = $valores[5];
        $menus = $this->generateMenusBayer($company_id,$audit_id);

        $datosStores = $this->getDeatailWinnersBayer($poll_id,$urlBase,$urlImages,$valores,$company_id);//dd($datosStores[1]['arrayFoto']);

        if ($city==1){
            $city="Todo Lima";
        }
        if ($city==2){
            $city="Todo Arequipa";
        }
        if ($city==3){
            $city="Todo Ica";
        }
        if ($city==4){
            $city="Todo Trujillo";
        }
        $campaigne = $this->companyRepo->find($company_id);
        $campaigne_name = $campaigne->fullname;//dd($campaigne_name);
        $aleatorio = " Reporte Ganadores ".rand();

        return View::make('report/bayer/detailWinners', compact('menus','company_id','city','district','ejecutivo','rubro','audit_id','datosStores','campaigne_name','aleatorio'));
    }


} 
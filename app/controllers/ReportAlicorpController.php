<?php
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PresenceDetailRepo;
use Auditor\Repositories\PresenceRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Repositories\PublicityRepo;
use Auditor\Repositories\AuditRepo;
use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\RoadRepo;
use Auditor\Repositories\RoadDetailRepo;

class ReportAlicorpController extends BaseController
{
    protected $UserCompanyRepo;
    protected $companyRepo;
    protected $companyStoreRepo;
    protected $customerRepo;
    protected $PollDetailRepo;
    protected $PollRepo;
    protected $PollOptionDetailRepo;
    protected $MediaRepo;
    protected $PollOptionRepo;
    protected $PresenceDetailRepo;
    protected $PublicitiesDetailRepo;
    protected $PublicityRepo;
    protected $auditRepo;
    protected $categoryProductRepo;
    protected $presenceRepo;
    protected $StoreRepo;
    protected $auditRoadStoreRepo;
    protected $roadRepo;
    protected $roadDetailRepo;

    public $urlBase;
    public $urlImagesProducts;
    public $urlImages;
    public $urlImageBase;
    public $pollArray;
    public $datosGenerales;

    public function __construct(RoadDetailRepo $roadDetailRepo,RoadRepo $roadRepo,AuditRoadStoreRepo $auditRoadStoreRepo,StoreRepo $StoreRepo,PresenceRepo $presenceRepo,CategoryProductRepo $categoryProductRepo,AuditRepo $auditRepo,PublicityRepo $PublicityRepo,PublicitiesDetailRepo $PublicitiesDetailRepo,PresenceDetailRepo $PresenceDetailRepo,PollOptionRepo $PollOptionRepo,MediaRepo $MediaRepo,PollOptionDetailRepo $PollOptionDetailRepo,PollRepo $PollRepo,UserCompanyRepo $UserCompanyRepo, CompanyRepo $companyRepo, CompanyStoreRepo $companyStoreRepo, CustomerRepo $customerRepo, PollDetailRepo $PollDetailRepo)
    {
        $this->UserCompanyRepo = $UserCompanyRepo;
        $this->companyRepo = $companyRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
        $this->urlImagesProducts = '/media/images/bayer/products/';
        $this->customerRepo = $customerRepo;
        $this->pollArray[3] = array('abierto' => 148,'dex' => 149,'permitio' => 150,'sodW' => 193,'existeSOD' => 0, 'ventVisible' => 0, 'hayVentana' => 0);
        $this->pollArray[18] = array('abierto' => 201,'dex' => 202,'permitio' => 203,'sodW' => 204,'existeSOD' => 205, 'ventVisible' => 0, 'hayVentana' => 0);
        $this->pollArray[21] = array('abierto' => 247,'dex' => 248,'permitio' => 249,'sodW' => 250,'existeSOD' => 251, 'ventVisible' => 0, 'hayVentana' => 0);
        $this->pollArray[22] = array('abierto' => 252,'dex' => 253,'permitio' => 254,'sodW' => 255,'existeSOD' => 256, 'ventVisible' => 257, 'hayVentana' => 258);
        $this->pollArray[29] = array('abierto' => 385,'dex' => 386,'permitio' => 387,'sodW' => 388,'existeSOD' => 389, 'ventVisible' => 390, 'hayVentana' => 391);
        $this->pollArray[36] = array('abierto' => 489,'dex' => 0,'permitio' => 490,'sodW' => 491,'existeSOD' => 492, 'ventVisible' => 493, 'hayVentana' => 494);
        $this->pollArray[38] = array('abierto' => 508,'dex' => 0,'permitio' => 509,'sodW' => 510,'existeSOD' => 511, 'ventVisible' => 512, 'hayVentana' => 513);
        $this->pollArray[43] = array('abierto' => 563,'dex' => 0,'permitio' => 564,'sodW' => 565,'existeSOD' => 566, 'ventVisible' => 567, 'hayVentana' => 568);
        $this->pollArray[46] = array('abierto' => 617,'dex' => 0,'permitio' => 618,'sodW' => 619,'existeSOD' => 620, 'ventVisible' => 621, 'hayVentana' => 622);
        $this->pollArray[53] = array('abierto' => 756,'dex' => 0,'permitio' => 757,'sodW' => 758,'existeSOD' => 759, 'ventVisible' => 760, 'hayVentana' => 761);
        $this->datosGenerales[3] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[18] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[21] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[22] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[29] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[36] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[38] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[43] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[46] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->datosGenerales[53] = array('catExhibidor' => 53, 'catSod' => 54, 'MSLMM' => 38,'MSLBC' => 32,'MSLAT' =>30);
        $this->PollDetailRepo = $PollDetailRepo;
        $this->PollRepo = $PollRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->MediaRepo = $MediaRepo;
        $this->PollOptionRepo = $PollOptionRepo;
        $this->PresenceDetailRepo = $PresenceDetailRepo;
        $this->PublicitiesDetailRepo = $PublicitiesDetailRepo;
        $this->PublicityRepo = $PublicityRepo;
        $this->auditRepo = $auditRepo;
        $this->categoryProductRepo = $categoryProductRepo;
        $this->presenceRepo = $presenceRepo;
        $this->StoreRepo = $StoreRepo;
        $this->auditRoadStoreRepo = $auditRoadStoreRepo;
        $this->roadRepo = $roadRepo;
        $this->roadDetailRepo = $roadDetailRepo;
    }

    public function reportHome($company_id="0",$url="0")
    {
        if ($url=="0")
        {
            if ($company_id=="0"){
                $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
                $company_id=$company[0]->id;
                $titulo = $company[0]->fullname;
                $valoresPost= Input::all();//dd($valoresPost);

                if (count($valoresPost)<>0){
                    $filtro=0;
                    $ubigeoext = $valoresPost['ubigeo'];
                    $company_id = $valoresPost['company_id'];
                    $audit_id =$valoresPost['audit_id'];
                    $dexExt =$valoresPost['dex'];
                    $typeStoreExt =$valoresPost['typeStore'];
                    $company = $this->companyRepo->find($company_id);//dd($company);
                    $titulo = $company->fullname;
                }else{
                    $filtro=0;
                    $ubigeoext = "0";
                    $dexExt = "0";
                    $typeStoreExt="0";
                    $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
                    $company_id=$company[0]->id;
                    $titulo = $company[0]->fullname;
                }
            }else{
                $filtro=1;
                $ubigeoext = "0";
                $dexExt = "0";
                $typeStoreExt="0";
                $company = $this->companyRepo->find($company_id);//dd($company);
                $titulo = $company->fullname;
            }

        }else{
            $ubigeoext = "0";
            $dexExt = "0";
            $typeStoreExt="0";
            $company = $this->companyRepo->find($company_id);//dd($company);
            $titulo = $company->fullname;
            $filtro=0;
        }
        $audit_id=0;

        $valores = $ubigeoext."-0-0-0-0-0-0-".$dexExt."-".$typeStoreExt;

        $menus = $this->generateMenusAlicorp($company_id,$audit_id,"0",$filtro);//dd($menus);

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id,1,"0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id,1,"0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);

        $ListStores = $this->StoreRepo->getDepartamentForCampaigne($company_id);//dd($ListStores);
        $ubigeo = array(0 => "Seleccionar") + array(5 => "Todo Provincias") + $ListStores->lists('ubigeo','ubigeo');

        $ListDex = $this->StoreRepo->getDexForCampaigne($company_id);
        $dex = array(0 => "Seleccionar") + $ListDex->lists('distributor','distributor');

        $ListTypeStore = $this->StoreRepo->getTypeStoreForCampaigne($company_id);
        $typeStore = array(0 => "Seleccionar") + $ListTypeStore->lists('tipo_bodega','tipo_bodega');

        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;

        $campaignesClient = $this->companyRepo->getCompaniesForClient($customer->id);//Para combo de cambio de campañas
        $campaignes = array(0 => "Seleccionar Estudio") + $campaignesClient->lists('fullname','id');
        $urlBase = $this->urlBase."/reportAlicorp/";

        if (($company_id==3) or ($company_id==18) or ($company_id==21) or ($company_id==22) or ($company_id==29) or ($company_id==36) or ($company_id==38) or ($company_id>=43)){
            $QuestionOpen = $this->pollArray[$company_id]['abierto'];
            $QuestionPermitio = $this->pollArray[$company_id]['permitio'];

            $sino=$this->PollDetailRepo->getTotalSiNo($QuestionOpen,"0","0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);

            $valSiNo[0] = array("tipo" => 'Abierto', "cantidad" => $sino['si'], "color" => '#FFFF00');
            $valSiNo[1] = array("tipo" => 'Cerrado', "cantidad" => $sino['no'], "color" => '#FE0000');
            $valSINOJson =json_encode($valSiNo);unset($valSiNo);//dd($valSINOJson);

            $permitio=$this->PollDetailRepo->getTotalSiNo($QuestionPermitio,"0","0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);
            $valSiNo[0] = array("tipo" => 'Si', "cantidad" => $permitio['si'], "color" => '#FFFF00');
            $valSiNo[1] = array("tipo" => 'No', "cantidad" => $permitio['no'], "color" => '#FE0000');
            $totalAbiertos = $permitio['si'];
            $valPermitioJson =json_encode($valSiNo);unset($valSiNo);$tituloMSL="";

            if ($totalAbiertos<>0){
                if ($typeStoreExt=="0")
                {
                    $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLMM'],$company_id,'Mini Market',$ubigeoext,$dexExt);
                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                    $valMSLMMJson =json_encode($valSiNo);unset($valSiNo);

                    $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLBC'],$company_id,'Bodega Clásica',$ubigeoext,$dexExt);
                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                    $valMSLBCJson =json_encode($valSiNo);unset($valSiNo);

                    $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLAT'],$company_id,'Bodega Alto Tráfico',$ubigeoext,$dexExt);
                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                    $valMSLATJson =json_encode($valSiNo);unset($valSiNo);

                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => 0, "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => 0, "color" => '#FE0000');
                    $valMSLFilterJson =json_encode($valSiNo);unset($valSiNo);
                }else{
                    if ($typeStoreExt=='Mini Market'){$valorMSL = $this->datosGenerales[$company_id]['MSLMM'];}
                    if ($typeStoreExt=='Bodega Clásica'){$valorMSL = $this->datosGenerales[$company_id]['MSLBC'];}
                    if ($typeStoreExt=='Bodega Alto Tráfico'){$valorMSL = $this->datosGenerales[$company_id]['MSLAT'];}
                    $limaMM = $this->countStoresConditionMSL($valorMSL,$company_id,$typeStoreExt,$ubigeoext,$dexExt);
                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                    $valMSLFilterJson =json_encode($valSiNo);unset($valSiNo);$tituloMSL=$typeStoreExt;

                    $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => 0, "color" => '#FFFF00');
                    $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => 0, "color" => '#FE0000');
                    $valMSLMMJson =json_encode($valSiNo);
                    $valMSLBCJson =json_encode($valSiNo);
                    $valMSLATJson =json_encode($valSiNo);unset($valSiNo);
                }

            }else{
                $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => 0, "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => 0, "color" => '#FE0000');
                $valMSLMMJson =json_encode($valSiNo);unset($valSiNo);
            }

            $publicities = $this->PublicityRepo->getPublicityForCatMat($this->datosGenerales[$company_id]['catExhibidor'],$company_id);
            foreach ($publicities as $publicity)
            {
                $cantidadOption = $this->PublicitiesDetailRepo->getCountStoresForPublicity($company_id,$publicity->id,1,$ubigeoext,$dexExt,$typeStoreExt);//dd($publicity);
                if ($totalAbiertos <> 0) {
                    $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                } else {
                    $porcOpcion = 0;
                }
                $ValRespuesta = trim($publicity->fullname);
                $totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
            }
            arsort($totalOptions);//dd($totalOptions);
            foreach ($totalOptions as $totalOptions1) {
                $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
            }
            $totalOptionExhiJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

            $publicities = $this->PublicityRepo->getPublicityForCatMat($this->datosGenerales[$company_id]['catSod'],$company_id);
            foreach ($publicities as $publicity)
            {
                $cantidadOption = $this->PublicitiesDetailRepo->getCountStoresForPublicity($company_id,$publicity->id,0,$ubigeoext,$dexExt,$typeStoreExt);//dd($publicity);
                $sumSOD=0; $contarSOD=0;
                foreach ($cantidadOption as $publicity_detail)
                {
                    if ($publicity_detail->sod>0){
                        $sumSOD=$sumSOD + $publicity_detail->sod;
                        $contarSOD = $contarSOD +1;
                    }
                }//dd($contarSOD);
                if ($contarSOD ==0 )
                {
                    $promedioSOD = 0;
                }else{
                    $promedioSOD = $sumSOD/$contarSOD;
                }

                $ValRespuesta = trim($publicity->fullname);
                $totalOptions[] = array('cantidad' => $promedioSOD,'respuesta' => $ValRespuesta, "porcentaje" => round($promedioSOD*100, 0));
            }
            arsort($totalOptions);//dd($totalOptions);
            foreach ($totalOptions as $totalOptions1) {
                $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
            }
            $totalOptionSODJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

            if ($company_id>=36){
                return View::make('report/inicioAlicorp36',compact('valMSLFilterJson','tituloMSL','typeStore','dex','ubigeoext','ubigeo','totalOptionSODJSON','totalOptionExhiJSON','valMSLATJson','valMSLBCJson','valMSLMMJson','QuestionPermitio','valPermitioJson','valores','QuestionOpen','valSINOJson','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','menus','audit_id','company_id'));
            }
            return View::make('report/inicioAlicorp3',compact('valMSLFilterJson','tituloMSL','typeStore','dex','ubigeoext','ubigeo','totalOptionSODJSON','totalOptionExhiJSON','valMSLATJson','valMSLBCJson','valMSLMMJson','QuestionPermitio','valPermitioJson','valores','QuestionOpen','valSINOJson','urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','menus','audit_id','company_id'));
        }
        if ($company_id==15){
            return View::make('report/inicioAlicorp15',compact('urlBase','campaignes','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','menus','audit_id','company_id'));
        }

    }

    public function countStoresConditionMSL($msl,$company_id,$tipo_bodega,$ubigeoext="0",$dex="0")
    {
        $valores =$this->PresenceDetailRepo->getListStoresCountProduct($tipo_bodega,$company_id,$ubigeoext,$dex);$c=0;$cumple=0;$nocumple=0;//dd($valores);
        foreach ($valores as $valor)
        {
            $c=$c+1;
            if ($valor->Nro_prod>=$msl)
            {
                $cumple = $cumple +1;
            }else{
                $nocumple = $nocumple + 1;
            }
        }
        $resultados = array('Nro_stores' => $c , 'cumple' => $cumple, 'nocumple' => $nocumple);
        return $resultados;
    }

    public function getRoadsForCampaigne($company_id)
    {
        /*$company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $titulo = $company[0]->fullname;*/
        $company = $this->companyRepo->find($company_id);//dd($company);
        $titulo = $company->fullname;
        $audit_id=0;
        $campaigneDetail = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $menus = $this->generateMenusAlicorp($company_id,0,1,1);

        $roads =$this->auditRoadStoreRepo->getRoadsResumeForCompany($company_id);//dd($roads);
        $cliente='Alicorp';

        return View::make('report/listRoadsAlicorp',compact('cliente','titulo','logo','menus','roads','audit_id','company_id'));

    }

    public function getDetailRoad($road_id,$company_id)
    {
        $road = $this->roadRepo->find($road_id);
        $roadDetails = $this->roadDetailRepo->getDetailStores($road_id);$auditados=0;
        $menus = $this->generateMenusAlicorp($company_id,0,0);

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

    public function generateMenusAlicorp($company_id,$audit_id, $cat="0",$filtro="0")
    {
        $companies = $this->UserCompanyRepo->getCompany(Auth::user()->id);//dd($companies);
        foreach ($companies as $company)
        {
            if ($filtro==1){
                $campaigne_id=$company_id;
            }else{
                $campaigne_id=$company->id;
            }
            $AuditsCompany = $this->getAuditForCompany($campaigne_id);
            $campaigne = $this->companyRepo->find($campaigne_id);//dd($campaigne);
            if (($audit_id == 0) and ($cat=="0")){
                $submenu1[] = array('nombre' => 'Home', 'url' => route('reportAlicorp',array( $campaigne_id,$audit_id)), 'active' => 1,'icon' => 'inicio');
            }else{
                $submenu1[] = array('nombre' => 'Home', 'url' => route('reportAlicorp',array( $campaigne_id,$audit_id)), 'active' => 0,'icon' => 'inicio');
            }
            /*if (($audit_id == 0) and ($cat=="2"))
            {
                $submenu1[] = array('nombre' => 'Reporte en Excel', 'url' => route('excelAlicorpBodegas', array($campaigne_id,0)), 'active' => 1,'icon' => 'inicio');
            }else{
                $submenu1[] = array('nombre' => 'Reporte en Excel', 'url' => route('excelAlicorpBodegas', array($campaigne_id,0)), 'active' => 0,'icon' => 'inicio');
            }*/

            foreach ($AuditsCompany as $audit)
            {
                if (($audit->id<>4) and ($audit->id<>15) and ($audit->id<>37)){
                    if ($audit_id == $audit->id)
                    {
                        $submenu1[] = array('nombre' => $audit->fullname, 'url' => route('auditReportCategoryAlicorp', array($audit->id, $campaigne_id)), 'active' => 1,'icon' => 'audit');
                    }else{
                        $submenu1[] = array('nombre' => $audit->fullname, 'url' => route('auditReportCategoryAlicorp', array($audit->id, $campaigne_id)), 'active' => 0,'icon' => 'audit');
                    }
                }

            }
            if (($audit_id == 0) and ($cat=="1"))
            {
                $submenu1[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForAlicorp', array( $campaigne_id)), 'active' => 1,'icon' => 'audit');
            }else{
                $submenu1[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForAlicorp', array( $campaigne_id)), 'active' => 0,'icon' => 'audit');
            }
            if (($company->id == $company_id) or ($filtro==1)){
                $menus[] = array('nombre' => $campaigne->fullname, 'url' => route('reportAlicorp',array( $campaigne_id,$audit_id)), 'active' => 1,'icon' => 'icon-materiales', 'submenu1' => $submenu1);

            }else{
                $menus[] = array('nombre' => $campaigne->fullname, 'url' => route('reportAlicorp',array( $campaigne_id,$audit_id)), 'active' => 0,'icon' => 'icon-materiales', 'submenu1' => $submenu1);
            }
            unset($submenu1);
        }
//dd($menus);
        return $menus;
    }

    public function excelAlicorpBodegas($company_id,$audit_id)
    {
        $menus = $this->generateMenusAlicorp($company_id,$audit_id,2,1);

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0");
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);


        $campaigneDetail = $this->companyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;

        return View::make('report/alicorp/excelBodegasAlicorp3', compact('menus','audit_id','company_id','logo','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','titulo'));

    }

    public function getDetailQuestionAlicorp($poll_id,$values,$company_id,$poll_option_id="0",$product_id="0",$publicity_id="0")
    {
        //getDetailQuestionAlicorp/{poll_id}/{values}/{company_id}/{poll_option_id?}/{product_id?}/{publicity_id?}
        //                         255/LIMA-0-0-0-0-0-0/22/0/0/370
        $audit_id ='0';
        $valores = explode('-',$values);//$valCiudad = "0-0-0-0-".$ubigeoext.'-'.$cadena; IBK:$valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $city = $valores[0];  //route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];
        $ubigeo = $valores[4];
        $cadena = $valores[5];
        $pregSino = $valores[6];
        $dex = $valores[7];
        $tipoBodega = $valores[8];

        $menus = $this->generateMenusAlicorp($company_id,$audit_id,"0");

        $datosStores = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$this->urlBase,$this->urlImages,$valores,$product_id,$company_id,$publicity_id);//dd($datosStores);

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
        $question = $this->PollRepo->find($poll_id);
        /*$QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];*/

        return View::make('report/alicorp/detailPollSiNo', compact('menus','company_id','pregSino','question','city','district','ejecutivo','rubro','audit_id','datosStores'));
    }

    public function auditReportForCategory($audit_id="0",$company_id="0",$category_id="0")
    {//dd($company_id);
        $sw=0;
        if ($audit_id=="0")
        {
            if ($company_id=="0"){
                $valoresPost= Input::all();//dd($valoresPost);

                if (count($valoresPost)<>0){
                    $sw=1;
                    $filtro=1;
                    $ubigeoext = $valoresPost['ubigeo'];
                    $company_id = $valoresPost['company_id'];
                    $audit_id =$valoresPost['audit_id'];
                    $dexExt =$valoresPost['dex'];
                    $typeStoreExt =$valoresPost['typeStore'];

                    $categoria = $valoresPost['categoria'];
                    if ($categoria==""){$sw=0;$categoriaExt="0";}
                    $company = $this->companyRepo->find($company_id);//dd($company);
                    $titulo = $company->fullname;
                }else{
                    $filtro=0;
                    $ubigeoext = "0";
                    $categoria = "0";
                    $dexExt ="0";
                    $typeStoreExt ="0";
                    $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
                    $company_id=$company[0]->id;
                    $titulo = $company[0]->fullname;
                }
            }else{
                $filtro=1;
                $ubigeoext = "0";
                $categoria = "0";
                $dexExt ="0";
                $typeStoreExt ="0";
                $company = $this->companyRepo->find($company_id);//dd($company);
                $titulo = $company->fullname;
            }

        }else{
            $filtro=1;
            $ubigeoext = "0";
            $categoria = "0";
            $dexExt ="0";
            $typeStoreExt ="0";
            if ($company_id=="0"){
                $valoresPost= Input::all();
                $company_id = $valoresPost['company_id'];
            }
            $company = $this->companyRepo->find($company_id);//dd($company);
            $titulo = $company->fullname;
        }

        if ($sw==0){ $valores = $ubigeoext.'-0-0-0-0-0-0-'.$dexExt.'-'.$typeStoreExt;}else{$valores = $ubigeoext.'-'.$categoria;}
        /*$city = $valores[0];  //route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];
        $ubigeo = $valores[4];
        $cadena = $valores[5];
        $pregSino = $valores[6];
        $dex = $valores[7];
        $tipoBodega = $valores[8];*/

        $menus = $this->generateMenusAlicorp($company_id,$audit_id,"0",$filtro);

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id,1,"0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id,1,"0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);

        $objAudit=$this->auditRepo->find($audit_id);


        $campaigneDetail = $this->companyRepo->find($company_id);
        //$titulo = $campaigneDetail->fullname;
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;

        $campaignesClient = $this->companyRepo->getCompaniesForClient($customer->id);//Para combo de cambio de campañas
        $campaignes = array(0 => "Seleccionar Estudio") + $campaignesClient->lists('fullname','id');
        $urlBase = $this->urlBase."/reportAlicorp/";
        $urlBase = $this->urlBase."/report/auditsCategoryAlicorp/".$audit_id."/";

        $ListStores = $this->StoreRepo->getDepartamentForCampaigne($company_id);
        $ubigeo = array(0 => "Seleccionar") + array(5 => "Todo Provincias") + $ListStores->lists('ubigeo','ubigeo');

        $ListDex = $this->StoreRepo->getDexForCampaigne($company_id);
        $dex = array(0 => "Seleccionar") + $ListDex->lists('distributor','distributor');

        $ListTypeStore = $this->StoreRepo->getTypeStoreForCampaigne($company_id);
        $typeStore = array(0 => "Seleccionar") + $ListTypeStore->lists('tipo_bodega','tipo_bodega');

        $QuestionOpen = $this->pollArray[$company_id]['permitio'];
        $sino=$this->PollDetailRepo->getTotalSiNo($QuestionOpen,"0","0","0","0","0","0",$ubigeoext,"0",$dexExt,$typeStoreExt);//dd($sino);
        //getTotalSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0")
        //$poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0"
        $totalAbiertos = $sino['si'];
        if ($cantidadStoresRouting==0){$totalAbiertos=0;}

        if ($audit_id==3){
            $publicities = $this->PublicityRepo->getPublicityForCatMat($this->datosGenerales[$company_id]['catExhibidor'],$company_id);//dd($publicities[0]);

            foreach ($publicities as $publicity)
            {
                $storesForConditionEncontrados = $this->PublicitiesDetailRepo->getTotalStoresForPublicity($publicity->id,$company_id,$ubigeoext,$dexExt,$typeStoreExt);
                //getTotalStoresForPublicity($publicity_id,$company_id,$city = "0",$dex="0",$type_store = "0")
                $noEncontrados = $totalAbiertos-$storesForConditionEncontrados;
                $valSiNo[0] = array("tipo" => 'Si', "cantidad" => $storesForConditionEncontrados, "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No', "cantidad" => $noEncontrados, "color" => '#FE0000');
                $valEncontradosJson =json_encode($valSiNo);unset($valSiNo);

                $storesForConditionVisible = $this->PublicitiesDetailRepo->getFewStoresForVisible($publicity->id,1,$company_id,$ubigeoext,$dexExt,$typeStoreExt);
                //getFewStoresForVisible($publicity_id,$valor,$company_id,$city = "0",$dex="0",$type_store = "0")
                $noVisible = $storesForConditionEncontrados-$storesForConditionVisible;
                $valSiNo[0] = array("tipo" => 'Si', "cantidad" => $storesForConditionVisible, "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No', "cantidad" => $noVisible, "color" => '#FE0000');
                $valVisibleJson =json_encode($valSiNo);unset($valSiNo);

                $storesForConditionContamined = $this->PublicitiesDetailRepo->getFewStoresForContaminated($publicity->id,1,$company_id,$ubigeoext,$dexExt,$typeStoreExt);
                $noContaminado = $storesForConditionEncontrados-$storesForConditionContamined;
                $valSiNo[0] = array("tipo" => 'Si', "cantidad" => $storesForConditionContamined, "color" => '#FE0000');
                $valSiNo[1] = array("tipo" => 'No', "cantidad" => $noContaminado, "color" => '#FFFF00');
                $valContaminedJson =json_encode($valSiNo);unset($valSiNo);

                $exhibidores[] = array('id'=>$publicity->id,'nombre'=>$publicity->fullname,'totalEncontrado' => $storesForConditionEncontrados, 'graficoEncontrados' =>$valEncontradosJson, 'totalVisible'=>$storesForConditionVisible,'graficoVisible' =>$valVisibleJson, 'totalContamined'=>$storesForConditionContamined,'graficoContamined' =>$valContaminedJson);
            }
            //dd($exhibidores);
            return View::make('report/alicorp/auditExhibidorAlicorp3',compact('typeStoreExt','dexExt','ubigeo','ubigeoext','typeStore','dex','totalAbiertos','urlBase','campaignes','valores','objAudit','menus','company_id','audit_id','exhibidores','logo','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','titulo'));
        }
        if ($audit_id==2){

            $catMaterials = $this->categoryProductRepo->getCatMaterialsForCustomer($customer->id,0);
            $categorias = array(0 => "Seleccionar") + $catMaterials->lists('fullname','id');

            if ($categoria<>"0"){
                $objCategoria=$this->categoryProductRepo->find($categoria);$categoriaExt = $objCategoria->fullname;
                $productsPresence =$this->presenceRepo->getProductsForCampaigne($company_id,$categoria);//dd($productsPresence[0]);
                $countProductsPresence = count($productsPresence);
                foreach ($productsPresence as $presence)
                {
                    $presenceFound=$this->PresenceDetailRepo->getPresenceFound($company_id,$presence->id,$ubigeoext,$categoria,$dexExt);//dd($presence->id);
                    $cantidadOption = count($presenceFound);$totalesPresence[$presence->id] = $cantidadOption;
                    if ($totalAbiertos <> 0) {
                        $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                    } else {
                        $porcOpcion = 0;
                    }
                    $ValRespuesta = trim($presence->fullname);
                    $totalOptions[] = array('cantidad' => $cantidadOption, 'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                }//dd($totalesPresence);
                arsort($totalOptions);//dd($totalOptions);
                foreach ($totalOptions as $totalOptions1) {
                    $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                }
                $valEncontradosJson = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

                $subTitulo = 'Total de productos '.$countProductsPresence;
                $valMSLMMJson=0;$valMSLBCJson=0;$valMSLATJson=0;

                //visible
                /*foreach ($productsPresence as $presence)
                {
                    $presenceVisble=$this->PresenceDetailRepo->getPriceVisible($company_id,$presence->id,1,$ubigeoext,$categoria);//dd($presenceFound[0]);
                    $cantidadVisible= count($presenceVisble);
                    if ($totalAbiertos <> 0) {
                        $porcOpcion = ($cantidadVisible / $totalAbiertos) * 100;
                    } else {
                        $porcOpcion = 0;
                    }
                    $ValRespuesta = trim($presence->fullname);
                    $totalOptions[] = array('cantidad' => $cantidadVisible, 'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                }
                arsort($totalOptions);//dd($totalOptions);
                foreach ($totalOptions as $totalOptions1) {
                    $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                }
                $valVisiblesJson = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);*/

                //ok
                foreach ($productsPresence as $presence)
                {
                    $presenceOk=$this->PresenceDetailRepo->getPriceFound($company_id,$presence->id,1,$ubigeoext,$categoria,$dexExt);//dd($presenceOk[0]);
                    $cantidadOk= 0;$total=$totalesPresence[$presence->id];//dd($total);
                    foreach ($presenceOk as $ok)
                    {
                        if ($ok->visible_price==1){
                            $cantidadOk = $cantidadOk+1;
                        }
                    }
                    if ($total <> 0) {
                        $porcOpcion = ($cantidadOk / $total) * 100;
                    } else {
                        $porcOpcion = 0;
                    }
                    $ValRespuesta = trim($presence->fullname);
                    $totalOptions[] = array('cantidad' => $cantidadOk, 'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                }
                arsort($totalOptions);//dd($totalOptions);
                foreach ($totalOptions as $totalOptions1) {
                    $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                }
                $valOkJson = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);

            }else{
                $categoriaExt="0";
                $valEncontradosJson=array('respuesta' => '', 'cantidad' => 0, "porcentaje" => 0);$subTitulo="";
                $valVisiblesJson=array('respuesta' => '', 'cantidad' => 0, "porcentaje" => 0);

                $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLMM'],$company_id,'Mini Market',$ubigeoext,$dexExt);//dd($company_id);
                $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                $valMSLMMJson =json_encode($valSiNo);unset($valSiNo);

                $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLBC'],$company_id,'Bodega Clásica',$ubigeoext,$dexExt);
                $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                $valMSLBCJson =json_encode($valSiNo);unset($valSiNo);

                $limaMM = $this->countStoresConditionMSL($this->datosGenerales[$company_id]['MSLAT'],$company_id,'Bodega Alto Tráfico',$ubigeoext,$dexExt);
                $valSiNo[0] = array("tipo" => 'Cumple', "cantidad" => $limaMM['cumple'], "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No Cumple', "cantidad" => $limaMM['nocumple'], "color" => '#FE0000');
                $valMSLATJson =json_encode($valSiNo);unset($valSiNo);
            }


            if ($categoria<>"0"){
                $subTitulo .=" categoría ".$objCategoria->fullname;
            }
            return View::make('report/alicorp/auditPresenceAlicorp3',compact('categoriaExt','typeStoreExt','dexExt','dex','totalAbiertos','urlBase','campaignes','valOkJson','valMSLATJson','valMSLBCJson','valMSLMMJson','categoria','ubigeoext','categorias','ubigeo','subTitulo','objAudit','valEncontradosJson','menus','company_id','audit_id','logo','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','titulo'));
        }

        if ($audit_id==1){
            $publicities = $this->PublicityRepo->getPublicityForCatMat($this->datosGenerales[$company_id]['catSod'],$company_id);
            $categorias = array(0 => "Seleccionar") + $publicities->lists('fullname','id');

            if ($sw=="0")
            {
                $subTitulo = "Ventanas encontradas (Permitieron auditoria ".$totalAbiertos." PDV) ";//dd($publicities[1]);
                foreach ($publicities as $publicity)
                { //existeSOD

                    $listOption = $this->PublicitiesDetailRepo->getCountStoresForPublicity($company_id,$publicity->id,0,$ubigeoext,$dexExt,$typeStoreExt);
                    $cantidadOption = count($listOption);

                    if ($this->pollArray[$company_id]['existeSOD']==0)
                    {
                        if ($totalAbiertos <> 0) {
                            $porcOpcion = ($cantidadOption / $totalAbiertos) * 100;
                        } else {
                            $porcOpcion = 0;
                        }
                        $ValRespuesta = trim($publicity->fullname);
                        $totalOptions[] = array('cantidad' => $cantidadOption, 'respuesta' => $ValRespuesta, "porcentaje" => round($porcOpcion, 0));
                        $totalCategory[$ValRespuesta] = array( 'cantidad' => $cantidadOption);
                    }else{
                        $existeSOD=$this->PollDetailRepo->getTotalSiNoPublicity($this->pollArray[$company_id]['existeSOD'],$publicity->id,$ubigeoext,$dexExt,$typeStoreExt);

                        if ($totalAbiertos <> 0) {
                            $porcExisteSOD= ($existeSOD['si'] / $totalAbiertos) * 100;
                        } else {
                            $porcExisteSOD = 0;
                        }
                        $ValRespuesta = trim($publicity->fullname);
                        $totalOptions[] = array('cantidad' => $existeSOD['si'], 'respuesta' => $ValRespuesta, "porcentaje" => round($porcExisteSOD, 0));
                        $totalCategory[$ValRespuesta] = array( 'cantidad' => $existeSOD['si']);
                    }

                    $sumSOD=0; $contarSOD=0;
                   foreach ($listOption as $publicity_detail)
                   {
                       if ($publicity_detail->sod>0){
                           $sumSOD=$sumSOD + $publicity_detail->sod;
                           $contarSOD = $contarSOD +1;
                       }
                   }
                    if ($contarSOD ==0 )
                    {
                        $promedioSOD = 0;
                    }else{
                        $promedioSOD = $sumSOD/$contarSOD;
                    }
                    $sodObjetivo = $publicity->sod;
                    $totalSODObj[] = array('respuesta' => 'Promedio SOD', 'cantidad' => $promedioSOD, "porcentaje" => round(($promedioSOD)*100, 0));
                    $totalOptionSODObj = json_encode($totalSODObj);unset($totalSODObj);

                    $sinoSODW=$this->PollDetailRepo->getTotalSiNoPublicity($this->pollArray[$company_id]['sodW'],$publicity->id,$ubigeoext,$dexExt,$typeStoreExt);//dd($sinoSODW);

                    //$totalesSODW = $sinoSODW['si'] + $sinoSODW['no'];
                    $totalesSODW = $totalCategory[$publicity->fullname]['cantidad'];
                    if ($totalesSODW <> 0) {
                        $porcSODW= ($sinoSODW['si'] / $totalesSODW) * 100;$porcSODNoW = ($sinoSODW['no']/$totalesSODW)*100;
                    } else {
                        $porcSODW = 0;$porcSODNoW=0;
                    }

                    $totalSODW[] = array('respuesta' => 'Vent. Trabajadas', 'cantidad' => $sinoSODW['si'], "porcentaje" => round($porcSODW, 0));
                    $totalSODW[] = array('respuesta' => 'Vent. No Trabajadas', 'cantidad' => $sinoSODW['no'], "porcentaje" => round($porcSODNoW, 0));
                    $totalOptionSODW = json_encode($totalSODW);unset($totalSODW);

                    if ($company_id>21)
                    {
                        $sinoSODW=$this->PollDetailRepo->getTotalSiNoPublicity($this->pollArray[$company_id]['ventVisible'],$publicity->id,$ubigeoext,$dexExt,$typeStoreExt);//dd($sinoSODW);
                        $totalesSODW = $sinoSODW['si'] + $sinoSODW['no'];
                        if ($totalesSODW <> 0) {
                            $porcSODW= ($sinoSODW['si'] / $totalesSODW) * 100;$porcSODNoW = ($sinoSODW['no']/$totalesSODW)*100;
                        } else {
                            $porcSODW = 0;$porcSODNoW=0;
                        }

                        $totalSODW[] = array('respuesta' => 'Vent. Visible', 'cantidad' => $sinoSODW['si'], "porcentaje" => round($porcSODW, 0));
                        $totalSODW[] = array('respuesta' => 'Vent. No Visible', 'cantidad' => $sinoSODW['no'], "porcentaje" => round($porcSODNoW, 0));
                        $totalOptionVentVisible = json_encode($totalSODW);unset($totalSODW);

                        //Como esta la ventana
                        $options1= $this->PollOptionRepo->getOptions($this->pollArray[$company_id]['hayVentana']);$cantidadTotal=0;
                        foreach ($options1 as $option){
                            $cantidadOption=$this->PollOptionDetailRepo->getTotalOptionPublicity($publicity->id,$option->id, $ubigeoext,$dexExt,$typeStoreExt);

                            $cantidadTotal = $cantidadTotal +$cantidadOption;
                        }
                        foreach ($options1 as $option) {
                            $cantidadOption = $this->PollOptionDetailRepo->getTotalOptionPublicity($publicity->id,$option->id, $ubigeoext,$dexExt,$typeStoreExt);
                            if ($cantidadTotal <> 0) {
                                $porcComoEstaSOD = ($cantidadOption / $cantidadTotal) * 100;
                            } else {
                                $porcComoEstaSOD = 0;
                            }
                            $ultimoOption = $option->id;
                            $ValRespuesta = trim($option->options_abreviado);

                            $totalOptionsComoEstaVent[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcComoEstaSOD, 0));
                        }

                        //Ordenando Como esta Vent.
                        arsort($totalOptionsComoEstaVent);
                        foreach ($totalOptionsComoEstaVent as $totalOptions1) {
                            $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'],'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                        }
                        $totalOptionComoEstaVentJSON = json_encode($totalOrdenado);unset($totalOptionsComoEstaVent);unset($totalOrdenado);

                        // --//
                    }else{
                        $totalOptionVentVisible = array('respuesta' => '', 'cantidad' => 0, "porcentaje" => 0);
                        $totalOptionsComoEstaVent[] = array('respuesta' => '','cantidad' => 0,  "porcentaje" => 0);
                        $totalOptionComoEstaVentJSON = json_encode($totalOptionsComoEstaVent);
                    }

                    if ($promedioSOD>$sodObjetivo){$color='#5EB423';}else{$color='#FD000D';}

                    $valoresSOD[] = array('color'=>$color,'id'=>$publicity->id,'SODObjetivo'=> $sodObjetivo,'publicity'=>$publicity->fullname, 'objetivoSOD' =>$totalOptionSODObj, 'trabajadoSOD' => $totalOptionSODW, 'VentVisible' => $totalOptionVentVisible, 'ComoEstaVent' => $totalOptionComoEstaVentJSON);

                }
                arsort($totalOptions);//dd($totalOptions);
                foreach ($totalOptions as $totalOptions1) {
                    $totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
                }
                $totalOptionSODJSON = json_encode($totalOrdenado);unset($totalOptions);unset($totalOrdenado);
                $valEncimaSodJson="0";

            }else{

                $totalOptionSODJSON=array();
                $objPublicity = $this->PublicityRepo->find($categoria);
                $listStores = $this->PublicitiesDetailRepo->getCountStoresForPublicity($company_id,$categoria,0,$ubigeoext,$dexExt,$typeStoreExt);$contSod=0;

                $cantidadOption = count($listStores);
                foreach ($listStores as $publicity)
                {
                    if ($publicity->sod<>0)
                    {
                        $contSod = $contSod +1;
                    }
                }
                $subTitulo = "Cantidad ".$objPublicity->fullname. ' encontrado '.$cantidadOption;

                $noEncontrados = $cantidadOption-$contSod;
                $valSiNo[0] = array("tipo" => 'Si', "cantidad" => $contSod, "color" => '#FFFF00');
                $valSiNo[1] = array("tipo" => 'No', "cantidad" => $noEncontrados, "color" => '#FE0000');
                $valEncimaSodJson =json_encode($valSiNo);unset($valSiNo);

            }
            $poll_sodW = $this->pollArray[$company_id]['sodW'];
            $poll_sodVisible = $this->pollArray[$company_id]['ventVisible'];
            $poll_sodComoEstaVent = $this->pollArray[$company_id]['hayVentana'];
            $option_id_ult_ComoEstaVent = $ultimoOption;
                //dd($valoresSOD);
            return View::make('report/alicorp/auditSODAlicorp3',compact('totalOptionVentVisible','typeStoreExt','dexExt','typeStore','dex','totalAbiertos','urlBase','campaignes','poll_sodW','poll_sodVisible','poll_sodComoEstaVent','option_id_ult_ComoEstaVent','sodObjetivo','valoresSOD','valEncimaSodJson','ubigeoext','ubigeo','subTitulo','objAudit','totalOptionSODJSON','menus','company_id','audit_id','logo','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','titulo'));
        }

    }

    public function getDetailPublicitiesCondition($publicity_id,$values,$contaminated,$company_id)
    {
        $audit_id ='0';

        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';
        $valores = explode('-',$values);//$valCiudad = "0-0-0-0-".$ubigeoext.'-'.$cadena; IBK:$valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $city = $valores[0];  //route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
        $dex = $valores[1];
        $menus = $this->generateMenusAlicorp($company_id,$audit_id);

        $datosStores = $this->getDetailPublicitiesAlicorp($publicity_id,$contaminated,$urlBase,$urlImages,$valores,$company_id);

        $campaigne = $this->companyRepo->find($company_id);
        $campaigne_name = $campaigne->fullname;//dd($campaigne_name);

        return View::make('report/alicorp/detailPublicities', compact('menus','company_id','city','dex','audit_id','datosStores','campaigne_name'));
    }

    public function getDetailMediasPublic($company_id="0",$audit_id="0",$category_product_id="0",$store_id="0",$poll_id="0")
    {
        $titulo = "Detalle Objeto tipo Fotos ";
        $detailAudit = $this->auditRepo->find($audit_id);//dd($detailAudit);
        $objRoadDetail = $this->roadDetailRepo->getRoadForStoreCompany($store_id,$company_id);//dd($objRoadDetail[0]);
        $campaigne = $this->companyRepo->find($company_id);//dd($campaigne);
        $customer =$this->customerRepo->find($campaigne->customer_id);//dd($customer);
        $objStore = $this->StoreRepo->find($store_id);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $url_image = $this->urlBase.$this->urlImages;
        $photos = $this->getPhotos($poll_id,$store_id,$company_id,"0","0",$category_product_id);//dd($photos);
        return View::make('medias/detailPhotosPublic', compact('photos','url_image','objRoadDetail','objStore','campaigne','customer','titulo','logo','detailAudit'));
    }

}
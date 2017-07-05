<?php

use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\AuditRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\RoadRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\CustomerRepo;

class ReportController extends BaseController{

    protected $CompanyRepo;
    protected $UserCompanyRepo;
    protected $PollRepo;
    protected $CompanyAuditRepo;
    protected $PollDetailRepo;
    protected $PollOptionRepo;
    protected $PollOptionDetailRepo;
    protected $AuditRepo;
    protected $AuditRoadStoreRepo;
    protected $RoadDetailRepo;
    protected $storeRepo;
    protected $MediaRepo;
    protected $disponible0;
    protected $realizoOp0;
    protected $transEx0;
    protected $disposicion0;
    protected $conocimiento0;
    protected $amabilidad0;
    protected $customerRepo;
    protected $RoadRepo;

    public $RutasPorEmpresa;
    public $Empresas;
    public $CantidadTiendasPorEmpresa;
    public $CantidadTiendasAuditadas;
    public $NroReportes;
    public $urlBase;
    public $urlImages;
    public $pollUsados;


    public function __construct(RoadRepo $RoadRepo,CustomerRepo $customerRepo,MediaRepo $MediaRepo,StoreRepo $storeRepo, RoadDetailRepo $RoadDetailRepo,CompanyStoreRepo $CompanyStoreRepo,AuditRoadStoreRepo $AuditRoadStoreRepo,AuditRepo $AuditRepo,CompanyRepo $CompanyRepo, UserCompanyRepo $userCompanyRepo, PollRepo $PollRepo, CompanyAuditRepo $CompanyAuditRepo, PollDetailRepo $PollDetailRepo,PollOptionRepo $pollOptionRepo, PollOptionDetailRepo $PollOptionDetailRepo)
    {
        $this->RoadDetailRepo = $RoadDetailRepo;
        $this->CompanyStoreRepo = $CompanyStoreRepo;
        $this->AuditRoadStoreRepo = $AuditRoadStoreRepo;
        $this->AuditRepo = $AuditRepo;
        $this->CompanyRepo = $CompanyRepo;
        $this->UserCompanyRepo = $userCompanyRepo;
        $this->PollRepo = $PollRepo;
        $this->CompanyAuditRepo = $CompanyAuditRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->PollOptionRepo = $pollOptionRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->customerRepo = $customerRepo;
        $this->storeRepo = $storeRepo;
        $this->MediaRepo = $MediaRepo;
        $this->RoadRepo = $RoadRepo;

        $campaigne = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $campany_id = $campaigne[0]->id;
        
        $questionComparations = array('disponible'=>'¿Se encuentra abierto el agente?','realizoOp'=>'Al preguntar si se podía hacer la operación correspondiente, ¿el dependiente aceptó realizar la operación?','transEx'=>'¿La transacción se llegó a realizar de manera exitosa?  (Se considera exitosa cuando se entrega el voucher)','amabilidad'=>'En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías la amabilidad de la persona que te atendió?','conocimiento'=>'En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías el conocimiento de la persona que lo atendió?','disposicion'=>'En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías la disposición de la persona que lo atendió?');
        $valoresDisponible = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['disponible']);//dd($valoresDisponible[0]);
        foreach ($valoresDisponible as $disponible)
        {
            if ($campany_id <> $disponible->company_id)
            {
                $this->disponible0[$disponible->company_id] = $disponible->id;
            }
        }
        //$this->disponible0=array(27,67,99,138,165);
        $valoresRealizoOp = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['realizoOp']);
        foreach ($valoresRealizoOp as $realizoOp)
        {
            if ($campany_id <> $realizoOp->company_id)
            {
                $this->realizoOp0[$realizoOp->company_id] = $realizoOp->id;
            }
        }
        //$this->realizoOp0=array(7,47,79,118,173);
        $valoresTransEx = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['transEx']);
        foreach ($valoresTransEx as $transEx)
        {
            if ($campany_id <> $transEx->company_id)
            {
                $this->transEx0[$transEx->company_id] = $transEx->id;
            }
        }
        //$this->transEx0=array(12,52,84,123,178);
        $valoresAmabilidad = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['amabilidad']);
        foreach ($valoresAmabilidad as $amabilidad)
        {
            if ($campany_id <> $amabilidad->company_id)
            {
                $this->amabilidad0[$amabilidad->company_id] = $amabilidad->id;
            }
        }
        //$this->amabilidad0=array(17,57,89,128,186);
        $valoresConocimiento = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['conocimiento']);
        foreach ($valoresConocimiento as $conocimiento)
        {
            if ($campany_id <> $conocimiento->company_id)
            {
                $this->conocimiento0[$conocimiento->company_id] = $conocimiento->id;
            }
        }
        //$this->conocimiento0=array(18,58,90,129,187);
        $valoresDisposicion = $this->PollRepo->getIdsForQuestionForCompany($questionComparations['disposicion']);
        foreach ($valoresDisposicion as $disposicion)
        {
            if ($campany_id <> $disposicion->company_id)
            {
                $this->disposicion0[$disposicion->company_id] = $disposicion->id;
            }
        }
        //$this->disposicion0=array(19,59,91,130,188);
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/images/';

        $this->pollUsados[1] = array('rubroPoll'=> 26,'opcionRubro'=>58,'abierto' => 27,'abiertoLocalCerrado'=>'','abiertoYaNoAgente'=>'','abiertoPidioRetiro'=>'','entregoVoucher'=>'', 'exterior' => 2,'interior' =>3,'AceptoOperacion'=>7,'OperacionExitosa'=>12,'porqueNoTransOK'=>16,'porqueNoTransOKOpcionOtro'=>20,'solucionTrans'=>25,'solucionTransOpcionOtro'=>59,'cobroFueraVoucher'=>'','ConvienePagarFono'=> 24,'porqueNoAtendioInmediato'=>9,'preocupoPorSuTiempo'=>10,'despuesDeEsperar'=>11,'escogerTipoTrans'=>28);
        $this->pollUsados[8] = array('rubroPoll'=> 66,'opcionRubro'=>210,'abierto' => 67,'abiertoLocalCerrado'=>222,'abiertoYaNoAgente'=>223,'abiertoPidioRetiro'=>224,'entregoVoucher'=>53, 'exterior' => 42,'interior' =>43,'AceptoOperacion'=>47,'OperacionExitosa'=>52,'porqueNoTransOK'=>56,'porqueNoTransOKOpcionOtro'=>174,'solucionTrans'=>65,'solucionTransOpcionOtro'=>211,'cobroFueraVoucher'=>70,'ConvienePagarFono'=> 64,'porqueNoAtendioInmediato'=>49,'preocupoPorSuTiempo'=>50,'despuesDeEsperar'=>51,'escogerTipoTrans'=>68);
        $this->pollUsados[10] = array('rubroPoll'=> 98,'opcionRubro'=>278,'abierto' => 99,'abiertoLocalCerrado'=>288,'abiertoYaNoAgente'=>289,'abiertoPidioRetiro'=>290,'entregoVoucher'=>85, 'exterior' => 74,'interior' =>75,'AceptoOperacion'=>79,'OperacionExitosa'=>84,'porqueNoTransOK'=>88,'porqueNoTransOKOpcionOtro'=>242,'solucionTrans'=>97,'solucionTransOpcionOtro'=>279,'cobroFueraVoucher'=>102,'ConvienePagarFono'=> 96,'porqueNoAtendioInmediato'=>81,'preocupoPorSuTiempo'=>82,'despuesDeEsperar'=>83,'escogerTipoTrans'=>100);
        $this->pollUsados[12] = array('rubroPoll'=> 137,'opcionRubro'=>393,'abierto' => 138,'abiertoLocalCerrado'=>394,'abiertoYaNoAgente'=>395,'abiertoPidioRetiro'=>396,'entregoVoucher'=>124, 'exterior' => 113,'interior' =>114,'AceptoOperacion'=>118,'OperacionExitosa'=>123,'porqueNoTransOK'=>127,'porqueNoTransOKOpcionOtro'=>356,'solucionTrans'=>136,'solucionTransOpcionOtro'=>387,'cobroFueraVoucher'=>141,'ConvienePagarFono'=> 135,'porqueNoAtendioInmediato'=>120,'preocupoPorSuTiempo'=>121,'despuesDeEsperar'=>122,'escogerTipoTrans'=>139);
        $this->pollUsados[14] = array('rubroPoll'=> 164,'opcionRubro'=>521,'abierto' => 165,'abiertoLocalCerrado'=>522,'abiertoYaNoAgente'=>523,'abiertoPidioRetiro'=>524,'entregoVoucher'=>179, 'exterior' => 166,'interior' =>167,'AceptoOperacion'=>173,'OperacionExitosa'=>178,'porqueNoTransOK'=>182,'porqueNoTransOKOpcionOtro'=>546,'solucionTrans'=>183,'solucionTransOpcionOtro'=>577,'cobroFueraVoucher'=>185,'ConvienePagarFono'=> 171,'porqueNoAtendioInmediato'=>175,'preocupoPorSuTiempo'=>176,'despuesDeEsperar'=>177,'escogerTipoTrans'=>184);
        $this->pollUsados[20] = array('rubroPoll'=> 218,'opcionRubro'=>705,'abierto' => 219,'abiertoLocalCerrado'=>706,'abiertoYaNoAgente'=>707,'abiertoPidioRetiro'=>708,'entregoVoucher'=>233, 'exterior' => 220,'interior' =>221,'AceptoOperacion'=>227,'OperacionExitosa'=>232,'porqueNoTransOK'=>236,'porqueNoTransOKOpcionOtro'=>730,'solucionTrans'=>237,'solucionTransOpcionOtro'=>761,'cobroFueraVoucher'=>239,'ConvienePagarFono'=> 225,'porqueNoAtendioInmediato'=>229,'preocupoPorSuTiempo'=>230,'despuesDeEsperar'=>231,'escogerTipoTrans'=>238);
        $this->pollUsados[26] = array('rubroPoll'=> 350,'opcionRubro'=>1002,'abierto' => 351,'abiertoLocalCerrado'=>1003,'abiertoYaNoAgente'=>1004,'abiertoPidioRetiro'=>1005,'entregoVoucher'=>365, 'exterior' => 352,'interior' =>353,'AceptoOperacion'=>359,'OperacionExitosa'=>364,'porqueNoTransOK'=>368,'porqueNoTransOKOpcionOtro'=>1031,'solucionTrans'=>369,'solucionTransOpcionOtro'=>1035,'cobroFueraVoucher'=>371,'ConvienePagarFono'=> 357,'porqueNoAtendioInmediato'=>361,'preocupoPorSuTiempo'=>362,'despuesDeEsperar'=>363,'escogerTipoTrans'=>370,'disposicion' =>374,'amabilidad' =>372,'conocimiento' =>373);
        $this->pollUsados[31] = array('rubroPoll'=> 393,'opcionRubro'=>1128,'abierto' => 394,'abiertoLocalCerrado'=>1129,'abiertoYaNoAgente'=>1130,'abiertoPidioRetiro'=>1131,'entregoVoucher'=>408, 'exterior' => 395,'interior' =>396,'AceptoOperacion'=>402,'OperacionExitosa'=>407,'porqueNoTransOK'=>411,'porqueNoTransOKOpcionOtro'=>1157,'solucionTrans'=>412,'solucionTransOpcionOtro'=>1161,'cobroFueraVoucher'=>414,'ConvienePagarFono'=> 400,'porqueNoAtendioInmediato'=>404,'preocupoPorSuTiempo'=>405,'despuesDeEsperar'=>406,'escogerTipoTrans'=>413,'disposicion' =>417,'amabilidad' =>415,'conocimiento' =>416);
        $this->pollUsados[34] = array('rubroPoll'=> 451,'opcionRubro'=>1356,'abierto' => 452,'abiertoLocalCerrado'=>1357,'abiertoYaNoAgente'=>1358,'abiertoPidioRetiro'=>1359,'entregoVoucher'=>466, 'exterior' => 453,'interior' =>454,'AceptoOperacion'=>460,'OperacionExitosa'=>465,'porqueNoTransOK'=>469,'porqueNoTransOKOpcionOtro'=>1385,'solucionTrans'=>470,'solucionTransOpcionOtro'=>1389,'cobroFueraVoucher'=>472,'ConvienePagarFono'=> 458,'porqueNoAtendioInmediato'=>462,'preocupoPorSuTiempo'=>463,'despuesDeEsperar'=>464,'escogerTipoTrans'=>471,'disposicion' =>475,'amabilidad' =>473,'conocimiento' =>474);
        $this->pollUsados[40] = array('rubroPoll'=> 527,'opcionRubro'=>1669,'abierto' => 528,'abiertoLocalCerrado'=>1670,'abiertoYaNoAgente'=>1671,'abiertoPidioRetiro'=>1672,'entregoVoucher'=>542, 'exterior' => 529,'interior' =>530,'AceptoOperacion'=>536,'OperacionExitosa'=>541,'porqueNoTransOK'=>545,'porqueNoTransOKOpcionOtro'=>1698,'solucionTrans'=>546,'solucionTransOpcionOtro'=>1702,'cobroFueraVoucher'=>548,'ConvienePagarFono'=> 534,'porqueNoAtendioInmediato'=>538,'preocupoPorSuTiempo'=>539,'despuesDeEsperar'=>540,'escogerTipoTrans'=>547,'disposicion' =>551,'amabilidad' =>549,'conocimiento' =>550);
        $this->pollUsados[45] = array('rubroPoll'=> 581,'opcionRubro'=>1940,'abierto' => 582,'abiertoLocalCerrado'=>1941,'abiertoYaNoAgente'=>1942,'abiertoPidioRetiro'=>1943,'entregoVoucher'=>596, 'exterior' => 583,'interior' =>584,'AceptoOperacion'=>590,'OperacionExitosa'=>595,'porqueNoTransOK'=>599,'porqueNoTransOKOpcionOtro'=>1969,'solucionTrans'=>600,'solucionTransOpcionOtro'=>1973,'cobroFueraVoucher'=>602,'ConvienePagarFono'=> 588,'porqueNoAtendioInmediato'=>592,'preocupoPorSuTiempo'=>593,'despuesDeEsperar'=>594,'escogerTipoTrans'=>601,'disposicion' =>605,'amabilidad' =>603,'conocimiento' =>604);
        $this->pollUsados[49] = array('rubroPoll'=> 679,'opcionRubro'=>2181,'abierto' => 680,'abiertoLocalCerrado'=>2182,'abiertoYaNoAgente'=>2183,'abiertoPidioRetiro'=>2184,'entregoVoucher'=>694, 'exterior' => 681,'interior' =>682,'AceptoOperacion'=>688,'OperacionExitosa'=>693,'porqueNoTransOK'=>697,'porqueNoTransOKOpcionOtro'=>2210,'solucionTrans'=>698,'solucionTransOpcionOtro'=>2214,'cobroFueraVoucher'=>700,'ConvienePagarFono'=> 686,'porqueNoAtendioInmediato'=>690,'preocupoPorSuTiempo'=>691,'despuesDeEsperar'=>692,'escogerTipoTrans'=>699,'disposicion' =>703,'amabilidad' =>701,'conocimiento' =>702);
        $this->pollUsados[51] = array('rubroPoll'=> 718,'opcionRubro'=>2256,'abierto' => 719,'abiertoLocalCerrado'=>2257,'abiertoYaNoAgente'=>2258,'abiertoPidioRetiro'=>2259,'entregoVoucher'=>733, 'exterior' => 720,'interior' =>721,'AceptoOperacion'=>727,'OperacionExitosa'=>732,'porqueNoTransOK'=>736,'porqueNoTransOKOpcionOtro'=>2285,'solucionTrans'=>737,'solucionTransOpcionOtro'=>2289,'cobroFueraVoucher'=>739,'ConvienePagarFono'=> 725,'porqueNoAtendioInmediato'=>729,'preocupoPorSuTiempo'=>730,'despuesDeEsperar'=>731,'escogerTipoTrans'=>738,'disposicion' =>742,'amabilidad' =>740,'conocimiento' =>741);
        $this->pollUsados[57] = array('rubroPoll'=> 801,'opcionRubro'=>2429,'abierto' => 802,'abiertoLocalCerrado'=>2430,'abiertoYaNoAgente'=>2431,'abiertoPidioRetiro'=>2432,'entregoVoucher'=>816, 'exterior' => 803,'interior' =>804,'AceptoOperacion'=>810,'OperacionExitosa'=>815,'porqueNoTransOK'=>819,'porqueNoTransOKOpcionOtro'=>2459,'solucionTrans'=>820,'solucionTransOpcionOtro'=>2463,'cobroFueraVoucher'=>822,'ConvienePagarFono'=> 808,'porqueNoAtendioInmediato'=>812,'preocupoPorSuTiempo'=>813,'despuesDeEsperar'=>814,'escogerTipoTrans'=>821,'disposicion' =>825,'amabilidad' =>823,'conocimiento' =>824);
        $this->pollUsados[64] = array('rubroPoll'=> 903,'opcionRubro'=>2647,'abierto' => 904,'abiertoLocalCerrado'=>2648,'abiertoYaNoAgente'=>2649,'abiertoPidioRetiro'=>2650,'entregoVoucher'=>918, 'exterior' => 905,'interior' =>906,'AceptoOperacion'=>912,'OperacionExitosa'=>917,'porqueNoTransOK'=>921,'porqueNoTransOKOpcionOtro'=>2677,'solucionTrans'=>922,'solucionTransOpcionOtro'=>2681,'cobroFueraVoucher'=>924,'ConvienePagarFono'=> 910,'porqueNoAtendioInmediato'=>914,'preocupoPorSuTiempo'=>915,'despuesDeEsperar'=>916,'escogerTipoTrans'=>923,'disposicion' =>927,'amabilidad' =>925,'conocimiento' =>926);
        $this->pollUsados[69] = array('rubroPoll'=> 983,'opcionRubro'=>2843,'abierto' => 984,'abiertoLocalCerrado'=>2844,'abiertoYaNoAgente'=>2845,'abiertoPidioRetiro'=>2846,'entregoVoucher'=>998, 'exterior' => 985,'interior' =>986,'AceptoOperacion'=>992,'OperacionExitosa'=>997,'porqueNoTransOK'=>1001,'porqueNoTransOKOpcionOtro'=>2873,'solucionTrans'=>1002,'solucionTransOpcionOtro'=>2877,'cobroFueraVoucher'=>1004,'ConvienePagarFono'=> 990,'porqueNoAtendioInmediato'=>994,'preocupoPorSuTiempo'=>995,'despuesDeEsperar'=>996,'escogerTipoTrans'=>1003,'disposicion' =>1007,'amabilidad' =>1005,'conocimiento' =>1006);
        $this->pollUsados[72] = array('rubroPoll'=> 1152,'opcionRubro'=>3166,'abierto' => 1153,'abiertoLocalCerrado'=>3167,'abiertoYaNoAgente'=>3168,'abiertoPidioRetiro'=>3169,'entregoVoucher'=>1167, 'exterior' => 1154,'interior' =>1155,'AceptoOperacion'=>1161,'OperacionExitosa'=>1166,'porqueNoTransOK'=>1170,'porqueNoTransOKOpcionOtro'=>3196,'solucionTrans'=>1171,'solucionTransOpcionOtro'=>3200,'cobroFueraVoucher'=>1173,'ConvienePagarFono'=> 1159,'porqueNoAtendioInmediato'=>1163,'preocupoPorSuTiempo'=>1164,'despuesDeEsperar'=>1165,'escogerTipoTrans'=>1172,'disposicion' =>1176,'amabilidad' =>1174,'conocimiento' =>1175);
        $this->pollUsados[76] = array('rubroPoll'=> 1251,'opcionRubro'=>3397,'abierto' => 1252,'abiertoLocalCerrado'=>3398,'abiertoYaNoAgente'=>3399,'abiertoPidioRetiro'=>3400,'entregoVoucher'=>1265, 'exterior' => 1253,'interior' =>1254,'AceptoOperacion'=>1260,'OperacionExitosa'=>1265,'porqueNoTransOK'=>1269,'porqueNoTransOKOpcionOtro'=>3427,'solucionTrans'=>1270,'solucionTransOpcionOtro'=>3431,'cobroFueraVoucher'=>1272,'ConvienePagarFono'=> 1258,'porqueNoAtendioInmediato'=>1262,'preocupoPorSuTiempo'=>1263,'despuesDeEsperar'=>1264,'escogerTipoTrans'=>1271,'disposicion' =>1275,'amabilidad' =>1273,'conocimiento' =>1274);
        $this->pollUsados[84] = array('rubroPoll'=> 1406,'opcionRubro'=>3614,'abierto' => 1407,'abiertoLocalCerrado'=>3615,'abiertoYaNoAgente'=>3616,'abiertoPidioRetiro'=>3617,'entregoVoucher'=>1420, 'exterior' => 1408,'interior' =>1409,'AceptoOperacion'=>1415,'OperacionExitosa'=>1420,'porqueNoTransOK'=>1424,'porqueNoTransOKOpcionOtro'=>3644,'solucionTrans'=>1425,'solucionTransOpcionOtro'=>3648,'cobroFueraVoucher'=>1427,'ConvienePagarFono'=> 1413,'porqueNoAtendioInmediato'=>1417,'preocupoPorSuTiempo'=>1418,'despuesDeEsperar'=>1419,'escogerTipoTrans'=>1426,'disposicion' =>1430,'amabilidad' =>1428,'conocimiento' =>1429);
    }

    public function getRoadsForCampaigne($company_id)
    {
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $titulo = $company[0]->fullname;
        $audit_id=0;
        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;
        $menus = $this->generateMenusInterbank($company_id,0,1);

        $roads =$this->AuditRoadStoreRepo->getRoadsResumeForCompany($company_id);//dd($roads);
        $cliente='IBK';

        return View::make('report/listRoads',compact('cliente','titulo','logo','menus','roads','audit_id','company_id'));

    }

    public function getDetailRoad($road_id,$company_id)
    {
        $road = $this->RoadRepo->find($road_id);
        $roadDetails = $this->RoadDetailRepo->getDetailStores($road_id);$auditados=0;
        $menus = $this->generateMenusInterbank($company_id,0,1);

        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $titulo = $company[0]->fullname;
        $audit_id=0;
        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        foreach ($roadDetails as  $roadDetail)
        {//dd($roadDetail);
            if($roadDetail->company_id==$company_id){
                $roadDetalles[] = $roadDetail;
                if($roadDetail->audit==1) $auditados ++;
            }
        }
        //dd($roadDetalles);
        return View::make('report/interbank/showRoad',compact('road','roadDetalles','auditados','menus','titulo','audit_id','logo'));
    }

    

    public function quantityStoresAudits($ciudad="0",$distrito = "0",$ejecutivo="0",$rubro="0")
    {

        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $roadsForCompany = $this->AuditRoadStoreRepo->getRoadsForCompany($company[0]->id);//dd(count($roadsForCompany));
        if (count($roadsForCompany)<>0){

            $CantidadStoresAudits = $this->RoadDetailRepo->getQuantityStoresAudits($roadsForCompany, 1,$ciudad,$distrito,$ejecutivo,$rubro);
            /*if ($CantidadStoresAudits==0){
                $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id);
            }else{
                $cantidadStoresForCompany = $this->RoadDetailRepo->getQuantityStoresAudits($roadsForCompany, 0, $ciudad,$distrito,$ejecutivo,$rubro);
            }*/
            $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id,$ciudad,$distrito,$ejecutivo,$rubro);
        }else{
            $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id,$ciudad,$distrito,$ejecutivo,$rubro);
            $CantidadStoresAudits = 0;
        }
        if ($company[0]->id==8){
            $cantidadStoresForCompany = $cantidadStoresForCompany;
        }

        $arrayGrafico[] = array('tipo' => 'Auditadas', 'cantidad' => $CantidadStoresAudits, 'color' => '#009B3A');
        $arrayGrafico[] = array('tipo' => 'No auditadas', 'cantidad' => $cantidadStoresForCompany - $CantidadStoresAudits, 'color' => '#0A246');
        //dd($arrayGrafico);
        $jsonCantidadStoresAudits = json_encode($arrayGrafico);
        $valorOutput[] = array('cantidadStoresForCompany' => $cantidadStoresForCompany, 'CantidadStoresAudits' => $CantidadStoresAudits, 'jsonCantidadStoresAudits' =>$jsonCantidadStoresAudits );
        return $valorOutput;
    }

    public function reportExcel()
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
        //dd($cantidadStoresForCompany);

        $valorNroReportes = $this->getNumberReports($cantidadStoresForCompany);
        //dd($valorNroReportes);
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        //dd($AuditsCompany );
        $audit_id ='excel';
        $company_id = $company[0]->id;
        $nroItems = $CantidadStoresAudits/50;
        $entItems = intval($nroItems);//dd($nroItems);
        $decItems = $nroItems - $entItems;
        if ($entItems>0){
            if ($decItems>0){
                $entItems = $entItems + 1;
            }
        }
        return View::make('report/interbank/reportExcel',compact('userType','AuditsCompany','audit_id','valorNroReportes', 'company_id','CantidadStoresAudits','cantidadStoresForCompany','entItems'));
    }


    public function reportHome()
    {
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        //dd($company);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        $titulo = $company[0]->fullname;
        //dd($AuditsCompany);
        $company_id=$company[0]->id;//dd($company_id);

        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $cantidadStoresForCampaigne = $this->CompanyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
        $cantidadStoresRouting = $this->CompanyStoreRepo->getStoresRoadsRouting($company_id);
        $cantidadStoresAudit = $this->CompanyStoreRepo->getStoresAuditRoadsRouting($company_id);

        $audit_id ="0";
        $menus = $this->generateMenusInterbank($company[0]->id,$audit_id);
        if ($userType){
            if (($company_id==1) or ($company_id==8) or ($company_id==10) or ($company_id==12) or ($company_id==14) or ($company_id==20) or ($company_id==26)or ($company_id==31) or ($company_id==34)or ($company_id>=40)){

                if ($company_id==8){

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        if ($city<>"0"){
                            if ($valoresPost['distrito']<>"0"){
                                $arrayDistrict = explode($city.'|',$valoresPost['distrito']);
                                $district = $arrayDistrict[1];
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo = $valoresPost['ejecutivo'];
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }else{
                                    $ejecutivo ="0";
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }
                            }else{
                                $district ="0";
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo =$valoresPost['ejecutivo'];
                                }else{
                                    $ejecutivo ="0";
                                }
                                if ($valoresPost['rubro']<>"0"){
                                    $rubro = $valoresPost['rubro'];
                                }else{
                                    $rubro ="0";
                                }
                            }
                        }else{
                            $district ="0";
                            if ($valoresPost['ejecutivo']<>"0"){
                                $ejecutivo =$valoresPost['ejecutivo'];
                            }else{
                                $ejecutivo ="0";
                            }
                            if ($valoresPost['rubro']<>"0"){
                                $rubro = $valoresPost['rubro'];
                            }else{
                                $rubro ="0";
                            }
                        }
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=52;
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);
                    //$valSiNo[0] = array("tipo" => 'Con Disposición', "Op. Con Exito" => $sino_conexito['si'], "Op. Sin Exito" => 0, "Ag. Cerrados" =>0,"Ag. No Aceptaron Trans."=>0);

                    /*$poll_cerrados=67;
                    $sino_cerrados=$this->PollDetailRepo->getTotalSiNo($poll_cerrados,$city,$district,$ejecutivo,$rubro);*/

                    $poll_notrans=47;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                    $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                    /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                    $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=57;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=58;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=59;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll(67);
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo(67, $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions(67);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 56

                            $options1= $this->PollOptionRepo->getOptions(56);$cantidadTotal=0;
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }

                if ($company_id==10){
                    $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
                    $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
                    //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
                    //dd($ListStoresUbigeo[0]);
                    foreach ($ListStoresUbigeo as $stores)
                    {
                        $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
                    }
                    //dd($val);

                    $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        if ($city<>"0"){
                            if ($valoresPost['distrito']<>"0"){
                                $arrayDistrict = explode($city.'|',$valoresPost['distrito']);
                                $district = $arrayDistrict[1];
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo = $valoresPost['ejecutivo'];
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }else{
                                    $ejecutivo ="0";
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }
                            }else{
                                $district ="0";
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo =$valoresPost['ejecutivo'];
                                }else{
                                    $ejecutivo ="0";
                                }
                                if ($valoresPost['rubro']<>"0"){
                                    $rubro = $valoresPost['rubro'];
                                }else{
                                    $rubro ="0";
                                }
                            }
                        }else{
                            $district ="0";
                            if ($valoresPost['ejecutivo']<>"0"){
                                $ejecutivo =$valoresPost['ejecutivo'];
                            }else{
                                $ejecutivo ="0";
                            }
                            if ($valoresPost['rubro']<>"0"){
                                $rubro = $valoresPost['rubro'];
                            }else{
                                $rubro ="0";
                            }
                        }
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=84;
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);
                    //$valSiNo[0] = array("tipo" => 'Con Disposición', "Op. Con Exito" => $sino_conexito['si'], "Op. Sin Exito" => 0, "Ag. Cerrados" =>0,"Ag. No Aceptaron Trans."=>0);

                    /*$poll_cerrados=67;
                    $sino_cerrados=$this->PollDetailRepo->getTotalSiNo($poll_cerrados,$city,$district,$ejecutivo,$rubro);*/

                    $poll_notrans=79;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                    $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                    /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                    $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=89;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=90;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=91;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll(99);
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo(99, $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions(99);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 56

                            $options1= $this->PollOptionRepo->getOptions(88);$cantidadTotal=0;
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }

                if ($company_id==12){
                    $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
                    $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
                    //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
                    //dd($ListStoresUbigeo[0]);
                    foreach ($ListStoresUbigeo as $stores)
                    {
                        $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
                    }
                    //dd($val);

                    $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        if ($city<>"0"){
                            if ($valoresPost['distrito']<>"0"){
                                $arrayDistrict = explode($city.'|',$valoresPost['distrito']);
                                $district = $arrayDistrict[1];
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo = $valoresPost['ejecutivo'];
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }else{
                                    $ejecutivo ="0";
                                    if ($valoresPost['rubro']<>"0"){
                                        $rubro = $valoresPost['rubro'];
                                    }else{
                                        $rubro ="0";
                                    }
                                }
                            }else{
                                $district ="0";
                                if ($valoresPost['ejecutivo']<>"0"){
                                    $ejecutivo =$valoresPost['ejecutivo'];
                                }else{
                                    $ejecutivo ="0";
                                }
                                if ($valoresPost['rubro']<>"0"){
                                    $rubro = $valoresPost['rubro'];
                                }else{
                                    $rubro ="0";
                                }
                            }
                        }else{
                            $district ="0";
                            if ($valoresPost['ejecutivo']<>"0"){
                                $ejecutivo =$valoresPost['ejecutivo'];
                            }else{
                                $ejecutivo ="0";
                            }
                            if ($valoresPost['rubro']<>"0"){
                                $rubro = $valoresPost['rubro'];
                            }else{
                                $rubro ="0";
                            }
                        }
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=84+39;//dd($poll_conexito);
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);//dd($sino_conexito);
                    //$valSiNo[0] = array("tipo" => 'Con Disposición', "Op. Con Exito" => $sino_conexito['si'], "Op. Sin Exito" => 0, "Ag. Cerrados" =>0,"Ag. No Aceptaron Trans."=>0);

                    /*$poll_cerrados=67;
                    $sino_cerrados=$this->PollDetailRepo->getTotalSiNo($poll_cerrados,$city,$district,$ejecutivo,$rubro);*/

                    $poll_notrans=79+39;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                    $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                    /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                    $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=130;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=90+39;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=128;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll(99+39);
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo(99+39, $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions(99+39);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 127 = 88+39

                            $options1= $this->PollOptionRepo->getOptions(88+39);$cantidadTotal=0;
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }

                if ($company_id==14){
                    $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
                    $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
                    //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
                    //dd($ListStoresUbigeo[0]);
                    foreach ($ListStoresUbigeo as $stores)
                    {
                        $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
                    }
                    //dd($val);

                    $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        $district = $valoresPost['transac'];
                        $rubro = $valoresPost['rubro'];
                        $ejecutivo = $valoresPost['ejecutivo'];
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=178;//dd($poll_conexito);
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);//dd($sino_conexito);
                    //$valSiNo[0] = array("tipo" => 'Con Disposición', "Op. Con Exito" => $sino_conexito['si'], "Op. Sin Exito" => 0, "Ag. Cerrados" =>0,"Ag. No Aceptaron Trans."=>0);

                    /*$poll_cerrados=67;
                    $sino_cerrados=$this->PollDetailRepo->getTotalSiNo($poll_cerrados,$city,$district,$ejecutivo,$rubro);*/

                    $poll_notrans=173;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    if ($totales>0){
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    }else{
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => 0);
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => 0);
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => 0);
                    }

                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=188;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=187;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=186;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll(165);
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo(165, $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions(165);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 127 = 88+39

                            $options1= $this->PollOptionRepo->getOptions(182);$cantidadTotal=0;
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }

                if ($company_id==20){
                    $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
                    $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
                    //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
                    //dd($ListStoresUbigeo[0]);
                    foreach ($ListStoresUbigeo as $stores)
                    {
                        $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
                    }
                    //dd($val);

                    $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        $district = $valoresPost['transac'];
                        $rubro = $valoresPost['rubro'];
                        $ejecutivo = $valoresPost['ejecutivo'];
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=232;//dd($poll_conexito);
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);//dd($sino_conexito);

                    $poll_notrans=227;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    if ($totales>0){
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    }else{
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => 0);
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => 0);
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => 0);
                    }

                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=242;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=241;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=240;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll(219);
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo(219, $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions(219);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 127 = 88+39

                            $options1= $this->PollOptionRepo->getOptions(236);$cantidadTotal=0;
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }

                if ($company_id>=26){
                    $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
                    $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
                    //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
                    //dd($ListStoresUbigeo[0]);
                    foreach ($ListStoresUbigeo as $stores)
                    {
                        $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
                    }
                    //dd($val);

                    $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

                    //inicio filtros
                    $valoresPost= Input::all();
                    //dd($valoresPost);
                    if (count($valoresPost)<>0){
                        $audit_id = $valoresPost['audit_id'];
                        $city = $valoresPost['ciudad'];
                        $district = $valoresPost['transac'];
                        $rubro = $valoresPost['rubro'];
                        $ejecutivo = $valoresPost['ejecutivo'];
                    }else{
                        $city = "0";
                        $district ="0";
                        $ejecutivo ="0";
                        $rubro ="0";
                    }
                    $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

                    //fin filtros

                    $poll_conexito=$this->pollUsados[$company_id]['OperacionExitosa'];//364dd($poll_conexito);
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$district,$ejecutivo,$rubro);//dd($sino_conexito);

                    $poll_notrans=$this->pollUsados[$company_id]['AceptoOperacion'];//359;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$district,$ejecutivo,$rubro);//dd($sino_notrans);
                    $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    if ($totales>0){
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => round(($sino_conexito['si']/$totales)*100,0));
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => round(($sino_conexito['no']/$totales)*100,0));
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => round(($sino_notrans['no']/$totales)*100,0));
                    }else{
                        $valSiNo[] = array("respuesta" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "porcentaje" => 0);
                        $valSiNo[] = array("respuesta" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "porcentaje" => 0);
                        /*$valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');*/
                        $valSiNo[] = array("respuesta" => 'No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "porcentaje" => 0);
                    }

                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=$this->pollUsados[$company_id]['disposicion'];//374;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=$this->pollUsados[$company_id]['conocimiento'];//373;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=$this->pollUsados[$company_id]['amabilidad'];//372;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$district,$ejecutivo,$rubro);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);


                    //Incluir cerrados y abiertos
                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll($this->pollUsados[$company_id]['abierto']);//351
                    if (count($indicators)>0) {
                        if ($indicators->sino == 1) {
                            $sino = $this->PollDetailRepo->getTotalSiNo($this->pollUsados[$company_id]['abierto'], $city, $district, $ejecutivo, $rubro);
                            $total = $sino['si'] + $sino['no'];
                            if ($total>0){
                                $porcSI = ($sino['si']/$total)*100;
                                $porcNO = ($sino['no']/$total)*100;
                            }else{
                                $porcSI = 0;
                                $porcNO = 0;
                            }

                            $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                            $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        }
                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions($this->pollUsados[$company_id]['abierto']);$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);

                            //preg 127 = 88+39

                            $options1= $this->PollOptionRepo->getOptions($this->pollUsados[$company_id]['porqueNoTransOK']);$cantidadTotal=0;//368
                            foreach ($options1 as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options1 as $option) {
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, $city, $district, $ejecutivo, $rubro);
                                if ($cantidadTotal <> 0) {
                                    $porcOpcion = ($cantidadOption / $cantidadTotal) * 100;
                                } else {
                                    $porcOpcion = 0;
                                }

                                $ValRespuesta = trim($option->options_abreviado);

                                $totalOptions1[] = array('respuesta' => $ValRespuesta, 'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion, 0));
                            }
                            $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                        }
                    }else{
                        $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => 0, "porcentaje" => 0);
                        $valSINOJson1 =json_encode($valSiNo);unset($valSiNo);
                        $totalOptions[] = array('respuesta' => '', 'cantidad' => 0, "porcentaje" => 0);
                        $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);
                        $totalOptions1[] = array('respuesta' => '', 'cantidad' => 0, "porcentaje" => 0);
                        $totalOptionsJSON56 = json_encode($totalOptions1);unset($totalOptions1);
                    }

                    $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                    //dd($QstoresAudits);
                    $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                    $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                    $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                }
            }

        }
        if ($company_id==1){

            return View::make('report/inicioIbk1', compact('valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }
        if ($company_id==6){
            return View::make('report/inicioMediaConcept',compact('userType'));
        }

        if (($company_id==8) or ($company_id==10)){

            //return View::make('report/inicio', compact('valSINOJson','company_id','city','district','ejecutivo','rubro','valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
            return View::make('report/HomeInterbank', compact('ciudades','menus','totalOptionsJSON56','valores','totalOptionsJSON','valSINOJson1','company_id','city','district','ejecutivo','rubro','valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }

        if ($company_id==12)
        {
            return View::make('report/HomeInterbank12', compact('cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','ciudades','menus','totalOptionsJSON56','valores','totalOptionsJSON','valSINOJson1','company_id','city','district','ejecutivo','rubro','valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }

        if ($company_id==14)
        {
            return View::make('report/HomeInterbank14', compact('cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','ciudades','menus','totalOptionsJSON56','valores','totalOptionsJSON','valSINOJson1','company_id','city','district','ejecutivo','rubro','valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }

        if ($company_id>=20)
        {
            $abierto = $this->pollUsados[$company_id]['abierto'];$abiertoLocalCerrado =$this->pollUsados[$company_id]['abiertoLocalCerrado'];
            $abiertoYaNoAgente =$this->pollUsados[$company_id]['abiertoYaNoAgente'];$abiertoPidioRetiro  =$this->pollUsados[$company_id]['abiertoPidioRetiro'];
            return View::make('report/HomeInterbank20', compact('abiertoPidioRetiro','abiertoYaNoAgente','abiertoLocalCerrado','abierto','cantidadStoresAudit','cantidadStoresRouting','cantidadStoresForCampaigne','titulo','logo','ciudades','menus','totalOptionsJSON56','valores','totalOptionsJSON','valSINOJson1','company_id','city','district','ejecutivo','rubro','valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }
    }

    public function audit($id)
    {
        if ($id==7){
            return View::make('report/interbank/audit1');
        }
        if ($id==8){
            return View::make('report/interbank/audit2');
        }

        if ($id==9){
            return View::make('report/interbank/audit3');
        }

    }

    /**
     *Obtiene nro. de reportes a generar
     */
    public function getNumberReports($CantidadTiendasPorEmpresa)
    {
        $reportes = $CantidadTiendasPorEmpresa/50;

        if (strpos($reportes,'.')=== false){
            $valorNroReportes=$reportes;
        }else{
            $nroReportes = explode(".",$reportes);
            if ($nroReportes[1]>0) {
                $valorNroReportes=$nroReportes[0] + 1;
            }else{
                $valorNroReportes=$nroReportes[0];
            }
        }
        return $valorNroReportes;
    }

    public function getResultComparationHomeCamp($disponible, $realizoOp, $transEx,$disposicion,$conocimiento,$amabilidad, $campaigns,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        if (count($campaigns)==1){
            $campaigns = explode("-", $campaigns);
        }//dd($campaigns);
        $compaign_select = "Estudios seleccionados";
        for ($i = 0; $i < count($campaigns); $i++)
        {
            $company_detail = $this->CompanyRepo->find($campaigns[$i]);
            if ($i == 0) {$compaign_select .= " ";}else{ $compaign_select .= " , ";}
            $compaign_select .= $company_detail->fullname;
            //dd($compaign_select);
        }

        for ($i = 0; $i < count($campaigns); $i++)
        {
            $company_detail = $this->CompanyRepo->find($campaigns[$i]);
            //dd($disponible[$i]);
            if ($district<>"0"){
                $objPollOption = $this->PollOptionRepo->find($district);//dd($objPollOption);
                $Transac = $this->PollOptionRepo->getIdForOptionsCompany($objPollOption->options,$campaigns[$i]);//dd($Transac);
                $filtroTransac = $Transac[0]->id;
            }else{
                $filtroTransac = $district;
            }
            if ($rubro<>"0"){
                $objPollOption = $this->PollOptionRepo->find($rubro);//dd($objPollOption);
                $Rubro = $this->PollOptionRepo->getIdForOptionsCompany($objPollOption->options,$campaigns[$i]);//dd($filtroTransac);
                $filtroRubro = $Rubro[0]->id;
            }else{
                $filtroRubro = $rubro;
            }
            $indicators=$this->PollDetailRepo->getIndicatorForIdPoll($disponible[$campaigns[$i]]);
            if (count($indicators)>0) {
                if ($indicators->sino == 1) {
                    $sino = $this->PollDetailRepo->getTotalSiNo($disponible[$campaigns[$i]],$city,$filtroTransac,$ejecutivo,$filtroRubro);
                    $total = $sino['si'] + $sino['no'];
                    if ($total > 0) {
                        $porcSI = ($sino['si'] / $total) * 100;
                        $porcNO = ($sino['no'] / $total) * 100;
                    } else {
                        $porcSI = 0;
                        $porcNO = 0;
                    }
                    $valSiNo[] = array("ola" => $company_detail->fullname,"Disponible" => round($porcSI,0), 'No Disponible' => round($porcNO,0));
                }
            }

            $poll_conexito=$realizoOp[$campaigns[$i]];
            $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito,$city,$filtroTransac,$ejecutivo,$filtroRubro);//dd($sino_conexito);

            $poll_notrans=$transEx[$campaigns[$i]];
            $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans,$city,$filtroTransac,$ejecutivo,$filtroRubro);//dd($sino_notrans);
            $totales = $sino_conexito['si'] + $sino_conexito['no'] + $sino_notrans['no'];
            if ($totales==0){
                $valSiNo1[] = array("ola" => $company_detail->fullname,"Con Exito" =>  0,"Sin Exito" =>  0,"No aceptaron Trans" =>  0);
            }else{
                $valSiNo1[] = array("ola" => $company_detail->fullname,"Con Exito" =>  round(($sino_conexito['si']/$totales)*100,0),"Sin Exito" =>  round(($sino_conexito['no']/$totales)*100,0),"No aceptaron Trans" =>  round(($sino_notrans['no']/$totales)*100,0));
            }


            $poll_limit1=$disposicion[$campaigns[$i]];
            $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1,$city,$filtroTransac,$ejecutivo,$filtroRubro);
            $total = $limits1['deb'] + $limits1['est'] + $limits1['sup'];
            if ($total>0){
                $porc1 = ($limits1['deb']/$total)*100;
                $porc2 = ($limits1['est']/$total)*100;
                $porc3 = ($limits1['sup']/$total)*100;
            }else{
                $porc1 = 0;
                $porc2 = 0;
                $porc3 = 0;
            }
            $valLimits[] = array("ola" => $company_detail->fullname, "Debajo del Estandar" => round($porc1,0), "Estandar" => round($porc2,0), "Superior" => round($porc3,0));

            $poll_limit2=$conocimiento[$campaigns[$i]];
            $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2,$city,$filtroTransac,$ejecutivo,$filtroRubro);
            $total = $limits2['deb'] + $limits2['est'] + $limits2['sup'];
            if ($total>0){
                $porc1 = ($limits2['deb']/$total)*100;
                $porc2 = ($limits2['est']/$total)*100;
                $porc3 = ($limits2['sup']/$total)*100;
            }else{
                $porc1 = 0;
                $porc2 = 0;
                $porc3 = 0;
            }
            $valLimits1[] = array("ola" => $company_detail->fullname, "Debajo del Estandar" => round($porc1,0), "Estandar" => round($porc2,0), "Superior" => round($porc3,0));

            $poll_limit3=$amabilidad[$campaigns[$i]];
            $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3,$city,$filtroTransac,$ejecutivo,$filtroRubro);
            $total = $limits3['deb'] + $limits3['est'] + $limits3['sup'];
            if ($total>0){
                $porc1 = ($limits3['deb']/$total)*100;
                $porc2 = ($limits3['est']/$total)*100;
                $porc3 = ($limits3['sup']/$total)*100;
            }else{
                $porc1 = 0;
                $porc2 = 0;
                $porc3 = 0;
            }
            $valLimits2[] = array("ola" => $company_detail->fullname, "Debajo del Estandar" => round($porc1,0), "Estandar" => round($porc2,0), "Superior" => round($porc3,0));


        }

        $valSINOJson1 = json_encode($valSiNo);//dd($valSINOJson1);
        unset($valSiNo);
        $valSINOJson =json_encode($valSiNo1);
        unset($valSiNo1);
        $valLimitsJson =json_encode($valLimits);//dd($valLimitsJson);
        unset($valLimits);
        $valLimitsJson1 =json_encode($valLimits1);
        unset($valLimits1);
        $valLimitsJson2 =json_encode($valLimits2);
        unset($valLimits2);

        $results = array($compaign_select, $valSINOJson1,$valSINOJson,$valLimitsJson,$valLimitsJson1,$valLimitsJson2, $campaigns);
        return $results;
    }

    public function getResultComparationCampaigns($audit_id, $campaigns, $company_id,$city="0",$district="0",$ejecutivo="0",$rubro="0")
    {
        //dd($audit_id." - ".$company_id);
        if (count($campaigns)==1){
            $campaigns = explode("-", $campaigns);
        }

        $polls = $this->PollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id));
        $c=0;//dd($polls);
        $compaign_select = "Estudios seleccionados";
        for ($i = 0; $i < count($campaigns); $i++)
        {
            $company_detail = $this->CompanyRepo->find($campaigns[$i]);
            if ($i == 0) {$compaign_select .= " ";}else{ $compaign_select .= " , ";}
            $compaign_select .= $company_detail->fullname;
            //dd($compaign_select);
        }
        //dd($polls[0]);
        foreach ($polls as $poll)
        {
            $c=$c+1;

            if (($poll->id<>$this->pollUsados[$company_id]['rubroPoll']) and ($poll->id<>$this->pollUsados[$company_id]['ConvienePagarFono']) and ($poll->id<>$this->pollUsados[$company_id]['porqueNoAtendioInmediato']) and ($poll->id<>$this->pollUsados[$company_id]['preocupoPorSuTiempo']) and ($poll->id<>$this->pollUsados[$company_id]['despuesDeEsperar']) and ($poll->id<>$this->pollUsados[$company_id]['entregoVoucher']) and ($poll->id<>$this->pollUsados[$company_id]['porqueNoTransOK']) and ($poll->id<>$this->pollUsados[$company_id]['solucionTrans']) and ($poll->id<>$this->pollUsados[$company_id]['escogerTipoTrans'])){
                //dd(count($poll->id));
                for ($i = 0; $i < count($campaigns); $i++)
                {
                    $polls_details = $this->PollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$campaigns[$i]));
                    $c=0;//dd($polls_details);
                    $company_detail = $this->CompanyRepo->find($campaigns[$i]);
                    foreach ($polls_details as $poll_detail)
                    {
                        //dd($poll->question . ' - ' .$poll_detail->question);
                        if ($poll_detail->question == $poll->question){
                            //dd($poll_detail);
                            $indicators=$this->PollDetailRepo->getIndicatorForIdPoll($poll_detail->id);//dd(count($indicators));
                            if (count($indicators)>0){//dd($indicators->sino);
                                if ($district<>"0"){
                                    $objPollOption = $this->PollOptionRepo->find($district);//dd($objPollOption);
                                    $Transac = $this->PollOptionRepo->getIdForOptionsCompany($objPollOption->options,$campaigns[$i]);//dd($Transac);
                                    $filtroTransac = $Transac[0]->id;
                                }else{
                                    $filtroTransac = $district;
                                }
                                if ($rubro<>"0"){
                                    $objPollOption = $this->PollOptionRepo->find($rubro);//dd($objPollOption);
                                    $Rubro = $this->PollOptionRepo->getIdForOptionsCompany($objPollOption->options,$campaigns[$i]);//dd($filtroTransac);
                                    $filtroRubro = $Rubro[0]->id;
                                }else{
                                    $filtroRubro = $rubro;
                                }
                                if ($indicators->sino == 1){
                                    $sino=$this->PollDetailRepo->getTotalSiNo($poll_detail->id,$city,$filtroTransac,$ejecutivo,$filtroRubro);

                                    if ($poll_detail->id<>38){
                                        $total = $sino['si'] + $sino['no'];
                                        if ($total>0){
                                            $porcSI = ($sino['si']/$total)*100;
                                            $porcNO = ($sino['no']/$total)*100;
                                        }else{
                                            $porcSI = 0;
                                            $porcNO = 0;
                                        }
                                    }

                                    if ($poll_detail->id<>38){
                                        if (($poll_detail->id==67) and ($poll_detail->id==27)){
                                            $valSiNo[] = array("ola" => $company_detail->fullname,"Disponible" => round($porcSI,0), 'No Disponible' => round($porcNO,0));
                                            $tipo_grafico=1;
                                        }else{
                                            $valSiNo[] = array("ola" => $company_detail->fullname, 'Si' => round($porcSI,0), 'No' => round($porcNO,0));
                                            $tipo_grafico=2;
                                        }

                                    }

                                }else{
                                    $sino = array('si' => 0,'no'=>0);
                                    $valSiNo[] = array("ola" => "", 'Si' => 0, 'No' => 0);
                                }//dd($indicators->limits);
                                if ($indicators->limits == 1){
                                    //dd($poll->id);
                                    $limits=$this->PollDetailRepo->getTotalLimites($poll_detail->id,$city,$filtroTransac,$ejecutivo,$filtroRubro);//dd($limits);

                                    $total = $limits['deb'] + $limits['est'] + $limits['sup'];
                                    if ($total>0){
                                        $porc1 = ($limits['deb']/$total)*100;
                                        $porc2 = ($limits['est']/$total)*100;
                                        $porc3 = ($limits['sup']/$total)*100;
                                    }else{
                                        $porc1 = 0;
                                        $porc2 = 0;
                                        $porc3 = 0;
                                    }

                                    $valLimits[] = array("ola" => $company_detail->fullname, "Debajo del Estandar" => round($porc1,0), "Estandar" => round($porc2,0), "Superior" => round($porc3,0));
                                    $tipo_grafico=1;

                                    //dd($valLimits);

                                }else{
                                    $limits = array('deb' => 0,'est'=>0, 'sup'=>0);
                                    $valLimits[] = array("ola" => "", "Debajo del Estandar" => 0, "Estandar" => 0, "Superior" => 0);
                                }

                            }
                        }
                    }
                }//dd($valLimits);
                $valSINOJson =json_encode($valSiNo);unset($valSiNo);
                $valLimitsJson =json_encode($valLimits);unset($valLimits);
                $resumenes[] = array('succes' => 1, 'tipo_grafico' => $tipo_grafico, 'poll_id' => $poll->id, 'question' => $poll->question, 'sino' => $indicators->sino, 'result' => $sino, 'JSONSiNo' => $valSINOJson,'limits' => $indicators->limits, 'JSONLimits' =>$valLimitsJson, 'audit_id' =>$audit_id);

            }

        }
        //dd($compaign_select);
        $results = array($compaign_select, $resumenes, $campaigns);
        return $results;
    }


    public function generateMenusComparation($audit_id, $campaigns, $company_id)
    {
        $compaign_link ="";
        $AuditsCompany = $this->getAuditForCompany($company_id);
        for ($i = 0; $i < count($campaigns); $i++)
        {
            if ($i == 0) {$compaign_link .= "";}else{ $compaign_link .= "-";}
            $compaign_link .= $campaigns[$i];
        }//dd($compaign_link);
        if ($audit_id == 0)
        {
            $menus[] = array('nombre' => 'Home', 'url' => route('homeComparationStudiesLink', array(0, $compaign_link, $company_id)), 'active' => 1);
        }else{
            $menus[] = array('nombre' => 'Home', 'url' => route('homeComparationStudiesLink', array(0, $compaign_link, $company_id)), 'active' => 0);
        }


        foreach ($AuditsCompany as $audit)
        {
            if ($audit_id == $audit->id)
            {
                $menus[] = array('nombre' => $audit->fullname, 'url' => route('comparationCampaignsLink', array($audit->id, $compaign_link, $company_id)), 'active' => 1);
            }else{
                $menus[] = array('nombre' => $audit->fullname, 'url' => route('comparationCampaignsLink', array($audit->id, $compaign_link, $company_id)), 'active' => 0);
            }
        }
        return $menus;
    }

    public function compCampaignsLinkFilter()
    {
        //inicio filtros
        $valoresPost= Input::all();//dd($valoresPost);

        $compaign_link ="";

        if (count($valoresPost)<>0){
            $district =$valoresPost['transac'];
            $city = $valoresPost['ciudad'];
            $ejecutivo = $valoresPost['ejecutivo'];
            $rubro = $valoresPost['rubro'];
            $audit_id = $valoresPost['audit_id'];;
            $company_id = $valoresPost['company_id'];
            $compaign_link= $valoresPost['compaign_link'];//dd($compaign_link);

        }else{
            $city = "0";
            $district ="0";
            $ejecutivo ="0";
            $rubro ="0";
        }
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;//dd($valores);
        //fin filtros
        $audit = $this->AuditRepo->find($audit_id);
        $userType = Auth::user()->type;
        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $resultados = $this->getResultComparationCampaigns($audit_id, $compaign_link, $company_id,$city,$district,$ejecutivo,$rubro);
        //dd($campaigns);
        $compaign_select = $resultados[0];
        $resumenes = $resultados[1];//dd($resumenes);
        $campaigns = $resultados[2];
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);

        return View::make('report/interbank/comparations',compact('compaign_link','ciudades','valores','city','district','ejecutivo','rubro','titulo','logo','menus','company_id','compaign_select','userType','audit','audit_id','resumenes'));
    }

    public function comparationCampaignsLink($audit_id, $campaigns, $company_id)
    {
        $audit = $this->AuditRepo->find($audit_id);
        $userType = Auth::user()->type;
        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $city = "0";
        $district ="0";
        $ejecutivo ="0";
        $rubro ="0";
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $compaign_link = $campaigns;

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $resultados = $this->getResultComparationCampaigns($audit_id, $campaigns, $company_id);
        //dd($campaigns);
        $compaign_select = $resultados[0];
        $resumenes = $resultados[1];//dd($resumenes);
        $campaigns = $resultados[2];
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);

        return View::make('report/interbank/comparations',compact('compaign_link','ciudades','valores','city','district','ejecutivo','rubro','titulo','logo','menus','company_id','compaign_select','userType','audit','audit_id','resumenes'));
    }

    public function homeComparationCampaignsLink($audit_id,$campaigns, $company_id)
    {
        $audit_id = 0;
        $userType = Auth::user()->type;

        //dd($campaigns);
        $disponible=$this->disponible0;
        $realizoOp=$this->realizoOp0;
        $transEx=$this->transEx0;
        $disposicion=$this->disposicion0;
        $conocimiento=$this->conocimiento0;
        $amabilidad=$this->amabilidad0;
        $city = "0";
        $district ="0";
        $ejecutivo ="0";
        $rubro ="0";
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $compaign_link = $campaigns;

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;//dd($titulo);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $resultados = $this->getResultComparationHomeCamp($disponible,$realizoOp,$transEx,$disposicion,$conocimiento,$amabilidad, $campaigns);

        $campaigns = $resultados[6];
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);
        //dd($resultados);
        $compaign_select = $resultados[0];
        $valSINOJson1 = $resultados[1];
        $valSINOJson = $resultados[2];
        $valLimitsJson = $resultados[3];
        $valLimitsJson1 = $resultados[4];
        $valLimitsJson2 = $resultados[5];

        return View::make('report/HomeComparationInterbank', compact('compaign_link','ciudades','valores','city','district','ejecutivo','rubro','titulo','logo','menus','valSINOJson1','valSINOJson','valLimitsJson','valLimitsJson1','valLimitsJson2','company_id','userType','compaign_select','audit_id'));
    }

    public function homeCompCampaignsFilter()
    {
        //inicio filtros
        $valoresPost= Input::all();//dd($valoresPost);
        $audit_id = 0;
        $compaign_link ="";

        if (count($valoresPost)<>0){
            $district =$valoresPost['transac'];;
            $city = $valoresPost['ciudad'];
            $company_id = $valoresPost['company_id'];
            $compaign_link= $valoresPost['compaign_link'];//dd($compaign_link);
            $ejecutivo = $valoresPost['ejecutivo'];
            if ($valoresPost['rubro']<>"0"){
                $rubro = $valoresPost['rubro'];
            }else{
                $rubro ="0";
            }

        }else{
            $city = "0";
            $district ="0";
            $ejecutivo ="0";
            $rubro ="0";
        }
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;//dd($valores);
        //fin filtros

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;//dd($titulo);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $disponible=$this->disponible0;
        $realizoOp=$this->realizoOp0;
        $transEx=$this->transEx0;
        $disposicion=$this->disposicion0;
        $conocimiento=$this->conocimiento0;
        $amabilidad=$this->amabilidad0;


        $resultados = $this->getResultComparationHomeCamp($disponible,$realizoOp,$transEx,$disposicion,$conocimiento,$amabilidad, $compaign_link,$city,$district,$ejecutivo,$rubro);
        //dd($resultados);
        $compaign_select = $resultados[0];//dd($compaign_select);
        $valSINOJson1 = $resultados[1];
        $valSINOJson = $resultados[2];
        $valLimitsJson = $resultados[3];//dd($valLimitsJson);
        $valLimitsJson1 = $resultados[4];
        $valLimitsJson2 = $resultados[5];
        $campaigns = $resultados[6];
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);


        return View::make('report/HomeComparationInterbank', compact('compaign_link','ciudades','valores','city','district','ejecutivo','rubro','titulo','logo','menus','valSINOJson1','valSINOJson','valLimitsJson','valLimitsJson1','valLimitsJson2','company_id','userType','compaign_select','audit_id'));
    }

    public function homeComparationCampaigns()
    {
        //inicio filtros
        $valoresPost= Input::all();
        $audit_id = 0;
        $campaigns= $valoresPost['chk'];
        $company_id = $valoresPost['company_id'];//dd($campaigns);
        $compaign_link ="";
        for ($i = 0; $i < count($campaigns); $i++)
        {
            if ($i == 0) {$compaign_link .= "";}else{ $compaign_link .= "-";}
            $compaign_link .= $campaigns[$i];
        }

        $city = "0";
        $district ="0";
        $ejecutivo ="0";
        $rubro ="0";
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;

        //fin filtros

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $userType = Auth::user()->type;
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);
        //dd($menus);
        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;//dd($titulo);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $disponible=$this->disponible0;
        $realizoOp=$this->realizoOp0;
        $transEx=$this->transEx0;
        $disposicion=$this->disposicion0;
        $conocimiento=$this->conocimiento0;
        $amabilidad=$this->amabilidad0;


        $resultados = $this->getResultComparationHomeCamp($disponible,$realizoOp,$transEx,$disposicion,$conocimiento,$amabilidad, $campaigns);
        //dd($resultados);
        $compaign_select = $resultados[0];//dd($compaign_select);
        $valSINOJson1 = $resultados[1];
        $valSINOJson = $resultados[2];
        $valLimitsJson = $resultados[3];//dd($valLimitsJson);
        $valLimitsJson1 = $resultados[4];
        $valLimitsJson2 = $resultados[5];



        return View::make('report/HomeComparationInterbank', compact('compaign_link','ciudades','valores','city','district','ejecutivo','rubro','titulo','logo','menus','valSINOJson1','valSINOJson','valLimitsJson','valLimitsJson1','valLimitsJson2','company_id','userType','compaign_select','audit_id'));
    }

    public function comparationCampaigns()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $audit_id = $valoresPost['audit_id'];
        $campaigns= $valoresPost['chk'];
        $company_id = $valoresPost['company_id'];
        $city="0";$ejecutivo="0";$district="0";$rubro="0";$compaign_link ="";

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
        $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);
        foreach ($ListStoresUbigeo as $stores)
        {
            $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
        }
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $titulo = $campaigneDetail->fullname;
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($campaigneDetail);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $audit = $this->AuditRepo->find($audit_id);
        $userType = Auth::user()->type;
        //dd($audit_id);
        $menus = $this->generateMenusComparation($audit_id,$campaigns,$company_id);

        $resultados = $this->getResultComparationCampaigns($audit_id, $campaigns, $company_id);
        //dd($resultados);
        $compaign_select = $resultados[0];
        $resumenes = $resultados[1];

        for ($i = 0; $i < count($resultados[2]); $i++)
        {
            if ($i == 0) {$compaign_link .= "";}else{ $compaign_link .= "-";}
            $compaign_link .= $campaigns[$i];
        }

        return View::make('report/interbank/comparations',compact('ciudades','compaign_link','rubro','district','ejecutivo','city','logo','menus','company_id','compaign_select','userType','audit','audit_id','resumenes'));
    }

    public function auditReportAbstract($audit_id="0",$store_id="0",$campana_id="0")
    {
        if ($audit_id=="0"){
            $valoresPost= Input::all();//dd($valoresPost);
            $audit_id = $valoresPost['audit_id'];
            if ($valoresPost['ciudad']<>"0"){
                $city =$valoresPost['ciudad'];
            }else{
                $city ="0";
            }
            if ($valoresPost['ejecutivo']<>"0"){
                $ejecutivo =$valoresPost['ejecutivo'];
            }else{
                $ejecutivo ="0";
            }
            if ($valoresPost['rubro']<>"0"){
                $rubro = $valoresPost['rubro'];
            }else{
                $rubro ="0";
            }
            if ($valoresPost['transac']<>"0"){
                $district = $valoresPost['transac'];
            }else{
                $district ="0";
            }
        }else{
            $city = "0";
            $district ="0";
            $ejecutivo ="0";
            $rubro ="0";
        }

        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $letras = array(0 => 'a', 1 => 'b', 2 =>'c', 3 =>'d', 4 =>'e', 5 => 'f', 6 => 'g', 7 => 'h', 8 => 'i', 9 => 'j');

        $audit = $this->AuditRepo->find($audit_id);

        $userType = Auth::user()->type;//dd($userType);
        if ($campana_id=='0'){
            $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);//dd($company);
            if (count($company)>0){
                $company_id=$company[0]->id;
            }
        }else{
            $company_id=$campana_id;
            $company = $this->CompanyRepo->find($company_id);
        }
        $titulo = $company[0]->fullname;

        $campaigneDetail = $this->CompanyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;

        $menus = $this->generateMenusInterbank($company_id,$audit_id);


        if ($userType<>'auditor'){
            if (($company_id==1) or ($company_id==8) or ($company_id==10) or ($company_id==12) or ($company_id==14) or ($company_id==20) or ($company_id==26) or ($company_id==31) or ($company_id==34) or ($company_id>=40)){
                $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
            }
            if ($company_id==6) {
                $CantidadStoresAudits = $this->PollDetailRepo->getTotalPollsStore($store_id);

            }

            $AuditsCompany = $this->getAuditForCompany($company_id);
            //dd($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company[0]->id));//obtiene el id del registro de la auditoria contratada
            $polls = $this->PollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id));

            $ListStores = $this->storeRepo->getCityForCampaigne($company_id);//dd($company_id);
            $ListStoresUbigeo = $this->storeRepo->getDepartamentForCampaigne($company_id);//dd($company_id);
            //$ubigeos = $ListStoresUbigeo->lists('ubigeo','ubigeo');dd($ubigeos);
            //dd($ListStoresUbigeo[0]);
            foreach ($ListStoresUbigeo as $stores)
            {
                $val['Toda '.$stores->ubigeo]= 'Toda '.$stores->ubigeo;
            }
            //dd($val);

            $ciudades= array(0 => "Seleccionar") + $ListStores->lists('region','region') + $val + array(5 => "Todo Provincias") ;

            //dd($polls);//obtiene preguntas de la auditoria con id= $audit_id
            if (count($polls) > 0){  //dd(count($polls));
                foreach ($polls as $poll){

                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll($poll->id);
                    //dd($indicators); //visualiza que indicadores tiene activo la pregunta con id = $poll->id
                    if (count($indicators)>0){
                        if ($indicators->sino == 1){
                            $sino=$this->PollDetailRepo->getTotalSiNo($poll->id,$city,$district,$ejecutivo,$rubro,$store_id);//dd($sino);

                            if ($poll->id==38){
                                $total = $sino['Afiches'] + $sino['Afiche_plastico'] + $sino['Letreros'];
                                if ($total>0){
                                    $porc2 = ($sino['Afiches']/$total)*100;
                                    $porc3 = ($sino['Afiche_plastico']/$total)*100;
                                    $porc4 = ($sino['Letreros']/$total)*100;
                                }else{
                                    $porcSI = 0;
                                    $porcNO = 0;
                                }
                            }

                            if ($poll->id<>38){
                                $total = $sino['si'] + $sino['no'];
                                if ($total>0){
                                    $porcSI = ($sino['si']/$total)*100;
                                    $porcNO = ($sino['no']/$total)*100;
                                }else{
                                    $porcSI = 0;
                                    $porcNO = 0;
                                }
                            }
                            if ($poll->id==38){
                                $valSiNo[0] = array("respuesta" => 'Afiches', "cantidad" => $sino['Afiches'], "porcentaje" => round($porc2,0));
                                $valSiNo[1] = array("respuesta" => 'Afiche Plástico', "cantidad" => $sino['Afiche_plastico'], "porcentaje" => round($porc3,0));
                                $valSiNo[2] = array("respuesta" => 'Letreros', "cantidad" => $sino['Letreros'], "porcentaje" => round($porc4,0));
                            }

                            if ($poll->id<>38){
                                if ($poll->id==$this->pollUsados[$company_id]['abierto']){
                                    $valSiNo[0] = array("respuesta" => 'Disponible', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                                    $valSiNo[1] = array("respuesta" => 'No Disponible', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                                }else{
                                    $valSiNo[0] = array("respuesta" => 'SI', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                                    $valSiNo[1] = array("respuesta" => 'NO', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                                }

                            }

                            //dd($valSiNo);
                            $valSINOJson =json_encode($valSiNo);unset($valSiNo);
                        }else{
                            $sino = array('si' => 0,'no'=>0);
                            $valSINOJson = array("respuesta" => '', "cantidad" => 0, "porcentaje" => 0);
                        }

                        if ($indicators->limits == 1){
                            //dd($poll->id);

                            $limits=$this->PollDetailRepo->getTotalLimites($poll->id,$city,$district,$ejecutivo,$rubro);//dd($limits);
                            
                            if (($poll->id==13) or ($poll->id==694)){
                                $total = $limits['Rapida'] + $limits['Normal'] + $limits['Muy_Lento'] + $limits['Lento'] + $limits['Muy_rapido'];
                                if ($total>0){
                                    $porc1 = ($limits['Rapida']/$total)*100;
                                    $porc2 = ($limits['Normal']/$total)*100;
                                    $porc3 = ($limits['Muy_Lento']/$total)*100;
                                    $porc4 = ($limits['Lento']/$total)*100;
                                    $porc5 = ($limits['Muy_rapido']/$total)*100;
                                }else{
                                    $porc1 = 0;
                                    $porc2 = 0;
                                    $porc3 = 0;
                                    $porc4 =0;
                                    $porc5 =0;
                                }

                                $valLimits[0] = array("respuesta" => 'Rápida', "cantidad" => $limits['Rapida'], "porcentaje" => round($porc1,0));
                                $valLimits[1] = array("respuesta" => 'Normal', "cantidad" => $limits['Normal'], "porcentaje" => round($porc2,0));
                                $valLimits[2] = array("respuesta" => 'Muy Lento', "cantidad" => $limits['Muy_Lento'], "porcentaje" => round($porc3,0));
                                $valLimits[3] = array("respuesta" => 'Lento', "cantidad" => $limits['Lento'], "porcentaje" => round($porc4,0));
                                $valLimits[4] = array("respuesta" => 'Muy Rápido', "cantidad" => $limits['Muy_rapido'], "porcentaje" => round($porc5,0));
                            }else{
                                $total = $limits['deb'] + $limits['est'] + $limits['sup'];
                                if ($total>0){
                                    $porc1 = ($limits['deb']/$total)*100;
                                    $porc2 = ($limits['est']/$total)*100;
                                    $porc3 = ($limits['sup']/$total)*100;
                                }else{
                                    $porc1 = 0;
                                    $porc2 = 0;
                                    $porc3 = 0;
                                }

                                $valLimits[0] = array("respuesta" => 'Debajo del estándar', "cantidad" => $limits['deb'], "porcentaje" => round($porc1,0));
                                $valLimits[1] = array("respuesta" => 'Estándar', "cantidad" => $limits['est'], "porcentaje" => round($porc2,0));
                                $valLimits[2] = array("respuesta" => 'Superior', "cantidad" => $limits['sup'], "porcentaje" => round($porc3,0));
                            }

                            //dd($valSiNo);
                            $valLimitsJson =json_encode($valLimits);unset($valLimits);
                        }else{
                            $limits = array('deb' => 0,'est'=>0, 'sup'=>0);
                            $valLimitsJson = array("respuesta" => '', "cantidad" => 0, "porcentaje" => 0);
                        }

                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions($poll->id);$letra =0;$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro,$store_id);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro,$store_id);
                                /*if ($option->id==526){dd($cantidadOption);}*/
                                if ($cantidadTotal<>0){
                                    $porcOpcion = ($cantidadOption/$cantidadTotal)*100;
                                }else{
                                    $porcOpcion = 0;
                                }

                                //$LeyendaOptions[] = array('respuesta' => $letras[$letra], 'option' => $option->options);
                                $ValRespuesta= trim($option->options_abreviado);

                                //echo $ValRespuesta."<br>";
                                $totalOptions[] = array( 'respuesta'=>$ValRespuesta,'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion,0));

                                $letra=$letra+1;

                                //$this->pollUsados[20] = array('rubroPoll'=> 218,'opcionRubro'=>705);
                                if (($poll->id == $this->pollUsados[$company_id]['rubroPoll']) and ($option->id == $this->pollUsados[$company_id]['opcionRubro'])){
                                    $optionsDetails = $this->PollOptionDetailRepo->getOptionsOther($option->id );
                                    //dd($optionsDetails);
                                    $cantidadOptionDetailTotal=0;
                                    foreach ($optionsDetails as $optionsDetail){
                                        $cantidadOptionDetail = $this->PollOptionDetailRepo->getTotalOptionOther($option->id,$optionsDetail->otro,$city, $district,$ejecutivo,$rubro);
                                        $cantidadOptionDetailTotal = $cantidadOptionDetailTotal + $cantidadOptionDetail;
                                    }//dd($cantidadOptionDetailTotal);
                                    foreach ($optionsDetails as $optionsDetail){
                                        $cantidadOptionDetail = $this->PollOptionDetailRepo->getTotalOptionOther($option->id,$optionsDetail->otro,$city, $district,$ejecutivo,$rubro);
                                        if ($cantidadOptionDetailTotal<>0){
                                            $porcOpcionDetail = ($cantidadOptionDetail/$cantidadOptionDetailTotal)*100;
                                        }else{
                                            $porcOpcionDetail = 0;
                                        }
                                        $totalOptionsOther[] = array( 'respuesta'=>$optionsDetail->otro,'cantidad' => $cantidadOptionDetail, "porcentaje" => round($porcOpcionDetail,0));
                                    }//dd($totalOptionsOther);
                                    $totalOptionsOtherJSON = json_encode($totalOptionsOther);unset($totalOptionsOther);
                                }else{
                                    $totalOptionsOtherJSON = array('respuesta' => "No Existe", 'cantidad' => 0, "porcentaje" => 0);
                                }
                            }
                            //var_dump($totalOptions);
                            //dd($totalOptions);
                            //dd(json_encode($valFormateadosOptions));
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);
                        }else{
                            //$LeyendaOptions = array('respuesta' => 0, 'option' => 0);
                            $totalOptionsJSON = array('option' => "No Existe", 'total' => 0);
                            $totalOptionsOtherJSON = array('respuesta' => "No Existe", 'cantidad' => 0, "porcentaje" => 0);
                        }
                        //dd($totalOptionsJSON);
                        $resumenes[] = array('succes' => 1,'poll_id' => $poll->id, 'question' => $poll->question, 'sino' => $indicators->sino, 'result' => $sino, 'JSONSiNo' => $valSINOJson,'option' => $indicators->options, 'JSONOpciones' =>$totalOptionsJSON, 'JSONOpcionesOther' =>$totalOptionsOtherJSON,'limits' => $indicators->limits, 'JSONLimits' =>$valLimitsJson, 'audit_id' =>$audit_id);
                    }else{
                        $sino = array('si' => 0,'no'=>0);
                        $LeyendaOptions = array('respuesta' => 0, 'option' => 0);
                        $totalOptionsJSON = array('option' => "No Existe", 'total' => 0);

                        $resumenes[] = array('succes' => 0,'poll_id' => $poll->id, 'question' => $poll->question, 'sino' => 0, 'result' => 0, 'JSONSiNo' => 0,'option' => 0, 'JSONOpciones' =>0, 'JSONOpcionesOther' =>0,'limits' => 0, 'JSONLimits' =>0, 'audit_id' =>$audit_id);
                    }

                }
            }else{
                $resumenes[] = array('succes' => 0,'poll_id' => 0, 'question' => "", 'sino' => 0, 'result' => 0, 'JSONSiNo' => 0,'option' => 0, 'JSONOpciones' =>0, 'JSONOpcionesOther' =>0,'limits' => 0, 'JSONLimits' =>0, 'audit_id' =>$audit_id);
            }
        }
        //dd($resumenes);
        //dd($audit);


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
        if (($company_id==1) or ($company_id==8) or ($company_id==10)){
            return View::make('report/interbank/audit',compact('ciudades','menus','company_id','valores','city','district','ejecutivo','rubro','cantidadStoresForCompany','CantidadStoresAudits','userType','audit','AuditsCompany','audit_id','resumenes'));
        }
        if ($company_id==6){
            return View::make('report/MediaConcept/audit',compact('store_id','CantidadStoresAudits','userType','audit','audit_id','resumenes'));
        }
        if ($company_id==12){
            return View::make('report/interbank/audit12',compact('titulo','logo','ciudades','menus','company_id','valores','city','district','ejecutivo','rubro','cantidadStoresForCompany','CantidadStoresAudits','userType','audit','AuditsCompany','audit_id','resumenes'));
        }
        if ($company_id==14){
            return View::make('report/interbank/audit14',compact('titulo','logo','ciudades','menus','company_id','valores','city','district','ejecutivo','rubro','cantidadStoresForCompany','CantidadStoresAudits','userType','audit','AuditsCompany','audit_id','resumenes'));
        }
        if ($company_id>=20){
            $rubro= $this->pollUsados[$company_id]['rubroPoll'];$exterior=$this->pollUsados[$company_id]['exterior'];$interior = $this->pollUsados[$company_id]['interior'];$aceptoOperacion = $this->pollUsados[$company_id]['AceptoOperacion'];$porqueNoTransOK=$this->pollUsados[$company_id]['porqueNoTransOK'];
            $opExitosa = $this->pollUsados[$company_id]['OperacionExitosa'];$cobroFueraVoucher = $this->pollUsados[$company_id]['cobroFueraVoucher'];$solucionTrans = $this->pollUsados[$company_id]['solucionTrans'];$abierto = $this->pollUsados[$company_id]['abierto'];
            $porqueNoTransOKOpcionOtro=$this->pollUsados[$company_id]['porqueNoTransOKOpcionOtro'];$solucionTransOpcionOtro=$this->pollUsados[$company_id]['solucionTransOpcionOtro'];
            $abiertoLocalCerrado =$this->pollUsados[$company_id]['abiertoLocalCerrado'];
            $abiertoYaNoAgente =$this->pollUsados[$company_id]['abiertoYaNoAgente'];
            return View::make('report/interbank/audit14',compact('abiertoYaNoAgente','abiertoLocalCerrado','solucionTransOpcionOtro','porqueNoTransOKOpcionOtro','porqueNoTransOK','abierto','solucionTrans','cobroFueraVoucher','opExitosa','aceptoOperacion','interior','exterior','rubro','titulo','logo','ciudades','menus','company_id','valores','city','district','ejecutivo','rubro','cantidadStoresForCompany','CantidadStoresAudits','user$porqueNoTransOK = $this->pollUsados[$company_id][\'porqueNoTransOK\'];Type','audit','AuditsCompany','audit_id','resumenes'));
        }

    }

    public function operationsGroup()
    {
        $fp = fopen ( 'media/archivos/stores_data_interbank.csv' , "r" );$c=0;
        while ($data = fgetcsv ($fp, 1000, ",")){
            if ($c<>0){
                $valores[] = array('Codigo'=>$data[0],'Ejecutivo'=>$data[6],'Rubro'=>$data[7]);
                $store = $this->storeRepo->find($data[0]);
                $store->ejecutivo = $data[6];
                $store->rubro = $data[7];
                $store->save();

            }
            $c=$c+1;
        }
        return View::make('report/interbank/audit1', compact('valores'));
    }

    public function reportAudios($empresa)
    {
        $contador=0;
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        $QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
        $audit_id =$empresa;
        if ($audit_id=='Interbank-Ola1'){
            $ruta = "media/audio/interbank/ola1";
            $directorio = opendir("/home/ttaudit/public_html/".$ruta); //ruta actual
        }else{
            $ruta = "media/audio/interbank/ola2";
            $directorio = opendir("/home/ttaudit/public_html/".$ruta); //ruta actual
        }

        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (!is_dir($archivo)) {
                $contador=$contador+1;
                $trozos = explode(".", $archivo);
                $store = $this->storeRepo->getStoreForCod($trozos[0],$company[0]->id);
                //dd($store);
                foreach ($store as $storeObj){
                    $valAudios[]= array('contador' => $contador,'agente' => $storeObj->fullname,'codclient' => $storeObj->codclient,'direccion' => $storeObj->address,'ubigeo' => $storeObj->ubigeo,'archivo' => \App::make('url')->to('/').'/'.$ruta.'/'.$archivo);
                }
            }
        }
        //dd($valAudios);
        return View::make('report/interbank/audios', compact('company_id','CantidadStoresAudits','userType','valorNroReportes','AuditsCompany','audit_id','valAudios'));
    }

    public function getDetailResultQuestion($poll_id,$values,$poll_option_id="0")
    {
        //$valores = $city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        $AuditsCompany = $this->getAuditForCompany($company_id);
        $audit_id ='0';

        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';
        $valores = explode('-',$values);//dd($valores);
        $toda = explode('Toda ',$valores[0]);//dd($toda);
        if ($toda[0] == ''){
            $city = $toda[1];
        }else{
            $city = $valores[0];
        }

        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];
        $pregSino = $valores[4];
        $menus = $this->generateMenusInterbank($company_id,$audit_id);


        $datosStores = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$urlBase,$urlImages,$valores);//dd($datosStores);

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
        $QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];

        return View::make('report/interbank/detailPollSiNo', compact('menus','company_id','pregSino','cantidadStoresForCompany','CantidadStoresAudits','question','city','district','ejecutivo','rubro','userType','valorNroReportes','AuditsCompany','audit_id','datosStores'));
    }
} 
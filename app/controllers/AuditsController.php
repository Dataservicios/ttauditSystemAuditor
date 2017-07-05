<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 25/06/2015
 * Time: 02:50 PM
 */

use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\AuditRepo;
use Auditor\Repositories\PresenceDetailRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\PublicityRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\ControlTimeRepo;

class AuditsController extends BaseController{

    protected $customerRepo;
    protected $companyRepo;
    protected $companyStoreRepo;
    protected $auditRepo;
    protected $presenceDetailRepo;
    protected $storeRepo;
    protected $PublicitiesDetailRepo;
    protected $MediaRepo;
    protected $AuditRoadStoreRepo;
    protected $RoadDetailRepo;
    protected $userRepo;
    protected $publicityRepo;
    protected $PollDetailRepo;
    protected $PollOptionDetailRepo;
    protected $PollOptionRepo;
    protected $pollRepo;
    protected $controlTimeRepo;

    public $urlBase;
    public $urlFotos;
    public $urlImageBas;
    public $urlExcels;
    public $valoresCampaigne;
    public $valoresCategory;

    public function __construct(ControlTimeRepo $controlTimeRepo,PollRepo $pollRepo,PollOptionRepo $PollOptionRepo,PollOptionDetailRepo $PollOptionDetailRepo,PollDetailRepo $PollDetailRepo,PublicityRepo $publicityRepo,UserRepo $userRepo,RoadDetailRepo $RoadDetailRepo,AuditRoadStoreRepo $AuditRoadStoreRepo, MediaRepo $MediaRepo,PublicitiesDetailRepo $PublicitiesDetailRepo,StoreRepo $storeRepo,PresenceDetailRepo $presenceDetailRepo, AuditRepo $auditRepo,CompanyStoreRepo $companyStoreRepo, CompanyRepo $companyRepo, CustomerRepo $customerRepo)
    {
        $this->customerRepo = $customerRepo;
        $this->companyRepo = $companyRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->auditRepo = $auditRepo;
        $this->presenceDetailRepo = $presenceDetailRepo;
        $this->storeRepo = $storeRepo;
        $this->PublicitiesDetailRepo = $PublicitiesDetailRepo;
        $this->MediaRepo = $MediaRepo;
        $this->AuditRoadStoreRepo = $AuditRoadStoreRepo;
        $this->RoadDetailRepo = $RoadDetailRepo;
        $this->userRepo = $userRepo;
        $this->publicityRepo = $publicityRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->PollOptionRepo = $PollOptionRepo;
        $this->pollRepo = $pollRepo;
        $this->controlTimeRepo = $controlTimeRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlFotos = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
        $this->urlExcels = '/reportes_excel/';
        $this->valoresCampaigne[3] = array('ventanaW' => 193);
        $this->valoresCampaigne[18] = array('ventanaW' => 204);
        $this->valoresCampaigne[21] = array('ventanaW' => 250);
        $this->valoresCampaigne[15] = array('ventanaW' => 0);
        $this->valoresCampaigne[22] = array('ventanaW' => 255,'abierto' => 252,'permitio' =>254,'existeVent' => 256, 'visibleVent' =>257, 'comoEstaVent'=>258);
        $this->valoresCampaigne[29] = array('ventanaW' => 388,'abierto' => 385,'permitio' =>387,'existeVent' => 389, 'visibleVent' =>390, 'comoEstaVent'=>391);
        $this->valoresCampaigne[36] = array('ventanaW' => 491,'abierto' => 489,'permitio' =>490,'existeVent' => 492, 'visibleVent' =>493, 'comoEstaVent'=>494);
        $this->valoresCampaigne[38] = array('ventanaW' => 510,'abierto' => 508,'permitio' =>509,'existeVent' => 511, 'visibleVent' =>512, 'comoEstaVent'=>513);
        $this->valoresCampaigne[43] = array('ventanaW' => 565,'abierto' => 563,'permitio' =>564,'existeVent' => 566, 'visibleVent' =>567, 'comoEstaVent'=>568);
        $this->valoresCampaigne[46] = array('ventanaW' => 619,'abierto' => 617,'permitio' =>618,'existeVent' => 620, 'visibleVent' =>621, 'comoEstaVent'=>622);
        $this->valoresCampaigne[53] = array('ventanaW' => 758,'abierto' => 756,'permitio' =>757,'existeVent' => 759, 'visibleVent' =>760, 'comoEstaVent'=>761);
        $this->valoresCampaigne[59] = array('ventanaW' => 840,'abierto' => 838,'permitio' =>839,'existeVent' => 841, 'visibleVent' =>842, 'comoEstaVent'=>843);
        $this->valoresCampaigne[68] = array('ventanaW' => 975,'abierto' => 973,'permitio' =>974,'existeVent' => 976, 'visibleVent' =>977, 'comoEstaVent'=>978);
        $this->valoresCampaigne[71] = array('ventanaW' => 1138,'abierto' => 1136,'permitio' =>1137,'existeVent' => 1139, 'visibleVent' =>1140, 'comoEstaVent'=>1141);
        $this->valoresCampaigne[75] = array('ventanaW' => 1237,'abierto' => 1235,'permitio' =>1236,'existeVent' => 1238, 'visibleVent' =>1239, 'comoEstaVent'=>1240);
        $this->valoresCampaigne[81] = array('ventanaW' => 1381,'abierto' => 1379,'permitio' =>1380,'existeVent' => 1382, 'visibleVent' =>1383, 'comoEstaVent'=>1384);
        $this->valoresCategory[3] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[18] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[21] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[22] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[29] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[36] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[38] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[43] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[46] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[53] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[59] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[68] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[71] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[75] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[81] = array('sod' => 54,'exhi' => 53);
        $this->valoresCategory[15] = array('sod' => 55,'exhi' => 56,'exhiAdic' => 57,'cartePromo' => 58);
    }

    public function HomeAudits()
    {
        $customers = $this->customerRepo->getCustomerActivs(1);
        $titulo = 'Cliente';
        foreach ($customers as $customer)
        {
            $links[] = array('nombre' => $customer->fullname, 'url' => route('CampaignForCustomer', array($customer->id)), 'target' => 0);
        }
        return View::make('audits/homeAudits', compact('links','titulo'));
    }

    public function Monitoreo()
    {
        $titulo = 'Monitoreo';
        $data = Session::all();
        //dd($data);
        $links[] = array('nombre' => 'Tracking Online', 'url' => 'http://ttaudit.com/admin/trackingOnline', 'target' => 1);
        $links[] = array('nombre' => 'Tracking Offline Por Usuario', 'url' => 'http://ttaudit.com/admin/trackingOffline', 'target' => 1);
        $links[] = array('nombre' => 'Excel Mensual Puntos Cerrados', 'url' => route('closedPoints'), 'target' => 0);
        return View::make('audits/homeAudits', compact('links','titulo'));
    }

    public function HomeCampaignForCustomer($customer_id)
    {
        $campaigns = $this->companyRepo->getCompaniesForClient($customer_id,"T");
        $titulo = 'Estudio';
        foreach ($campaigns as $campaign)
        {
            $links[] = array('nombre' => $campaign->fullname, 'url' => route('auditsForCampaign', array($campaign->id)), 'target' => 0);
        }
        return View::make('audits/homeAudits', compact('links','titulo'));
    }

    public function auditsForCampaign($company_id)
    {
        $menus = $this->generateMenusAudits(0,$company_id);
        return View::make('audits/auditsCompany', compact('menus'));
    }
    
    public function getDetailQuestion($poll_id,$values,$company_id,$poll_option_id="0",$product_id="0",$publicity_id="0",$audit_id="0",$auditor="0")
    {
        $valores = explode('-',$values);
        $pregSino = $valores[6];
        $city = $valores[0];
        $menus = $this->generateMenusAudits($audit_id,$company_id);

        $campaigne = $this->companyRepo->find($company_id);//dd($campaigne);
        $customer =$this->customerRepo->find($campaigne->customer_id);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        if ($pregSino==0)
        {
            $titulo = 'No trabajados';
        }else{
            $titulo = 'Trabajados';
        }
        $datosStores1 = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$this->urlBase,$this->urlFotos,$valores,$product_id,$company_id,$publicity_id);
        //$pollsResult = $this->getResponsePollsAlicorp($store_id,$company_id,$publicity_id);
        //dd($datosStores1);
        foreach ($datosStores1 as $datosStore) {
            $objPublicityDetail = $this->PublicitiesDetailRepo->findDetailForCondition($publicity_id,$datosStore['store_id'],$company_id);//dd($datosStore);
            if (count($datosStore['arrayFoto']>0))
            {
                $foto = $datosStore['arrayFoto'][0]['archivo'];
            }else{
                $foto="Foto";
            }
            $valoresPolls= $this->getValores();
            $poll_comoEstaVent = $valoresPolls[$company_id]['comoEstaVent'];
            $resp_comoEstaVent = $this->getResponsePolls($datosStore['store_id'],$company_id,$publicity_id,$poll_comoEstaVent,'Option');
            $datosStores[] = array('store_id' => $datosStore['store_id'], 'cadenaRuc' => $datosStore['cadenaRuc'],'type' =>$datosStore['type'],'codclient' => $datosStore['codclient'],'tipo_bodega' => $datosStore['tipo_bodega'],'distributor' => $datosStore['distributor'],'fullname' =>$datosStore['fullname'], 'departamento' => $datosStore['departamento'], 'Provincia' => $datosStore['Provincia'], 'distrito' => $datosStore['distrito'], 'comentario' => $datosStore['comentario'], 'otroComentario' => $datosStore['otroComentario'], 'arrayFoto' => $datosStore['arrayFoto'], 'fecha' => $datosStore['fecha'], 'publicity_details_id' => $objPublicityDetail[0]->id,'foto'=>$foto,'comoEstaVent' => $resp_comoEstaVent);
            //dd($datosStores);
        }
        return View::make('audits/sodTrabajados', compact('datosStores','menus','logo','titulo','audit_id','company_id','publicity_id','city','auditor'));
    }

    /**
     * @return json
     * Elimina registros tanto poll_details como poll_option_detail
     */
    public function delRegister()
    {
        $valoresPost= Input::all();
        $poll_detail_id = $valoresPost['poll_detail_id'];
        $poll_options_detail_id = $valoresPost['poll_options_detail_id'];
        $mytime = Carbon\Carbon::now();
        $pollDetail = $this->PollDetailRepo->getModel();
        $objPollDetail = $pollDetail::find($poll_detail_id);
        $objPollDetail->delete();
        if ($objPollDetail->delete())
        {
            $sw=1;
        }else{
            $sw=0;
        }
        if ($poll_options_detail_id<>'')
        {
            $arrayPollOptionsDetailId = explode('|',$poll_options_detail_id);
            for($i = 0; $i < count($arrayPollOptionsDetailId); ++$i) {
                if ($arrayPollOptionsDetailId[$i]<>'')
                {
                    $pollOptionDetail = $this->PollOptionDetailRepo->getModel();
                    $objPollOptionDetail = $pollOptionDetail::find($arrayPollOptionsDetailId[$i]);
                    $objPollOptionDetail->delete();
                }
            }

        }
        return Response::json([ 'success'=> $sw]);
    }
    /**
     * @return json
     * solo actualiza la respuesta en poll_details para tipos si y no
     */
    public function updatePollDetails()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $result = $valoresPost['result'];
        $company_id = $valoresPost['company_id'];
        $poll_detail_id = $valoresPost['poll_detail_id'];
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $pollDetail = $this->PollDetailRepo->getModel();
        $user = $pollDetail::find($poll_detail_id);
        //return Response::json([ 'success'=> $pollDetail]);
        $user->result = $result;

        $updateResponse = $user->save();
        if ($updateResponse == true)
        {
            return Response::json([ 'success'=> 1, 'fecha' => $user->created_at]);
        }else{
            return Response::json([ 'success'=> 0, 'fecha' => $user->created_at]);
        }

    }

    public function trackingOffline($auditor="",$company_id="",$ubigeo="")
    {
        if ($auditor==""){
            $valoresPost= Input::all();
            if (count($valoresPost)>0){
                $auditor = $valoresPost['auditor'];
                $company_id = $valoresPost['company_id'];
                $ubigeo = $valoresPost['ubigeo'];
                $objUser = $this->userRepo->find($auditor);
                $nameAuditor = $objUser->fullname;
                $objCampaigne = $this->companyRepo->find($company_id);
                $nameCampaigne = $objCampaigne->fullname;
            }else{
                $auditor="0";$company_id="0";$ubigeo="0";
            }
        }
        $listAuditor = $this->userRepo->listUserCondition('auditor');
        $auditors= array(0 => "Seleccionar") + $listAuditor->lists('fullname','id');
        $listCurrentCampaigne = $this->companyRepo->getCurrentCampaigns();
        $currentCampaignes= array(0 => "Seleccionar") + $listCurrentCampaigne->lists('fullname','id');
        $ListStores = $this->storeRepo->getCityForCampaigne();//dd($ListStores);
        $ubigeos= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');

        return View::make('trackingOffline', compact('auditor','company_id','ubigeo','auditors','currentCampaignes','ubigeos','nameAuditor','nameCampaigne'));
    }

    public function trackingOnline($auditor="")
    {
        if ($auditor==""){
            $valoresPost= Input::all();
            if (count($valoresPost)>0){
                $auditor = $valoresPost['auditor'];
                $objUser = $this->userRepo->find($auditor);
                $nameAuditor = $objUser->fullname;
            }else{
                $auditor="0";
            }
        }
        $listAuditor = $this->userRepo->listUserCondition('auditor');
        $auditors= array(0 => "Seleccionar") + $listAuditor->lists('fullname','id');

        return View::make('trackingOnnline', compact('auditor','auditors','nameAuditor'));
    }

    public function getJsonControlTime()
    {
        $valoresPost= Input::all();
        if (count($valoresPost)>0){
            $auditor = $valoresPost['user_id'];
            $company_id = $valoresPost['company'];
            $ubigeo = $valoresPost['ubigeo_id'];
        }else{
            $auditor="0";$company_id="0";$ubigeo="0";
        }
        $controlTimes = $this->controlTimeRepo->getRegForAuditorCompanyCity($auditor,$company_id,$ubigeo);//dd($controlTimes);
        if (($auditor<>"0") and ($company_id<>"0") and ($ubigeo<>"0"))
        {
            if (count($controlTimes)>0){
                foreach ($controlTimes as $controlTime)
                {
                    $dataM[] = array('store_id' => $controlTime->id,'fullname'=> $controlTime->fullname,'latitude_open'=> $controlTime->lat_open,'longitude_open'=> $controlTime->long_open,'latitude_close'=> $controlTime->lat_close,'longitude_close'=> $controlTime->long_close, 'latitude_store' => $controlTime->latitude, 'longitude_store' => $controlTime->longitude, 'time_open' => $controlTime->time_open, 'time_close' => $controlTime->time_close, 'created_at' => $controlTime->created_at, 'updated_at' => $controlTime->updated_at);
                }
            }else{
                $dataM = [];
            }

        }else{
            $dataM = [];
        }
        header('Access-Control-Allow-Origin: *');
        return Response::json( $dataM);
    }

    public function getJsonLastDayControlTime()
    {
        $valoresPost= Input::all();//dd(count($valoresPost));
        if (count($valoresPost)>0){
            $auditor = $valoresPost['auditor'];
            $id = $valoresPost['id'];
        }else{
            $auditor="0";
            $id = "0";
        }
        //$mytime = new Carbon\Carbon('yesterday');
        $mytime = Carbon\Carbon::now();
        //$mytime = $mytime->toDateString();
        $horaSistema = $mytime->format('Y-m-d');//dd($horaSistema);
        //$horaSistema = $mytime->toDateTimeString();//dd($horaSistema);
        $controlTimes = $this->controlTimeRepo->getRecOnTheLastAuditDay($auditor,$horaSistema,$id);//dd($controlTimes);
        if ($auditor<>"0")
        {
            if (count($controlTimes)>0){
                foreach ($controlTimes as $controlTime)
                {
                    $dataM[] = array('id' => $controlTime->id,'store_id' => $controlTime->store_id,'fullname'=> $controlTime->fullname,'latitude_open'=> $controlTime->lat_open,'longitude_open'=> $controlTime->long_open,'latitude_close'=> $controlTime->lat_close,'longitude_close'=> $controlTime->long_close, 'latitude_store' => $controlTime->latitude, 'longitude_store' => $controlTime->longitude, 'time_open' => $controlTime->time_open, 'time_close' => $controlTime->time_close, 'created_at' => $controlTime->created_at, 'updated_at' => $controlTime->updated_at);
                }
            }else{
                $dataM = [];
            }
        }else{
            $dataM = [];
        }//dd($dataM);
        header('Access-Control-Allow-Origin: *');
        return Response::json( $dataM);
    }

    /**
     * @return json
     * Actualiza todos los datos de poll_details
     */
    public function updatePollDetailsAll()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $result = $valoresPost['result'];
        $company_id = $valoresPost['company_id'];
        $poll_detail_id = $valoresPost['poll_detail_id'];
        $comment = $valoresPost['comment'];
        $product_id = $valoresPost['product_id'];
        $publicity_id = $valoresPost['publicity_id'];
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $pollDetail = $this->PollDetailRepo->getModel();
        $user = $pollDetail::find($poll_detail_id);
        //return Response::json([ 'success'=> $pollDetail]);
        $user->result = $result;
        $user->comentario = $comment;
        $user->product_id = $product_id;
        $user->company_id = $company_id;
        $user->publicity_id = $publicity_id;

        $updateResponse = $user->save();
        if ($updateResponse == true)
        {
            return Response::json([ 'success'=> 1, 'fecha' => $user->created_at]);
        }else{
            return Response::json([ 'success'=> 0, 'fecha' => $user->created_at]);
        }

    }
    
    public function deleteAllOptions()
    {
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $store_id= $valoresPost['store_id'];
        $product_id = $valoresPost['product_id'];
        $publicity_id = $valoresPost['publicity_id'];
        if ($this->PollOptionDetailRepo->deleteOptions($store_id,$company_id,$product_id,$publicity_id))
        { //deleteOptions($store_id,$company_id,$product_id,$publicity_id,$poll_id)
            return Response::json([ 'success'=> 1]);
        }else{
            return Response::json([ 'success'=> 0]);
        }

    }

    public function insertPollDetail()
    {
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $store_id= $valoresPost['store_id'];
        $product_id = $valoresPost['product_id'];
        $publicity_id = $valoresPost['publicity_id'];
        $options = $valoresPost['options'];
        $priorities = $valoresPost['priorities'];
        $poll_id = $valoresPost['poll_id'];
        $user_id = $valoresPost['user_id'];
        $sino = $valoresPost['sino'];
        $fecha = $valoresPost['fecha'];
        $comentario = $valoresPost['comentario'];
        $objPoll = $this->pollRepo->find($poll_id);
        $objPollDetail = $this->PollDetailRepo->getModel();
        $objPollDetail->poll_id = $poll_id;
        $objPollDetail->store_id = $store_id;
        $objPollDetail->sino = $objPoll->sino;
        $objPollDetail->options = $objPoll->options;
        $objPollDetail->media = $objPoll->media;
        $objPollDetail->result = $sino;
        $objPollDetail->comentario = $comentario;
        $objPollDetail->auditor = $user_id;
        $objPollDetail->product_id = $product_id;
        $objPollDetail->publicity_id = $publicity_id;
        $objPollDetail->company_id = $company_id;
        $objPollDetail->created_at = $fecha;
        if ($objPollDetail->save())
        {
            return Response::json([ 'success'=> 1, 'last_insert_id'=> $objPollDetail->id]);
        }else{
            return Response::json([ 'success'=> 0, 'last_insert_id'=> 0]);
        }
    }

    /**
     * @return json y texto con opciones ingresadas
     * Ingresa varias opciones a la vez enviadas por post
     */
    public function insertOptions()
    {
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $store_id= $valoresPost['store_id'];
        $product_id = $valoresPost['product_id'];
        $options = $valoresPost['options'];
        $priorities = $valoresPost['priorities'];
        $poll_detail_id = $valoresPost['poll_detail_id'];
        $user_id = $valoresPost['user_id'];
        $objPollDetailRepo = $this->PollDetailRepo->find($poll_detail_id);
        $created_at = $objPollDetailRepo->created_at;
        $arrayOptions = explode('|',$options);
        $arrayPriorities = explode('|',$priorities);$valorInsert='';
        if (count($arrayOptions)>0)
        {
            for($i = 0; $i < count($arrayOptions); ++$i) {
                if ($arrayOptions[$i]<>'')
                {
                    $objPollOptionDetail = $this->PollOptionDetailRepo->getModel();
                    $objPollOptionDetail->poll_option_id = $arrayOptions[$i];
                    $objPollOptionDetail->result = 1;
                    $objPollOptionDetail->product_id =$product_id;
                    $objPollOptionDetail->company_id =$company_id;
                    $objPollOptionDetail->store_id =$store_id;
                    $objPollOptionDetail->auditor =$user_id;
                    $objPollOptionDetail->created_at =$created_at;
                    if (count($arrayPriorities)>0)
                    {
                        if ($arrayPriorities[$i]<>'')
                        {
                            $objPollOptionDetail->priority = $arrayPriorities[$i];
                        }else{
                            $objPollOptionDetail->priority = 0;
                        }
                    }else{
                        $objPollOptionDetail->priority = 0;
                    }
                    if ($objPollOptionDetail->save())
                    {
                        $valorInsert .=  ' Opción ingresada:'.$arrayOptions[$i];
                    }else{
                        $valorInsert .=  ' Opción NO ingresada:'.$arrayOptions[$i];
                    }
                }
            }
            return Response::json([ 'success'=> 1, 'texto'=> $valorInsert]);
        }else{
            return Response::json([ 'success'=> 0, 'texto'=> 'No hay opciones']);
        }

    }

    //***JAIME ********
    /**
     * @return json succes y fecha de creación
     * Actualiza un poll_option_detail especifico
     * Para una opción especifica poll_option_id enviada por post
     */
    public function updatePollOptionsDetails()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        //$result = $valoresPost['result'];
        //$company_id = $valoresPost['company_id'];
        $poll_option_details_id = $valoresPost['poll_option_details_id'];
        $selected_pol_options_id = $valoresPost['selected_pol_options_id'];
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $pollOptionDetail = $this->PollOptionDetailRepo->getModel();
        $user = $pollOptionDetail::find($poll_option_details_id);
        //return Response::json([ 'success'=> $pollDetail]);
        $user->poll_option_id = $selected_pol_options_id;

        $updateResponse = $user->save();
        if ($updateResponse == true)
        {
            return Response::json([ 'success'=> 1, 'fecha' => $user->created_at]);
        }else{
            return Response::json([ 'success'=> 0, 'fecha' => $user->created_at]);
        }

    }
    
    public function excelCompanies($company_id,$audit_id)
    {
        $compaigne = $this->companyRepo->find($company_id);
        $customer = $this->customerRepo->find($compaigne->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $menus = $this->generateMenusAudits(0,$company_id,1);
        if ($company_id==3){
            $valoresLinksExcels[] = array('nombre' => 'Salsas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_43.php');
            $valoresLinksExcels[] = array('nombre' => 'Aceites Domésticos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_45.php');
            $valoresLinksExcels[] = array('nombre' => 'Caramelos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_46.php');
            $valoresLinksExcels[] = array('nombre' => 'Chocolates', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_47.php');
            $valoresLinksExcels[] = array('nombre' => 'Detergentes', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_48.php');
            $valoresLinksExcels[] = array('nombre' => 'Galletas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_49.php');
            $valoresLinksExcels[] = array('nombre' => 'Margarinas Domésticas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_50.php');
            $valoresLinksExcels[] = array('nombre' => 'Pastas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_51.php');
            $valoresLinksExcels[] = array('nombre' => 'Refrescos Instantáneos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_52.php');
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==18){
            $valoresLinksExcels[] = array('nombre' => 'Salsas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_43.php');
            $valoresLinksExcels[] = array('nombre' => 'Aceites Domésticos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_45.php');
            $valoresLinksExcels[] = array('nombre' => 'Caramelos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_46.php');
            $valoresLinksExcels[] = array('nombre' => 'Chocolates', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_47.php');
            $valoresLinksExcels[] = array('nombre' => 'Detergentes', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_48.php');
            $valoresLinksExcels[] = array('nombre' => 'Galletas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_49.php');
            $valoresLinksExcels[] = array('nombre' => 'Margarinas Domésticas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_50.php');
            $valoresLinksExcels[] = array('nombre' => 'Pastas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_51.php');
            $valoresLinksExcels[] = array('nombre' => 'Refrescos Instantáneos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_52.php');
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==21){
            $valoresLinksExcels[] = array('nombre' => 'Salsas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_43.php');
            $valoresLinksExcels[] = array('nombre' => 'Aceites Domésticos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_45.php');
            $valoresLinksExcels[] = array('nombre' => 'Caramelos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_46.php');
            $valoresLinksExcels[] = array('nombre' => 'Chocolates', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_47.php');
            $valoresLinksExcels[] = array('nombre' => 'Detergentes', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_48.php');
            $valoresLinksExcels[] = array('nombre' => 'Galletas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_49.php');
            $valoresLinksExcels[] = array('nombre' => 'Margarinas Domésticas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_50.php');
            $valoresLinksExcels[] = array('nombre' => 'Pastas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_51.php');
            $valoresLinksExcels[] = array('nombre' => 'Refrescos Instantáneos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_52.php');
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==22){
            $valoresLinksExcels[] = array('nombre' => 'Salsas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_43.php');
            $valoresLinksExcels[] = array('nombre' => 'Aceites Domésticos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_45.php');
            $valoresLinksExcels[] = array('nombre' => 'Caramelos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_46.php');
            $valoresLinksExcels[] = array('nombre' => 'Chocolates', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_47.php');
            $valoresLinksExcels[] = array('nombre' => 'Detergentes', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_48.php');
            $valoresLinksExcels[] = array('nombre' => 'Galletas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_49.php');
            $valoresLinksExcels[] = array('nombre' => 'Margarinas Domésticas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_50.php');
            $valoresLinksExcels[] = array('nombre' => 'Pastas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_51.php');
            $valoresLinksExcels[] = array('nombre' => 'Refrescos Instantáneos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_52.php');
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==15){
            $valoresLinksExcels[] = array('nombre' => 'Salsas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_metro.php');
            $valoresLinksExcels[] = array('nombre' => 'Aceites Domésticos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_plazavea.php');
            $valoresLinksExcels[] = array('nombre' => 'Caramelos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_tottus.php');
            $valoresLinksExcels[] = array('nombre' => 'Chocolates', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_wong.php');
        }
        if ($company_id==23){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Kasnet', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==24){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Full Carga', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==25){
            $valoresLinksExcels[] = array('nombre' => 'Reporte BCP', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==26){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 5 2016 IBK', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==28){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 5 2016 IBK', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==29){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==30){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2Q JULIO', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==31){
            $valoresLinksExcels[] = array('nombre' => 'Reporte IBK', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==32){
            $valoresLinksExcels[] = array('nombre' => 'Reporte BIM', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==33){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q AGOSTO', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==34){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 7 2016', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==35){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2Q AGOSTO', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==36){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==39){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q SETIEMBRE', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==38){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==40){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 8 2016', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==41){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2Q SETIEMBRE', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==43){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==44){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q OCTUBRE', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==45){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 9 2016', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==42){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Alicorp Mayoristas 1', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
            $valoresLinksExcels[] = array('nombre' => 'Reporte Alicorp Mayoristas 1 Productos', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_products.php');
        }
        if ($company_id==46){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==51){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 11 2016', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==53){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==54){
            $valoresLinksExcels[] = array('nombre' => 'Auditorias Kasnet', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==56){
            $valoresLinksExcels[] = array('nombre' => 'Ventas Riqra', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==57){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==59){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==60){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q Febrero 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==61){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Visibilidad Bayer 1', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==62){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Alicorp Hulk 1', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==63){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Alicorp Promotorias 1', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==64){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==65){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2Q Marzo 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==69){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 3 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==70){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q Abril 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==73){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 2Q Abril 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }

        if ($company_id==72){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 4 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==74){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Helena Abril', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==75){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==76){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 5 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==78){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 1Q Junio 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==81){
            $valoresLinksExcels[] = array('nombre' => 'Exhibidores', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_53.php');
            $valoresLinksExcels[] = array('nombre' => 'SOD Ventanas', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'_category_54.php');
        }
        if ($company_id==82){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Helena Junio', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        if ($company_id==84){
            $valoresLinksExcels[] = array('nombre' => 'Reporte Estudio 6 2017', 'link' => $this->urlExcels.'reporte_company_'.$company_id.'.php');
        }
        //dd($valoresLinksExcels);
        return View::make('audits/excelsCompany', compact('customer','compaigne','valoresLinksExcels','menus','logo'));
    }

    public function detailsPublicitySod($company_id,$audit_id,$store_id,$publicity_id,$foto,$publicty_detail_id,$ciudad="0",$auditor_id="0")
    {

        $menus = $this->generateMenusAudits($audit_id,$company_id);
        $detailAudit = $this->auditRepo->find($audit_id);
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);
        $objStore = $this->storeRepo->find($store_id);//dd(count($objStore));
        $alertas="";
        $city = $ciudad;$alertas .= $city." - ";
        $auditor = $auditor_id;
        $obAuditor = $this->userRepo->find($auditor);
        $alertas .= $obAuditor->fullname ."(".$auditor.")"." - ";
        $objPublicity = $this->publicityRepo->find($publicity_id);
        $alertas .= $objPublicity->fullname."(".$publicity_id.")"." - ";

        $objPublicityDetail = $this->PublicitiesDetailRepo->find($publicty_detail_id);//dd($objPublicityDetail);
        $publictyDetail_id = $objPublicityDetail->id;

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
        /*$cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);*/
        $cantidadStoresRouting=0;$cantidadStoresAudit=0;

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');


        $ListAuditor = $this->userRepo->listUserCondition('auditor');
        $auditors= array(0 => "Seleccionar") + $ListAuditor->lists('fullname','id');

        $listCategory = $this->publicityRepo->getPublicityForCatMat($this->valoresCategory[$company_id]['sod'],$company_id);
        $publicities = array(0 => "Seleccionar") + $listCategory->lists('fullname','id');

        $storesxCampaigne = 0;$sod=$objPublicityDetail->sod;$tipo="Sod";
        if ($this->valoresCampaigne[$company_id]['ventanaW']==0)
        {
            $filtro=0;
            $photosAll= $this->MediaRepo->photosPublicityStore($publicity_id,$store_id,$company_id);//dd($photosAll);
            foreach ($photosAll as $photo)
            {
                $urlsFotos[] = array('id' => $photo->id,'archivo' => $photo->archivo,'urlFoto' => $this->urlBase.$this->urlFotos.$photo->archivo,'ingresado' => $photo->created_at);
            }//dd($urlsFotos);
            return View::make('audits/auditSodVentCampaign15', compact('objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }else{
            $filtro = $foto;//$urlsFotos = $this->urlBase.$this->urlFotos.$foto;
            $photosAll= $this->MediaRepo->photosPublicityStore($publicity_id,$store_id,$company_id);//dd($photosAll);
            if (count($photosAll)<>1)
            {
                foreach ($photosAll as $photo)
                {
                    $urlsFotos[] = array('id' => $photo->id,'archivo' => $photo->archivo,'urlFoto' => $this->urlBase.$this->urlFotos.$photo->archivo,'ingresado' => $photo->created_at);
                }
                return View::make('audits/auditSodVentCampaign15', compact('objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
            }else{
                $filtro = $foto;$urlsFotos = $this->urlBase.$this->urlFotos.$foto;
            }
        }

        $valoresPolls= $this->getValores();
        $storeOpen =$valoresPolls[$company_id]['abierto'];
        $storeAbierto = $this->getResponsePolls($store_id,$company_id,0,$storeOpen,'YesNo');

        $storePermitio = $valoresPolls[$company_id]['permitio'];
        $permitio = $this->getResponsePolls($store_id,$company_id,0,$storePermitio,'YesNo');

        $storeExiste = $valoresPolls[$company_id]['existeVent'];
        $existeVent = $this->getResponsePolls($store_id,$company_id,$publicity_id,$storeExiste,'YesNo');


        $storeVisible = $valoresPolls[$company_id]['visibleVent'];
        $visibleVent = $this->getResponsePolls($store_id,$company_id,$publicity_id,$storeVisible,'YesNo');


        $storeW = $valoresPolls[$company_id]['ventanaW'];
        $ventW = $this->getResponsePolls($store_id,$company_id,$publicity_id,$storeW,'YesNo');


        $poll_comoEstaVent = $valoresPolls[$company_id]['comoEstaVent'];
        $comoEstaVent = $this->getResponsePolls($store_id,$company_id,$publicity_id,$poll_comoEstaVent,'Option');

        $pollsResult = array('abierto' => $storeAbierto,'permitio' => $permitio,'existe' => $existeVent,'visible' => $visibleVent,'trabajada' => $ventW,'comoEstaVent'=>$comoEstaVent);
        
        $polls_id = $this->valoresCampaigne[$company_id] ;
        $poll_options_text= $this->PollOptionRepo->getOptions($polls_id['comoEstaVent']) ;
        return View::make('audits/detailSod', compact('pollsResult','tipo','objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus','poll_options_text'));
    }

    public function ListStoresPublicity($ciudad="0",$publicity="0",$auditor_id="0",$audit="0",$company="0",$ventana="0")
    {
        $alertas="";
        if ($ciudad=="0"){
            $valoresPost= Input::all();//dd($valoresPost);
            $audit_id = $valoresPost['audit_id'];
            $company_id = $valoresPost['company_id'];

            if ($valoresPost['ciudad']<>"0"){
                $city =$valoresPost['ciudad'];
                $alertas .= $city." - ";
            }else{
                $city ="0";
            }
            if ($valoresPost['auditor']<>"0"){
                $auditor =$valoresPost['auditor'];
                $obAuditor = $this->userRepo->find($auditor);//dd($obAuditor);
                $alertas .= $obAuditor->fullname ."(".$auditor.")"." - ";
            }else{
                $auditor ="0";
            }
            if ($valoresPost['publicity']<>"0"){
                $publicity_id =$valoresPost['publicity'];
                $objPublicity = $this->publicityRepo->find($publicity_id);//dd($objPublicity);
                $alertas .= $objPublicity->fullname."(".$publicity_id.")"." - ";
            }else{
                $publicity_id ="0";
            }
            if ($valoresPost['tipo']<>"0"){
                $tipo =$valoresPost['tipo'];
            }else{
                $tipo ="0";
            }
        }else{
            $city = $ciudad;$alertas .= $city." - ";
            $auditor = $auditor_id;
            $audit_id = $audit;
            $company_id = $company;
            $tipo =$ventana;
            $obAuditor = $this->userRepo->find($auditor);
            $alertas .= $obAuditor->fullname ."(".$auditor.")"." - ";
            $publicity_id =$publicity;
            $objPublicity = $this->publicityRepo->find($publicity_id);
            $alertas .= $objPublicity->fullname."(".$publicity_id.")"." - ";
        }//dd($this->valoresCampaigne);

        $ventanasw = 1;

        $menus = $this->generateMenusAudits($audit_id,$company_id);
        $detailAudit = $this->auditRepo->find($audit_id);
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);

        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

        $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');


        $ListAuditor = $this->userRepo->listUserCondition('auditor');
        $auditors= array(0 => "Seleccionar") + $ListAuditor->lists('fullname','id');

        if ($tipo=="Sod"){
            $listCategory = $this->publicityRepo->getPublicityForCatMat($this->valoresCategory[$company_id]['sod'],$company_id);
        }
        if ($tipo=="Exhibidor"){
            $listCategory = $this->publicityRepo->getPublicityForCatMat($this->valoresCategory[$company_id]['exhi'],$company_id);
        }

        $publicities = array(0 => "Seleccionar") + $listCategory->lists('fullname','id');

        $storesxCampaigne1 = $this->publicityRepo->getPublicityAlicorp($city,$auditor,$publicity_id,$company_id);
        $publicty_detail_id = 0;$sod = -1;$sw=0;
        if ($tipo=="Sod"){
            if (count($storesxCampaigne1)>0)
            {
                foreach ($storesxCampaigne1 as $store)
                {
                    if ($store->result == null){$result = 0;}else{$result = 1;}

                    $objPublicityDetail = $this->PublicitiesDetailRepo->findDetailForCondition($publicity_id,$store->store_id,$company_id);//dd($objPublicityDetail);
                    if (count($objPublicityDetail)>0){
                        $publicty_detail_id = $objPublicityDetail[0]->id;$sod = $objPublicityDetail[0]->sod;
                        $storeOpen = $this->PollDetailRepo->getRegForStoreCompanyPoll($store->store_id,$company_id,$this->valoresCampaigne[$company_id]['abierto']);//dd($storeOpen);
                        $cantReg = count($storeOpen);
                        if (($cantReg>0) and ($storeOpen[0]->result==1)){
                            $storeAbierto= "Si";
                            $storePermitio = $this->PollDetailRepo->getRegForStoreCompanyPoll($store->store_id,$company_id,$this->valoresCampaigne[$company_id]['permitio']);
                            $cantReg = count($storePermitio);
                            if (($cantReg>0) and ($storePermitio[0]->result==1)){
                                $permitio='Si';
                                $storeExisteVent = $this->PollDetailRepo->getResultForStore($company_id,$store->store_id,$this->valoresCampaigne[$company_id]['existeVent'],$publicity_id);
                                $cantReg = count($storeExisteVent);
                                if (($cantReg>0) and ($storeExisteVent[0]->result==1)){
                                    $existeVent="Si";
                                    $storeSodW = $this->PollDetailRepo->getResultForStore($company_id,$store->store_id,$this->valoresCampaigne[$company_id]['ventanaW'],$publicity_id);
                                    $cantReg = count($storeSodW);
                                    if (($cantReg>0) and($storeSodW[0]->result==1)){$sw =$sw + 1;
                                        $ventW = "Si";
                                        $resultFiltro = array('abierto' => $storeAbierto,'permitio' => $permitio,'existe' => $existeVent,'trabajada' => $ventW);
                                        $storesxCampaigne[] = array('store_id' => $store->store_id,'filtros' => $resultFiltro,'fullname' =>$store->fullname,'auditor_id' =>$store->auditor_id, 'auditor' =>$store->auditor,'departamento'=>$store->departamento,'fecha' =>$store->fecha,'hora' => $store->hora,'result'=>$result,'foto' => $store->foto,'publicity_detail_id' => $publicty_detail_id,'sod'=>$sod);
                                    }
                                }
                            }
                        }
                    } //$this->valoresCampaigne[22] = array('ventanaW' => 255,'abierto' => 252,'permitio' =>254,'existeVent' => 256, 'visibleVent' =>257, 'comoEstaVent'=>258);
                }
            }else{
                $storesxCampaigne = [];
            }
            if($sw==0) {
                $storesxCampaigne = [];
            }
        }
        if ($tipo=="Exhibidor"){
            if (count($storesxCampaigne1)>0) {
                foreach ($storesxCampaigne1 as $store) {
                    if ($store->result == null) {
                        $result = 0;
                    } else {
                        $result = 1;
                    }
                    $objPublicityDetail = $this->PublicitiesDetailRepo->findDetailForCondition($publicity_id,$store->store_id,$company_id);//dd($objPublicityDetail);
                    if (count($objPublicityDetail)>0) {
                        $publicty_detail_id = $objPublicityDetail[0]->id;
                        $sod = $objPublicityDetail[0]->sod;
                        $storesxCampaigne[] = array('store_id' => $store->store_id,'fullname' =>$store->fullname,'auditor_id' =>$store->auditor_id, 'auditor' =>$store->auditor,'departamento'=>$store->departamento,'fecha' =>$store->fecha,'hora' => $store->hora,'result'=>$result,'foto' => $store->foto,'publicity_detail_id' => $publicty_detail_id,'sod'=>$sod);
                    }

                }
            }else{
                $storesxCampaigne[] = array('store_id' => '','fullname' =>'','auditor_id' =>'', 'auditor' =>'','departamento'=>'','fecha' =>'','hora' => '','result'=>'','foto' => '','publicity_detail_id' => '','sod'=>'');
            }
        }//dd($storesxCampaigne);
        $filtro = 'SOD';$urlsFotos = $this->urlBase.$this->urlFotos;$publictyDetail_id='';$sod=0;$objStore=0;//dd($this->valoresCampaigne[$company_id]['ventanaW']);

        if ($tipo=="Sod"){
            $valorPoll = $this->getValores();
            $pollW = $valorPoll[$company_id]['ventanaW'];
            return View::make('audits/auditSodVentCampaign3', compact('pollW','tipo','objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }
        if ($tipo=="Exhibidor"){
            return View::make('audits/auditExhiCampaign3', compact('objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
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
        $menus = $this->generateMenusAudits($audit_id,$company_id);

        $datosStores = $this->getDetailPublicitiesAlicorp($publicity_id,$contaminated,$urlBase,$urlImages,$valores,$company_id);

        $campaigne = $this->companyRepo->find($company_id);
        $campaigne_name = $campaigne->fullname;//dd($campaigne_name);

        return View::make('audits/detailPublicities', compact('menus','company_id','city','dex','audit_id','datosStores','campaigne_name'));
    }

    public function ListStoresForAudit($audit_id, $company_id, $nroReg="0")
    {
        $menus = $this->generateMenusAudits($audit_id,$company_id);
        $detailAudit = $this->auditRepo->find($audit_id);
        $campaigne = $this->companyRepo->find($company_id);//dd($campaigne);
        $customer =$this->customerRepo->find($campaigne->customer_id);//dd($customer);
        $publicity_id=0;//dd($audit_id);
        $alertas="";
        if ($audit_id <> 1)
        {
            $roadsForCompany = $this->companyStoreRepo->getStoresForCampaigne($company_id);//dd($roadsForCompany[0]);
            $QAuditClose = $this->companyStoreRepo->getStoresRoadsRouting($roadsForCompany, 1);
            $QStoresForCompany = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);
        }

        if ($audit_id == 1)
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

            $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
            $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');


            $ListAuditor = $this->userRepo->listUserCondition('auditor');
            $auditors= array(0 => "Seleccionar") + $ListAuditor->lists('fullname','id');

            $listCategory = $this->publicityRepo->getPublicityForCatMat($this->valoresCategory[$company_id]['sod'],$company_id);
            $publicities = array(0 => "Seleccionar") + $listCategory->lists('fullname','id');//dd($publicities);

            $storesxCampaigne=0;$filtro = '0';$urlsFotos='';$publictyDetail_id='';$sod=0;$city="";$auditor="";$objStore=0;$tipo="Sod";

            return View::make('audits/auditSodVentCampaign3', compact('tipo','objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }
        if ((($audit_id >= 7) and ($audit_id <= 11)) or (($audit_id >= 20) and ($audit_id <= 24)) or (($audit_id >= 25) and ($audit_id <= 29)) or (($audit_id >= 30) and ($audit_id <= 34)  and ($audit_id == 54)) or ($audit_id == 52))
        {
            $num_reg = $QStoresForCompany - $QAuditClose;
            $regInsertAudit = $num_reg;
            return View::make('audits/auditListForCampaignIbk', compact('customer','campaigne','detailAudit','QStoresForCompany','QAuditClose','regInsertAudit','audit_id','menus'));
        }
        if (($audit_id ==4) or ($audit_id ==37) or ($audit_id ==42) or ($audit_id ==39) or ($audit_id ==40) or ($audit_id ==41) or ($audit_id ==44) or ($audit_id ==46))
        {
            $num_reg = $QStoresForCompany - $QAuditClose;
            $regInsertAudit = $num_reg;
            return View::make('audits/auditListForCampaignIbk', compact('customer','campaigne','detailAudit','QStoresForCompany','QAuditClose','regInsertAudit','audit_id','menus'));
        }
        if ($audit_id == 2)
        {
            if ($nroReg == "all"){
                $storesxCampaigne = $this->companyStoreRepo->getPresenceForCampaigne($company_id,"0");
                $vista = "todos";
            }else{
                $storesxCampaigne = $this->companyStoreRepo->getPresenceForCampaigne($company_id);
                $vista = "50 primeros";
            }
            $num_reg = $this->companyStoreRepo->getCountPresenceForCampaigne($company_id);
        }

        if ($audit_id == 3)
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);
            $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
            $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');


            $ListAuditor = $this->userRepo->listUserCondition('auditor');
            $auditors= array(0 => "Seleccionar") + $ListAuditor->lists('fullname','id');

            $listCategory = $this->publicityRepo->getPublicityForCatMat($this->valoresCategory[$company_id]['exhi'],$company_id);
            $publicities = array(0 => "Seleccionar") + $listCategory->lists('fullname','id');//dd($publicities);

            $storesxCampaigne=0;$filtro = '0';$urlsFotos='';$publictyDetail_id='';$sod=0;$city="";$auditor="";$objStore=0;
            return View::make('audits/auditExhiCampaign3', compact('objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }

        if (($audit_id == 14) or ($audit_id == 48) or ($audit_id ==49) or ($audit_id ==50) or ($audit_id ==51))
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

            return View::make('audits/auditsQuestions', compact('customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }

        if ($audit_id == 19)
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

            $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
            $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');


            $ListAuditor = $this->userRepo->listUserCondition('auditor');
            $auditors= array(0 => "Seleccionar") + $ListAuditor->lists('fullname','id');

            $listCategory = $this->publicityRepo->getPublicityForCatMat(55,$company_id);
            $publicities = array(0 => "Seleccionar") + $listCategory->lists('fullname','id');//dd($publicities);

            $storesxCampaigne=0;$filtro = '0';$urlsFotos='';$publictyDetail_id='';$sod=0;$city="";$auditor="";$objStore=0;

            return View::make('audits/auditSodVentCampaign3', compact('objStore','city','auditor','alertas','sod','publictyDetail_id','publicity_id','publicities','urlsFotos','filtro','storesxCampaigne','company_id','auditors','ciudades','customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }
        if ($audit_id ==36)
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);
            return View::make('audits/auditListForCampaignBIM', compact('customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }
        if ($audit_id == 38)
        {
            $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
            $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
            $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

            return View::make('audits/auditsQuestions', compact('customer','campaigne','detailAudit','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','audit_id','menus'));
        }
        $regInsertAudit = $num_reg[0]->Num_Reg;
        return View::make('audits/auditListForCampaign', compact('vista','customer','campaigne','detailAudit','QStoresForCompany','QAuditClose','regInsertAudit','audit_id','menus','storesxCampaigne'));
    }

    public function DetailAudit($audit_id, $company_id, $store_id)
    {
        $menus = $this->generateMenusAudits($audit_id,$company_id);
        $detailAudit = $this->auditRepo->find($audit_id);
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);
        $store_detail = $this->storeRepo->find($store_id);
        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';

        if ($audit_id == 2)
        {
            $datosDetail = $this->presenceDetailRepo->getPresenceForStore($store_id);
            $num_reg = $this->companyStoreRepo->getCountPresenceForCampaigne($company_id);

        }
        if ($audit_id == 3)
        {
            $datosDetail0 = $this->PublicitiesDetailRepo->getPublicitiesForStore($store_id);
            $num_reg = $this->companyStoreRepo->getCountPublicityForCampaigne($company_id);
            if(! empty($datosDetail0)){
                foreach ($datosDetail0 as $publicityDetail){
                    $photos = $this->MediaRepo->photosPublicityStore($publicityDetail->publicity_id, $publicityDetail->store_id);

                    if(! empty($photos)){
                        foreach ($photos as $photo){
                            $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $urlBase.$urlImages.$photo->archivo);
                        }

                    }else{
                        $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                    }
                    $datosDetail[] = array('publicity_id' => $publicityDetail->publicity_id, 'fullname' => $publicityDetail->publicity->fullname,'layout' =>$publicityDetail->layout, 'visible' => $publicityDetail->visible, 'contaminated' => $publicityDetail->contaminated, 'comment' => $publicityDetail->comment, 'arrayFoto' => $datosFoto, 'fechaCreated' => $publicityDetail->created_at,'fechaUpdated' => $publicityDetail->updated_at);
                    //dd($datosStores);
                    unset($datosFoto);
                }
            }else{
                $datosDetail[] = array('publicity_id' => 0, 'fullname' => '','layout' =>'', 'visible' => '', 'contaminated' => '', 'comment' => '', 'arrayFoto' => '', 'fechaCreated' => '','fechaUpdated' => '');
            }
        }
        $registros = $num_reg[0]->Num_Reg;
        return View::make('audits/auditDetailForStore', compact('store_detail','customer','campaigne','detailAudit','registros','audit_id','menus','datosDetail'));
    }

    public function closedPoints(){

        $titulo = 'Cliente';
        $links[] = array('nombre' => 'Excel General', 'url' => URL::to('/')."/reportes_excel/report_close_general.php", 'target' => 1);
        $links[] = array('nombre' => 'Excel Palmeras', 'url' => URL::to('/')."/reportes_excel/report_close_palmeras.php", 'target' => 1);
        $links[] = array('nombre' => 'Excel Promotoria', 'url' => URL::to('/')."/reportes_excel/report_close_promotoria.php", 'target' => 1);
        return View::make('audits/homeAudits', compact('links','titulo'));
    }


} 
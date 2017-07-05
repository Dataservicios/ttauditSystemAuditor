<?php

use Auditor\Repositories\AlertRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\AlertCommentRepo;

class AlertsController extends BaseController
{

    protected $customerRepo;
    protected $companyRepo;
    protected $storeRepo;
    protected $userRepo;
    protected $mediaRepo;
    protected $alertCommentRepo;

    public $urlBase;
    public $urlImages;
    public $urlPhotos;

    public function __construct(AlertCommentRepo $alertCommentRepo,MediaRepo $mediaRepo,UserRepo $userRepo, StoreRepo $storeRepo, CompanyRepo $companyRepo, CustomerRepo $customerRepo, AlertRepo $alertRepo)
    {
        $this->alertRepo = $alertRepo;
        $this->customerRepo = $customerRepo;
        $this->companyRepo = $companyRepo;
        $this->storeRepo = $storeRepo;
        $this->userRepo = $userRepo;
        $this->mediaRepo = $mediaRepo;
        $this->alertCommentRepo = $alertCommentRepo;

        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/images/';
        $this->urlPhotos = '/media/fotos/';
    }

    public function alertDetail($alert_id)
    {
        $listComments = $this->alertCommentRepo->getListAlertComments(50,$alert_id,'ASC');
        if (count($listComments)>0){
            foreach ($listComments as $listComment) {
                $objUserComment = $this->userRepo->find($listComment->user_id);
                $arrayComments[] = array('id' => $listComment->id,'alert_id'=>$listComment->alert_id,'user_id'=>$listComment->user_id,'creator'=>$objUserComment->fullname,'ip'=>$listComment->ip,'comment'=>$listComment->comment,'created_at'=>$listComment->created_at);
            }
        }else{
            $arrayComments = [];
        }

        $titulo = "Notificaciones de Alerta IBK";
        $objAlert = $this->alertRepo->find($alert_id);
        $customer_id = $objAlert->customer_id;
        $customer =$this->customerRepo->find($customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;
        $company_id = $objAlert->company_id;
        $menus = $this->generateMenusInterbank($company_id,0,2);
        $objStore = $this->storeRepo->find($objAlert->store_id);
        $objAuditor = $this->userRepo->find($objAlert->user_id);
        $objEjecutivo = $this->userRepo->find($objAlert->ejecutivo_id);
        $photos = $this->mediaRepo->photosPollStore($objAlert->poll_id,$objAlert->store_id);
        if(! empty($photos)){
            foreach ($photos as $photo){
                $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlPhotos.$photo->archivo);
            }

        }else{
            $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
        }
        return View::make('report/interbank/detailAlerts', compact('titulo','objAlert','objStore','objAuditor','objEjecutivo','logo','menus','datosFoto','arrayComments'));
    }


    public function getLastAlerts($customer_id)
    {
        /*$carbon = new Carbon\Carbon();
        $carbon->setTimezone('America/Lima');
        $var=$carbon->toDateTimeString();dd($var);*/
        $titulo = "Alertas de ejecutivos";
        $alerts = $this->alertRepo->getLatestAlerts(50);
        if (count($alerts)>0){
            foreach ($alerts as $alert) {
                $objStore = $this->storeRepo->find($alert->store_id);
                if (is_object($objStore)){
                    $ciudad = $objStore->ubigeo;
                    $objUser = $this->userRepo->getUserForEmail($objStore->ejecutivo,$customer_id);
                    $ejecutivo = $objUser->fullname;
                    $store_id = $objStore->id;
                    $punto= $objStore->fullname;
                    $countComments = $this->alertCommentRepo->getCountCommentsForAlert($alert->id);
                    if ($countComments>0) $comentado= true; else $comentado=false;
                }else{
                    $ciudad = '';
                    $ejecutivo = '';
                    $store_id = 0;
                    $punto= '';
                    $comentado=false;
                }
                $valores[] = array('id'=>$alert->id,'store_id'=>$store_id,'punto'=>$punto,'titulo'=>$alert->titulo,'motivo' => $alert->motivo,'ciudad'=>$ciudad,'ejecutivo'=>$ejecutivo,'comentado'=>$comentado,'fecha'=>$alert->created_at);
            }
        }else{
            $valores =[];
        }

        $customer =$this->customerRepo->find($customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImages.$customer->corto.'/'.$customer->logo;
        $obj_company_id = $this->companyRepo->getFirstCurrentCampaigns($customer_id);
        $company_id = $obj_company_id->id;
        $menus = $this->generateMenusInterbank($company_id,0,2);
        $campaigneAlert = $this->alertRepo->getCampaigneWithAlerts($customer_id);
        $campaignes = array(0 => "Seleccionar") + $campaigneAlert->lists('fullname','company_id');
        
        return View::make('report/interbank/listAlerts', compact('titulo','valores','logo','menus','campaignes'));
    }

    public function insertComment()
    {
        $valoresPost= Input::all();
        $alert_id = $valoresPost['alert_id'];
        $message = $valoresPost['message'];
        $user_id = $valoresPost['user_id'];
        $user_father_id = $valoresPost['user_father_id'];
        $emails = $valoresPost['emails'];
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $objAlertComment = $this->alertCommentRepo->getModel();
        $ip = $_SERVER['REMOTE_ADDR'];

        $objAlertComment->alert_id = $alert_id;
        $objAlertComment->comment = $message;
        $objAlertComment->user_id = $user_id;
        $objAlertComment->authorized = 1;
        $objAlertComment->ip = $ip;
        $objAlertComment->user_father_id = $user_father_id;
        $updateResponse = $objAlertComment->save();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        if ($updateResponse == true)
        {
            return Response::json([ 'success'=> 1]);
        }else{
            return Response::json([ 'success'=> 0]);
        }

    }

    public function ajxLoadComments()//falta implementar
    {
        $valoresPost= Input::all();
        $alert_id = $valoresPost['alert_id'];
        $order = $valoresPost['order'];
        $listComments = $this->alertCommentRepo->getListAlertComments(50,$alert_id,$order);
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($listComments);
    }
} 
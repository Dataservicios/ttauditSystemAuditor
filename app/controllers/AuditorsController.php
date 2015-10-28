<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 25/06/2015
 * Time: 02:50 PM
 */

use Auditor\Repositories\MediaRepo;
use Auditor\Managers\MediaManager;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Managers\ImageManager;

class AuditorsController extends BaseController{

    protected $mediaRepo;
    protected $pollRepo;
    protected $storeRepo;
    protected $companyStoreRepo;
    protected $imageManager;

    public function __construct(MediaRepo $mediaRepo, PollRepo $pollRepo, StoreRepo $storeRepo, CompanyStoreRepo $companyStoreRepo, ImageManager $imageManager)
    {
        $this->mediaRepo = $mediaRepo;
        $this->pollRepo = $pollRepo;
        $this->storeRepo = $storeRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->imageManager = $imageManager;
    }

    public function auditorHome($id="0",$opcion="0")
    {
        $userType = Auth::user()->type;
        switch ($id) {
            case 1:
                $polls[] = array('poll' =>'¿El letrero de IBK Agente era visible desde fuera?', 'poll_id' => 2);
                $polls[] = array('poll' =>'¿El Interbank Agente es visible estando dentro del establecimiento?', 'poll_id' => 3);
                $polls[] = array('poll' =>'¿Le entregaron ESPONTÁNEAMENTE un comprobante luego de la transacción? (Si no le entregaron espontáneamente el voucher deben solicitarlo y adjuntarlo al formulario)', 'poll_id' => 15);
                $polls[] = array('poll' =>'¿Se encuentra abierto el agente?', 'poll_id' => 27);//dd($polls);

                return View::make('auditors/operations', compact('polls','userType','opcion','id'));
                break;
            case 8:
                $polls[] = array('poll' =>'¿Se encuentra abierto el agente?', 'poll_id' => 67);
                $polls[] = array('poll' =>'¿El letrero de IBK Agente era visible desde fuera?', 'poll_id' => 42);
                $polls[] = array('poll' =>'¿El Interbank Agente es visible estando dentro del establecimiento?', 'poll_id' => 43);
                $polls[] = array('poll' =>'¿Le entregaron ESPONTÁNEAMENTE un comprobante luego de la transacción? (Si no le entregaron espontáneamente el voucher deben solicitarlo y adjuntarlo al formulario)', 'poll_id' => 55);
                //dd($polls);

                return View::make('auditors/operations', compact('polls','userType','opcion','id'));
                break;
            default:
                $valorNroReportes = 0;
                return View::make('auditors/inicio', compact('userType','valorNroReportes','opcion'));
                break;
        }


    }

    public function insertPhotos($poll_id="0")
    {

        $media = $this->mediaRepo->getModel();
        $file = Input::file("archivo");
        //dd($file);
        $val=Input::only(['store_id']);
        $company_id=Input::only(['company_id']);
        $nomb_arch="";
        for ($i = 1; $i <= 6-strlen($val['store_id']); $i++) {
            $nomb_arch.="0";
        }
        $nomb_arch.=$val['store_id']."-Agente_foto_".date("Ymd_Gis").'.'.$file->getClientOriginalExtension();

        $media->archivo = $nomb_arch;
        $media->tipo=1;
        $manager = new MediaManager($media, Input::only(['store_id','poll_id']));

        $manager->save();

        $file->move("media/fotos",$nomb_arch);

        $ruta_origen = "media/fotos/";
        $width ='400';
        list($widthi, $heighti, $typei, $attri) = GetImageSize($ruta_origen .$nomb_arch);
        if ($widthi>$width){
            $ruta_destino = $ruta_origen;
            $nombre_archivo=$nomb_arch;
            $this->imageManager->getImage($ruta_origen.$nomb_arch);
            $this->imageManager->thumbnail($width);
            $this->imageManager->save($ruta_destino .$nombre_archivo);
            $this->imageManager->Terminar();
            $archivo_final=$ruta_destino.$nombre_archivo;
            //dd($archivo_final);
        }

        //dd($store);
        return Redirect::route('auditorClient', $company_id['company_id']);
    }

    public function getPhotoPollStore($poll_id,$store_id)
    {
        $photos=$this->mediaRepo->photosPollStore($poll_id,$store_id);
    }

    public function detailPollPhoto($poll_id="0",$company_id=0,$opcion="0")
    {
        $userType = Auth::user()->type;
        $question = $this->pollRepo->find($poll_id);
        //$stores_list = $this->storeRepo->allReg()->lists('codclient', 'id');
        /*$list_stores = $this->companyStoreRepo->getStoresForCompany($company_id);

        foreach ($list_stores as $list){
            $stores_list[$list->id] = $list->id.'-'.$list->codclient.'-'.$list->fullname;
        }

        $stores = array(0 => "--- Seleccione un agente --- ") + $stores_list;
        $selected = array();*/
        //dd($stores);route('auditorClient', 1)
        return View::make('auditors/detailPollPhoto', compact('poll_id','userType','question','stores','selected','opcion','company_id'));
    }
} 
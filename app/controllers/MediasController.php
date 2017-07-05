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
use Auditor\Repositories\AuditRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\PublicityRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Managers\PublicityDetailManager;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\ProductRepo;
use Auditor\Repositories\ProductDetailRepo;
use Auditor\Repositories\PublicityStoreRepo;
use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\UserRepo;


class MediasController extends BaseController{

    protected $MediaRepo;
    protected $pollRepo;
    protected $storeRepo;
    protected $companyStoreRepo;
    protected $imageManager;
    protected $customerRepo;
    protected $companyRepo;
    protected $auditRepo;
    protected $roadDetailRepo;
    protected $publicityRepo;
    protected $publicitiesDetailRepo;
    protected $CompanyAuditRepo;
    protected $PollDetailRepo;
    protected $PollOptionDetailRepo;
    protected $PollOptionRepo;
    protected $ProductRepo;
    protected $ProductDetailRepo;
    protected $publicityStoreRepo;
    protected $categoryProductRepo;
    protected $userRepo;

    public $urlBase;
    public $urlImagesFotos;
    public $urlImageBase;

    public function __construct(UserRepo $userRepo,CategoryProductRepo $categoryProductRepo,PublicityStoreRepo $publicityStoreRepo,ProductDetailRepo $ProductDetailRepo,ProductRepo $ProductRepo,PollOptionRepo $PollOptionRepo,PollOptionDetailRepo $PollOptionDetailRepo,PollDetailRepo $PollDetailRepo,CompanyAuditRepo $CompanyAuditRepo,PublicitiesDetailRepo $publicitiesDetailRepo,PublicityRepo $publicityRepo,RoadDetailRepo $roadDetailRepo,CompanyRepo $companyRepo,CustomerRepo $customerRepo,AuditRepo $auditRepo,MediaRepo $MediaRepo, PollRepo $pollRepo, StoreRepo $storeRepo, CompanyStoreRepo $companyStoreRepo, ImageManager $imageManager)
    {
        $this->MediaRepo = $MediaRepo;
        $this->pollRepo = $pollRepo;
        $this->storeRepo = $storeRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->imageManager = $imageManager;
        $this->auditRepo = $auditRepo;
        $this->customerRepo = $customerRepo;
        $this->companyRepo = $companyRepo;
        $this->roadDetailRepo = $roadDetailRepo;
        $this->publicityRepo = $publicityRepo;
        $this->publicitiesDetailRepo = $publicitiesDetailRepo;
        $this->CompanyAuditRepo = $CompanyAuditRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->PollOptionRepo = $PollOptionRepo;
        $this->ProductRepo = $ProductRepo;
        $this->ProductDetailRepo = $ProductDetailRepo;
        $this->publicityStoreRepo = $publicityStoreRepo;
        $this->categoryProductRepo = $categoryProductRepo;
        $this->userRepo = $userRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImagesFotos = '/media/fotos/';
        $this->urlImageBase = '/media/images/';

    }

    public function mediasHome($id="0",$opcion="0")
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

    public function photoGallery($company_id="0",$audit_id="0")
    {
        $company = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($company->customer_id);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;

        $titulo = 'Galería de Fotos';$audit_id=0;
        $subtitulo = "Competencia";
        $menus = $this->generateMenusBayer($company_id,$audit_id,3);
        $ruta_origen = "media/";
        /*$ruta_destino = "media/";*/
        $url=$this->urlBase;
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);

        $ListUbigeos = $this->storeRepo->getDepartamentForCampaigne($company_id,2);
        $ListCadenas = $this->storeRepo->getCadenasForCampaigne($company_id,2);
        $ListHorizontales[] = "Detallista";$ListHorizontales[] ="Mini Cadenas";$ListHorizontales[] ="Sub Distribuidor";
        $listEjecutivos = $this->storeRepo->getEjecutivosForCampaigne($company_id);
        $ejecutivos = array(0 => "Seleccionar") +  $listEjecutivos->lists('ejecutivo','ejecutivo');
        $ListOperaciones[] = "Farmacias Cerradas";$ListOperaciones[] ="No Acepto Premio";

        /*$image = $ruta_origen.'pruebas_rotar_R.jpg';
        $imageFinal = $ruta_destino.'pruebas_rotar_R.jpg';*/
        // Tipo de contenido
        /*header('Content-type: image/jpeg');*/

        /*$origen = imagecreatefromjpeg($image);
        $rotar = imagerotate($origen,-90, 0);
        imagejpeg($rotar,$imageFinal);
        imagedestroy($rotar);*/
        return View::make('report/homeGaleriaFotos', compact('logo','menus','company_id','audit_id','url','customer','ListUbigeos','ListCadenas','ListHorizontales','ejecutivos','ListOperaciones'));
    }

    public function girarFoto($foto="",$grado=90,$tipo=1)
    {
        if ($foto==""){
            $valoresPost= Input::all();
            $foto = $valoresPost['foto'];
            $grado = $valoresPost['grado'];
            $tipo = $valoresPost['tipo'];
        }
        $ruta_origen = "media/fotos/";
        $ruta_destino = "media/fotos/";

        $image = $ruta_origen.$foto;
        $imageFinal = $ruta_destino.$foto;
        /*$this->imageManager->getImage($image);
        $this->imageManager->rotate(90, array(255, 255, 255, 127));
        $this->imageManager->save($imageFinal);
        $this->imageManager->Terminar();*/
        header('Content-type: image/jpeg');
        $size=getimagesize($image);
        switch($size["mime"]){
            case "image/jpeg":
                $origen = imagecreatefromjpeg($image); //jpeg file
                break;
            case "image/gif":
                $origen = imagecreatefromgif($image); //gif file
                break;
            case "image/png":
                $origen = imagecreatefrompng($image); //png file
                break;
            default:
                $origen=false;
                break;
        }
        $w = imagesx($origen);
        $h = imagesy($origen);

//calculate new image dimensions (preserve aspect)
        if(isset($_GET['w']) && !isset($_GET['h'])){
            $new_w=$_GET['w'];
            $new_h=$new_w * ($h/$w);
        } elseif (isset($_GET['h']) && !isset($_GET['w'])) {
            $new_h=$_GET['h'];
            $new_w=$new_h * ($w/$h);
        } else {
            $new_w=isset($_GET['w'])?$_GET['w']:560;
            $new_h=isset($_GET['h'])?$_GET['h']:560;
            if(($w/$h) > ($new_w/$new_h)){
                $new_h=$new_w*($h/$w);
            } else {
                $new_w=$new_h*($w/$h);
            }
        }

        $im2 = ImageCreateTrueColor($new_w, $new_h);
        imagecopyResampled ($im2, $origen, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
//effects
        if(isset($_GET['blur'])){
            $lv=$_GET['blur'];
            for($i=0; $i<$lv;$i++){
                $matrix=array(array(1,1,1),array(1,1,1),array(1,1,1));
                $divisor = 9;
                $offset = 0;
                imageconvolution($im2, $matrix, $divisor, $offset);
            }
        }
        if(isset($_GET['sharpen'])){
            $lv=$_GET['sharpen'];
            for($i=0; $i<$lv;$i++){
                $matrix = array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1));
                $divisor = 8;
                $offset = 0;
                imageconvolution($im2, $matrix, $divisor, $offset);
            }
        }
        $rotar = imagerotate($im2,-$grado, 0);
        imagejpeg($rotar,$imageFinal);
        imagedestroy($rotar);
        imagedestroy($im2);
        return Response::json([ 'success'=> 1]);
    }

    public function insertPhotos($poll_id="0")
    {

        $media = $this->MediaRepo->getModel();//dd(Input::all());
        $file = Input::file("archivo");
        
        //dd($file);
        $val=Input::only(['store_id']);
        $audit_id=Input::only(['audit_id']);
        $company_id=Input::only(['company_id']);
        $fecha = Input::only(['fecha']);;
        $tipo=Input::only(['tipo']);
        $user_id=Input::only(['user_id']);
        $objeto_id=Input::only(['objeto_id']);
        $cliente =Input::only(['cliente']);
        
        $nomb_arch="";
        for ($i = 1; $i <= 6-strlen($val['store_id']); $i++) {
            $nomb_arch.="0";
        }
        $nomb_arch.=$val['store_id']."_".$company_id['company_id']."_".$cliente['cliente']."_admin_".date("Ymd_Gis").'.'.$file->getClientOriginalExtension();

        $media->archivo = $nomb_arch;
        $media->tipo=1;
        if ($tipo['tipo']==1){
            $media->poll_id=0;
            $media->publicities_id=$objeto_id['objeto_id'];
            $objPublicityDetails = $this->publicitiesDetailRepo->getRegForStoreCompanyPubli($val['store_id'],$company_id['company_id'],$objeto_id['objeto_id']);//dd(count($objPublicityDetails));
            if (count($objPublicityDetails)==0){
                $PublicityDetail = $this->publicitiesDetailRepo->getModel();
                $PublicityDetail->publicity_id=$objeto_id['objeto_id'];
                $PublicityDetail->company_id=$company_id['company_id'];
                $PublicityDetail->result=1;
                $PublicityDetail->user_id=$user_id['user_id'];
                $PublicityDetail->created_at=$fecha['fecha'];
                $managerPD = new PublicityDetailManager($PublicityDetail, Input::only(['store_id']));
                $managerPD->save();
                $objPublicityDetails = $this->publicitiesDetailRepo->getRegForStoreCompanyPubli($val['store_id'],$company_id['company_id'],$objeto_id['objeto_id']);
            }
            //dd($objPublicityDetails[0]);
        }
        if ($tipo['tipo']==0){
            $media->publicities_id=0;
            $media->poll_id=$objeto_id['objeto_id'];
        }
        if ($tipo['tipo']==2){
            $ids = explode('|',$objeto_id['objeto_id']);
            $media->poll_id=$ids[0];
            $media->category_product_id=$ids[1];
            $media->publicities_id=$ids[2];
            $media->product_id=$ids[3];
        }
        $media->company_id=$company_id['company_id'];
        $media->created_at = $fecha['fecha'];

        $manager = new MediaManager($media, Input::only(['store_id']));

        $manager->save();

        $file->move("media/fotos",$nomb_arch);
        if ($tipo['tipo']==0){
            return Redirect::route('mediaDetailPhoto', [$company_id['company_id'],$audit_id['audit_id'],$tipo['tipo'],$objeto_id['objeto_id'],$val['store_id'],$cliente['cliente']]);
        }
        if ($tipo['tipo']==1){
            return Redirect::route('mediaDetailPhoto', [$company_id['company_id'],$audit_id['audit_id'],$tipo['tipo'],$objeto_id['objeto_id'],$val['store_id']]);
        }
        if ($tipo['tipo']==2){
            return Redirect::route('mediaDetailPhoto', [$company_id['company_id'],$audit_id['audit_id'],0,$media->poll_id,$val['store_id'],$cliente['cliente']]);
        }

    }

    public function getPhotoPollStore($poll_id,$store_id)
    {
        $photos=$this->MediaRepo->photosPollStore($poll_id,$store_id);
    }

    public function detailPhoto($company_id="0",$audit_id="0",$tipo="0",$objeto_id="0",$store_id="0",$cliente="0")
    {
        //tipo=0->encuesta, tipo=1->publicity 'admin/audits/medias/detailPhoto/{company_id}/{audit_id}/{tipo}/{id}/{store_id}/{cliente?}/{info?}'
        if ($company_id=="0"){
            $valoresPost= Input::all(); //dd($valoresPost);
            $company_id = $valoresPost['company_id'];
            $audit_id = $valoresPost['audit_id'];
            $tipo = $valoresPost['tipo'];
            $store_id = $valoresPost['store_id'];
            $cliente = $valoresPost['cliente'];
        }
        $menus = $this->generateMenusAudits($audit_id,$company_id);
        $detailAudit = $this->auditRepo->find($audit_id);//dd($detailAudit);
        $campaigne = $this->companyRepo->find($company_id);//dd($campaigne);
        if ($campaigne->auditoria==1){
            $objRoadDetail = $this->roadDetailRepo->getRoadForStoreCompany($store_id,$company_id);//dd($objRoadDetail[0]);
        }else{
            $objRoadDetail = [];
        }

        $customer =$this->customerRepo->find($campaigne->customer_id);//dd($customer);
        $objStore = $this->storeRepo->find($store_id);//dd($store_id);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;//dd($tipo);
        if ($tipo==0){
            $titulo = 'Encuestas';
            $companyAuditId= $this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id);
            $Polls = $this->pollRepo->getPollsForAuditForCompany($companyAuditId);//dd($Polls);
            $productosCampaigne = $this->ProductDetailRepo->getProductsForCampaigne($company_id);
            if (($objStore->tipo_bodega=='3D') or ($objStore->tipo_bodega=='6D') or ($objStore->tipo_bodega=='CONGLOMERADO') or ($objStore->tipo_bodega=='') or ($objStore->tipo_bodega==null)){
                $publicityStores= $this->publicityStoreRepo->getPublicityStores("0",$company_id);
            }else{
                $publicityStores= $this->publicityStoreRepo->getPublicityStores($objStore->tipo_bodega,$company_id);
            }
            foreach ($Polls as $poll)
            {//dd($poll);
                if ($poll->product==1)
                {
                    $arrayClase[] = array('objeto' => $this->ProductDetailRepo->getProductsForCampaigne($company_id), 'tipo' => 'Product');
                }else{
                    $arrayClase[] = array('objeto' => [], 'tipo' => 'Product');
                }
                if ($poll->publicity==1)
                {
                    if (($objStore->tipo_bodega=='3D') or ($objStore->tipo_bodega=='6D') or ($objStore->tipo_bodega=='CONGLOMERADO') or ($objStore->tipo_bodega=='') or ($objStore->tipo_bodega==null)){
                        $arrayClase[]= array('objeto' =>$this->publicityStoreRepo->getPublicityStores("0",$company_id), 'tipo' => 'Publicity');
                    }else{
                        $arrayClase[]= array('objeto' =>$this->publicityStoreRepo->getPublicityStores($objStore->tipo_bodega,$company_id), 'tipo' => 'Publicity');
                    }
                }else{
                    $arrayClase[] = array('objeto' => [], 'tipo' => 'Publicity');
                }

                if ($poll->categoryProduct==1)
                {
                    $categoryProducts= $this->getCategoryProductCampaigne();
                    //dd($categoryProducts);
                    foreach ($categoryProducts as $categoryProduct) {
                        $valoCategory[] = $this->categoryProductRepo->find($categoryProduct);
                    }
                    $arrayClase[] = array('objeto' => $valoCategory, 'tipo' => 'CategoryProduct');
                }else{
                    $arrayClase[] = array('objeto' => [], 'tipo' => 'CategoryProduct');
                }
                //dd($arrayClase);

                $photos = $this->MediaRepo->photosProductPollStore($poll->id,$store_id,$company_id);
                $valPoll[] = $poll;
                $arrayClase[] = array('objeto' => $valPoll, 'tipo' => 'Poll');unset($valPoll);

                if(! empty($photos)){
                    //dd($photos);
                    //dd(\App::make('url')->to('/'));
                    foreach ($photos as $photo){
                        $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlImagesFotos.$photo->archivo);
                    }
                }else{
                    $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                }//dd($datosFoto);
                if ($cliente== 'Interbank'){
                    if ($company_id>=45)
                    {
                        $valorCompany = $company_id;
                    }else{
                        $valorCompany = "0";
                    }

                }else{
                    $valorCompany = $company_id;
                }
                $datos = $this->getResponsesForPoll($store_id,$valorCompany,0,$poll->id,0);
                /*{{--@if(count($poll_detail['poll_option_details'])>0)
                    @foreach($poll_detail['poll_option_details'] as $poll_option_detail)
                    @if(count($poll_option_detail)>0)
                {{ Form::select('categories[]',$valFotos[$poll->id]['responses']['options'],$objPollOptionDetail,['class' => 'form-control','multiple' => 'multiple']) }}

                                                                                            @endif
                                                                                        @endforeach
                                                                                    @else
                                                                                        <option value="{{ $option->id }}">{{ $option->options }}</option>
                    @endif--}}*/

                //getResponsesForPoll($store_id,$company_id,$publicity_id,$poll_id,$product_id="0")
                //dd($datos);
                //if ($poll->id==521){dd($datos);}
                /*if ($customer->id== 5){
                    if ($poll->sino == 1)
                    {
                        $respSiNo[] = $this->getResponsePolls($store_id,$company_id,0,$poll->id,'YesNo');//dd($poll);
                    }else{
                        $respSiNo[] = [];
                    }
                    if ($poll->options == 1)
                    {
                        $respOption[] = $this->getResponsePolls($store_id,$company_id,0,$poll->id,'Option');//dd($poll);
                    }else{
                        $respOption[] = [];
                    }
                }*/
                //$responsePolls = $this->getResponsePolls($store_id,$company_id,0,$poll->id,'YesNo');
                $objPollDetails = $this->PollDetailRepo->getRegForStoreCompanyPoll($store_id,$valorCompany,$poll->id);
                if (($customer->id== 5) or ($customer->id== 1) or ($customer->id== 4) or ($customer->id== 9) or ($customer->id== 10)){
                    //$valFotos[$poll->id] = array('arrayFoto'=>$datosFoto,'poll_detail' => $objPollDetails,'respSiNo' => $respSiNo, 'respOption' => $respOption);unset($datosFoto);unset($respSiNo);unset($respOption);
                    $valFotos[$poll->id] = array('publicities' => $publicityStores,'products'=> $productosCampaigne,'ObjArrayClase' => $arrayClase,'media'=>$photos,'urlFoto' => $this->urlBase.$this->urlImagesFotos,'responses' => $datos);unset($datosFoto);unset($arrayClase);
                }
                /*if (($customer->id== 4) and ($company_id<>37)){
                    $valFotos[$poll->id] = array('arrayFoto'=>$datosFoto,'poll_detail' => $objPollDetails);unset($datosFoto);
                }*/
            }//dd($valFotos[879]['responses']['poll_details'][0]['poll_detail']->auditor);
            //dd($valFotos[576]['responses']['poll_details'][2]);
            //dd($valFotos[614]);
            //dd($customer);
            //dd($objRoadDetail);
            if (($customer->id== 5) or ($customer->id== 1) or ($customer->id== 4) or ($customer->id== 9) or ($customer->id== 10)){
                if ($campaigne->auditoria==1){
                    $view = 'ResponsesPolls';
                }else{
                    $view = 'ResponsesPollsPromot';
                }

            }
            /*if (($customer->id== 4) and ($company_id<>37)){
                $view = 'detalleMediaEncuestaIBK';
            }*/
            return View::make('medias/'.$view, compact('cliente','company_id','valFotos','Polls','objRoadDetail','objStore','campaigne','customer','menus','titulo','logo','detailAudit'));
        }
        if ($tipo==1){
            $titulo = 'Publicidades';
            $objPublicity = $this->publicityRepo->find($objeto_id);//dd($objPublicity);
            $categoryProduct_id = $objPublicity->category_product_id;
            $objPublicity = $this->publicityRepo->getPublicityForCatMat($categoryProduct_id,$company_id);
            foreach ($objPublicity as $publicity)
            {
                $photos = $this->MediaRepo->photosProductPollStore("0", $store_id,$company_id,"0",$publicity->id);//dd($photos);
                if(! empty($photos)){

                    foreach ($photos as $photo){
                        $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlImagesFotos.$photo->archivo);
                    }
                }else{
                    $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                }
                $objPublicityDetails = $this->publicitiesDetailRepo->getRegForStoreCompanyPubli($store_id,$company_id,$publicity->id);//dd($objPublicityDetails[0]);

                $valoresPolls= $this->getValores();
                $storeOpen =$valoresPolls[$company_id]['abierto'];
                $storeAbierto = $this->getResponsePolls($store_id,$company_id,0,$storeOpen,'YesNo');

                $storePermitio = $valoresPolls[$company_id]['permitio'];
                $permitio = $this->getResponsePolls($store_id,$company_id,0,$storePermitio,'YesNo');
                if ($audit_id==1){
                    $storeExiste = $valoresPolls[$company_id]['existeVent'];
                    $existeVent = $this->getResponsePolls($store_id,$company_id,$publicity->id,$storeExiste,'YesNo');

                    $storeVisible = $valoresPolls[$company_id]['visibleVent'];
                    $visibleVent = $this->getResponsePolls($store_id,$company_id,$publicity->id,$storeVisible,'YesNo');

                    $storeW = $valoresPolls[$company_id]['ventanaW'];
                    $ventW = $this->getResponsePolls($store_id,$company_id,$publicity->id,$storeW,'YesNo');

                    $poll_comoEstaVent = $valoresPolls[$company_id]['comoEstaVent'];
                    $comoEstaVent = $this->getResponsePolls($store_id,$company_id,$publicity->id,$poll_comoEstaVent,'Option');

                    $resultFiltro = array('abierto' => $storeAbierto,'permitio' => $permitio,'existe' => $existeVent,'visible' => $visibleVent,'trabajada' => $ventW,'comoEstaVent'=>$comoEstaVent);
                }
                if ($audit_id==3){
                    $storeEncExhi = $valoresPolls[$company_id]['encontroExhi'];
                    if ($storeEncExhi<>0){
                        $existeExhi = $this->getResponsePolls($store_id,$company_id,$publicity->id,$storeEncExhi,'YesNo');
                    }else{
                        $existeExhi = array('texto' => "No hay ingreso",'objeto' => 0);
                    }
                    //dd($objPublicityDetails);
                    $resultFiltro = array('abierto' => $storeAbierto,'permitio' => $permitio,'existe' => $existeExhi);
                }

                //unset($storeAbierto);unset($permitio);unset($existeVent);unset($visibleVent);unset($ventW);unset($comoEstaVent);
                //dd($resultFiltro);
                $valFotos[$publicity->id] = array('arrayFoto'=>$datosFoto,'publicity_detail' => $objPublicityDetails,'pollsResult' => $resultFiltro);unset($objPublicityDetails);unset($datosFoto);unset($resultFiltro);

            }//$this->valoresCampaigne[22] = array('ventanaW' => 255,'abierto' => 252,'permitio' =>254,'existeVent' => 256, 'visibleVent' =>257, 'comoEstaVent'=>258);
            //dd($valFotos);
            return View::make('medias/detalleMedia', compact('valFotos','objPublicity','objRoadDetail','objStore','campaigne','customer','menus','titulo','logo','detailAudit'));
        }


    }
    
    public function getDetailsPhotosForQuestions($company_id)
    {
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);//dd($campaigne);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $menus = $this->generateMenusAudits(0,$company_id,2);
        $titulo="";


        $cantidadStoresForCampaigne = $this->companyStoreRepo->getStoresForCampaigne($company_id,"1","0","0","0","0","0","0","0","0","0");
        $cantidadStoresRouting = $this->companyStoreRepo->getStoresRoadsRouting($company_id);
        $cantidadStoresAudit = $this->companyStoreRepo->getStoresAuditRoadsRouting($company_id);

        $datosStores = [];$city=0;
        $ListStores = $this->storeRepo->getCityForCampaigne($company_id,1);
        $ciudades= array(0 => "Seleccionar") + $ListStores->lists('ubigeo','ubigeo');

        $ListPolls = $this->pollRepo->getQuestionsWithPhotos($company_id);
        $preguntas= array(0 => "Seleccionar") + $ListPolls->lists('question','id');//dd($preguntas);

        return View::make('medias/detailsPhotosForQuestions', compact('datosStores','campaigne','customer','menus','titulo','logo','cantidadStoresForCampaigne','cantidadStoresRouting','cantidadStoresAudit','ciudades','city','preguntas'));
    }

    public function ajaxGetPdvsForPollWithPhotos()
    {
        $valoresPost= Input::all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $publicity_id = $valoresPost['publicity_id'];
        $poll_id = $valoresPost['poll_id'];
        $product_id = $valoresPost['product_id'];
        $poll_option_id = $valoresPost['poll_option_id'];
        $ciudad = $valoresPost['city'];
        $valores = $ciudad.'-0-0-0-0';//dd($valores);
        $values = explode('-',$valores);
        $datosStores = $this->getStoresDetailSiNo($poll_id,$poll_option_id,$this->urlBase,$this->urlImagesFotos,$values,$product_id,$company_id,$publicity_id,1);//dd($datosStores);

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json($datosStores);

    }
} 
<?php
use Carbon\Carbon;
use Auditor\Repositories\PublicityCampaigneRepo;
use Auditor\Repositories\ProductDetailRepo;
use Auditor\Repositories\ProductStoreRegionRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\VisitRepo;
use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\StockProductPopRepo;
use Auditor\Repositories\PublicityStoreRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\PublicityRepo;

class MercantilistaBayerController extends BaseController{
    protected $publicityCampaigneRepo;
    protected $productDetailRepo;
    protected $productStoreRegionRepo;
    protected $roadDetailRepo;
    protected $visitRepo;
    protected $categoryProductRepo;
    protected $stockProductPopRepo;
    protected $publicityStoreRepo;
    protected $pollDetailRepo;
    protected $pollRepo;
    protected $userRepo;
    protected $companyRepo;
    protected $customerRepo;
    protected $storeRepo;
    protected $pollOptionRepo;
    protected $pollOptionDetailRepo;
    protected $mediaRepo;
    protected $publicityRepo;

    public $urlBase;
    public $urlImagesFotos;
    public $urlImageBase;

    public function __construct(PublicityRepo $publicityRepo,MediaRepo $mediaRepo,PollOptionDetailRepo $pollOptionDetailRepo,PollOptionRepo $pollOptionRepo,StoreRepo $storeRepo,CustomerRepo $customerRepo,CompanyRepo $companyRepo,UserRepo $userRepo,PollRepo $pollRepo,PollDetailRepo $pollDetailRepo,PublicityStoreRepo $publicityStoreRepo,StockProductPopRepo $stockProductPopRepo,CategoryProductRepo $categoryProductRepo,VisitRepo $visitRepo,RoadDetailRepo $roadDetailRepo,PublicityCampaigneRepo $publicityCampaigneRepo, ProductDetailRepo $productDetailRepo,ProductStoreRegionRepo $productStoreRegionRepo)
    {
        $this->publicityCampaigneRepo=$publicityCampaigneRepo;
        $this->productDetailRepo =$productDetailRepo;
        $this->productStoreRegionRepo = $productStoreRegionRepo;
        $this->roadDetailRepo = $roadDetailRepo;
        $this->visitRepo = $visitRepo;
        $this->categoryProductRepo = $categoryProductRepo;
        $this->stockProductPopRepo = $stockProductPopRepo;
        $this->publicityStoreRepo = $publicityStoreRepo;
        $this->pollDetailRepo = $pollDetailRepo;
        $this->pollRepo = $pollRepo;
        $this->userRepo = $userRepo;
        $this->companyRepo = $companyRepo;
        $this->customerRepo = $customerRepo;
        $this->storeRepo = $storeRepo;
        $this->pollOptionRepo = $pollOptionRepo;
        $this->pollOptionDetailRepo = $pollOptionDetailRepo;
        $this->mediaRepo = $mediaRepo;
        $this->publicityRepo = $publicityRepo;

        $this->urlBase = \App::make('url')->to('/');
        $this->urlImagesFotos = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
    }

    public function getPublicitiesCampaigne($company_id="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax = $valoresPost['ajax'];
        }
        $publicitiesCampaigne =$this->publicityCampaigneRepo->getPublicityForCampaigne($company_id);//dd($publicitiesCampaigne);
        if ($ajax=="0"){
            $titulo="";$logo='logoBayer.jpg';
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));
        }
        if ($ajax=="1"){
            if (count($publicitiesCampaigne)>0){
                foreach ($publicitiesCampaigne as $publicity) {
                    $valores[] = array('id' =>$publicity->publicity_id,'company_id' => $publicity->publicity->company_id,'fullname' => $publicity->publicity->fullname,'category_product_id' => $publicity->publicity->category_product_id,'description' => $publicity->publicity->description,'imagen' => $publicity->publicity->imagen,'created_at' => '','updated_at' => '');
                }
                $success=1;
            }else{
                $valores=[];$success=0;
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return Response::json([ 'success'=> $success,'publicities' => $valores]);
        }

    }

    public function getProductsForCompetition($company_id="0",$competition="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax = 1;
            $competition = $valoresPost['competition'];
        }
        $success=0;
        $products = $this->productDetailRepo->getProductsCompetitionForCampaigne($company_id,$competition);//dd($products[0]);
        if ($ajax=="0"){
            $titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));
        }
        if ($ajax=="1"){
            if (count($products)>0){
                foreach ($products as $product) {
                    $valores[] = array('id' =>$product->id,'fullname' => $product->product->fullname,'company_id' => $product->product->company_id,'category_product_id' => $product->product->category_product_id,'precio' => $product->product->precio,'imagen' => $product->product->imagen,'composicion' => $product->product->composicion,'fabricante' => $product->product->fabricante,'presentacion' => $product->product->presentacion,'unidad' => $product->product->unidad,'created_at' => '','updated_at' => '');
                    $success=1;
                }
            }else{
                $valores = [];$success=0;
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'products' => $valores]);
        }
    }

    public function getProductsForCampaigneForTypeStore($company_id="0",$type="")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax = $valoresPost['ajax'];
            $type = $valoresPost['type'];
        }
        $products = $this->productStoreRegionRepo->getProductsForCampaigneForTypeStore($company_id,$type);
        if ($ajax=="0"){
            /*$titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));*/
        }
        if ($ajax=="1"){
            if (count($products)>0){
                foreach ($products as $product) {
                    $valores[] = array('id' =>$product->product->id,'fullname' => $product->product->fullname,'company_id' => $product->product->company_id,'category_product_id' => $product->product->category_product_id,'precio' => $product->product->precio,'imagen' => $product->product->imagen,'composicion' => $product->product->composicion,'fabricante' => $product->product->fabricante,'presentacion' => $product->product->presentacion,'unidad' => $product->product->unidad,'type' => $product->type,'created_at' => '','updated_at' => '');
                    $success=1;
                }
            }else{
                $valores = [];$success=0;
            }

            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'products' => $valores]);
        }
    }
    
    public function getRoadsDetail()
    {
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $user_id = $valoresPost['user_id'];
        $valores = $this->roadDetailRepo->roadsDetail($company_id,$user_id);
        if (count($valores)>0){
            $success =1;
        }else{
            $success =0;
        }
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return  Response::json([ 'success'=> $success,'roadsDetail' => $valores]);
    }
    
    public function getVisits(){
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $valores = $this->visitRepo->getAll($company_id);
        if (count($valores)>0){
            $success=1;
        }else{
            $success=0;
        }
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return  Response::json([ 'success'=> $success,'roadsDetail' => $valores]);
    }

    public function getCategoryProduct(){
        $valoresPost= Input::all();
        $company_id = $valoresPost['company_id'];
        $valores = $this->categoryProductRepo->getCategoryProductForCompany($company_id);
        if (count($valores)>0){
            $success=1;
        }else{
            $success=0;
        }
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return  Response::json([ 'success'=> $success,'categoryProducts' => $valores]);
    }

    public function getStockForPublicity($company_id="0",$cliente="0",$publicity_id="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $cliente = $valoresPost['cliente'];
            $publicity_id = $valoresPost['publicity_id'];
            $company_id = $valoresPost['company_id'];
            $ajax=1;
        }
        $valores = $this->stockProductPopRepo->getStockForPublicity($cliente,$publicity_id,$company_id);
        if ($ajax=="0"){
            /*$titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));*/
        }
        if ($ajax=="1"){
            if (count($valores)>0){
                $success=1;
            }else{
                $success=0;
            }
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'stock_product_pop' => $valores]);
        }

    }

    public function getHistoryPublicityForStore($company_id="0",$store_id="0",$poll_id="0",$visit_id="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax = 1;
            $store_id = $valoresPost['store_id'];
            $poll_id = $valoresPost['poll_id'];
            $visit_id = $valoresPost['visit_id'];
        }
        $objVisit = $this->visitRepo->find($visit_id);
        $order = $objVisit->order;
        if ($visit_id==1){
            $visit_id=0;
        }else{
            $order = $order -1;
            $objVisitSearch = $this->visitRepo->getVisitIdForOrder($order);
            $visit_id = $objVisitSearch->id;
        }
        $publicity_stores = $this->publicityStoreRepo->getHistoryPublicityStore($company_id,$store_id,$visit_id);
        if ($ajax=="0"){
            /*$titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));*/
        }
        if ($ajax=="1"){
            if (count($publicity_stores)>0){
                foreach ($publicity_stores as $publicity_store) {
                    $photos = $this->mediaRepo->photosProductPollStore($poll_id, $store_id,$company_id,"0",$publicity_store->publicity_id,$visit_id);
                    if(! empty($photos)){

                        foreach ($photos as $photo){
                            $foto = $this->urlBase.$this->urlImagesFotos.$photo->archivo;
                        }
                    }else{
                        $foto = '';
                    }
                    $valores[] = array('id' =>$publicity_store->id,'publicity_id' => $publicity_store->publicity_id,'publicity' => $publicity_store->publicity->fullname,'company_id' => $publicity_store->company_id,'company_name' => $publicity_store->company->fullname,'store_id' => $publicity_store->store_id,'store' => $publicity_store->store->fullname,'created_at' => $publicity_store->created_at->toDateTimeString(),'updated_at' => $publicity_store->updated_at->toDateTimeString(),'foto' => $foto);
                    $success=1;
                }
            }else{
                $valores = [];$success=0;
            }
            
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'publicity' => $valores]);
        }
    }

    public function getStockForPublicityAll($company_id="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax=1;
        }
        $valores = $this->stockProductPopRepo->getStockForPublicityAll($company_id);
        if ($ajax=="0"){
            /*$titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));*/
        }
        if ($ajax=="1"){
            if (count($valores)>0){
                $success=1;
            }else{
                $success=0;
            }
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'stock_product_pop' => $valores]);
        }

    }

    public function saveRegistersBayerMercaderismo()
    {
        $objPollDetail = $this->pollDetailRepo->getModel();
        //$objPollDetail->poll_id = 34;
        $valoresPost= Input::all();//dd($valoresPost);
        $poll_id = $valoresPost['poll_id'];
        $store_id= $valoresPost['store_id'];
        $sino= $valoresPost['sino'];
        $options= $valoresPost['options'];
        $limits= $valoresPost['limits'];
        $media= $valoresPost['media'];
        $coment= $valoresPost['coment'];
        $result= $valoresPost['result'];
        $limite= $valoresPost['limite'];
        $comentario= $valoresPost['comentario'];
        $auditor= $valoresPost['auditor'];
        $product_id= $valoresPost['product_id'];
        $publicity_id= $valoresPost['publicity_id'];
        $company_id = $valoresPost['company_id'];
        $category_product_id = $valoresPost['category_product_id'];
        $selectedOptions = $valoresPost['selectedOptions'];
        $selectedOptionsComment = $valoresPost['selectedOptionsComment'];
        $priority = $valoresPost['priority'];
        $stock_product_pop_id =$valoresPost['stock_product_pop_id'];
        $visit_id = $valoresPost['visit_id'];
        $mytime = Carbon::now();
        $horaSistema = $mytime->toDateTimeString();

        $objPollDetail->poll_id = $poll_id;//dd($objPollDetail->poll_id);
        $objPollDetail->store_id = $store_id;
        $objPollDetail->product_id = $product_id;
        $objPollDetail->publicity_id = $publicity_id;
        $objPollDetail->company_id = $company_id;
        $objPollDetail->category_product_id = $category_product_id;
        $objPollDetail->stock_product_pop_id = $stock_product_pop_id;
        $objPollDetail->visit_id = $visit_id;
        $valor = $this->pollDetailRepo->searchPollDetail($objPollDetail,"2");//dd(count($valor));
        $objPoll=$this->pollRepo->find($poll_id);
        $objAuditor = $this->userRepo->find($auditor);
        $datoAuditor = $objAuditor->fullname."(".$auditor.")";
        $campaigneDetail = $this->companyRepo->find($company_id);//dd($campaigneDetail);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);
        $cliente = $customer->corto;
        $textoContent = $campaigneDetail->fullname."".$objPoll->question." - Id= ".$store_id;
        $objStore = $this->storeRepo->find($store_id);
        $tipo_bodega = $objStore->tipo_bodega;
        $agente = $objStore->fullname;
        $dir = $objStore->codclient;
        $address = $objStore->address;
        $fono = $objStore->telephone."/".$objStore->cell;
        $district = $objStore->district." - ".$objStore->region." - ".$objStore->ubigeo;
        $foto = "";$nomPublicity="";

        $fechaHoraEnvio = $horaSistema;

        $textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - CANAL: ".$objStore->cadenaRuc." StoreId: ".$store_id;

        if (count($valor)==0){
            $objPollDetail->sino = $sino;
            $objPollDetail->options = $options;
            $objPollDetail->limits = $limits;
            $objPollDetail->media = $media;
            $objPollDetail->coment = $coment;
            $objPollDetail->result = $result;
            $objPollDetail->limite = $limite;
            $objPollDetail->comentario = $comentario;
            $objPollDetail->auditor = $auditor;
            $objPollDetail->save();
            $idPollDetail = $objPollDetail->id;

            if ($objPollDetail->publicity_id<>0){
                $objPublicity = $this->publicityRepo->find($objPollDetail->publicity_id);
                $nomPublicity = $objPublicity->fullname;
            }

            //send emails
            if ($result == 0){
                $motivo = $objPoll->question."(Id: ".$objPoll->id.")".' Rsp. NO('.$idPollDetail.')';
            }else{
                $motivo = $objPoll->question."(Id: ".$objPoll->id.")".' Rsp SI('.$idPollDetail.')';
            }
            if ($nomPublicity<>""){
                $motivo .=" POP: ".$nomPublicity;
            }
            $questions = $this->getQuestionsSendEmail();
            foreach ($questions as $question)
            {
                if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['send']==1))
                {
                    if ($result == $question['result'])
                    {
                        $gruposEmails = $this->getGroupsEmails();
                        $mascaras = explode('|',$question['mask']);
                        for($i=0;$i<count($mascaras);$i++) {
                            $emails = $gruposEmails[$mascaras[$i]];//dd($emails);
                            $this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
                        }
                        //sendEmails($store_id,$textoContent,$motivo,$auditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails)
                    }

                }
            }
            if ($objPollDetail->stock_product_pop_id<>0){
                $publicity_cabecera=564;
                $objStockProductPopAll = $this->stockProductPopRepo->getStockForPublicity($objStore->cadenaRuc,$publicity_cabecera,$company_id);
                $cant_prod_stock_min=count($objStockProductPopAll);
                $responseStock = $this->pollDetailRepo->searchPollDetail($objPollDetail,"3");
                if ($cant_prod_stock_min == count($responseStock)){
                    $c=0;
                    foreach ($responseStock as $response) {
                        foreach ($objStockProductPopAll as $stockProductPop){
                            if ($response->stock_product_pop_id==$stockProductPop->id){
                                if ($response->comentario<=$stockProductPop->minimo){
                                    $c=$c+1;
                                    if ($c==1){
                                        $motivo = $objPoll->question.'(Id: '.$objPoll->id.') Productos encontrados NO cumplen Stock Mínimo:<br>';
                                    }
                                    $motivo .='Producto: '.$stockProductPop->fullname.'('.$stockProductPop->unidad.')'.' Stock Encontrado:'.$response->comentario.' Stock Mínimo: '.$stockProductPop->minimo.' Stock Optimo: '.$stockProductPop->optimo.'<br>';
                                }
                            }
                        }
                    }
                    foreach ($questions as $question)
                    {
                        if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id))
                        {
                            $gruposEmails = $this->getGroupsEmails();
                            $mascaras = explode('|',$question['mask']);
                            for($i=0;$i<count($mascaras);$i++) {
                                $emails = $gruposEmails[$mascaras[$i]];//dd($emails);
                                $this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
                            }

                        }
                    }
                }
            }
            //end send emails
        }else{
            $valor->sino = $sino;
            $valor->options = $options;
            $valor->limits = $limits;
            $valor->media = $media;
            $valor->coment = $coment;
            $valor->result = $result;
            $valor->limite = $limite;
            $valor->comentario = $comentario;
            $valor->auditor = $auditor;
            $valor->update();
            $idPollDetail = $valor->id;
        }
        $objPollDetailSearch = $this->pollDetailRepo->getModel();
        $ObjSearchPollDetail = $objPollDetailSearch::find($idPollDetail);//dd($selectedOptions);
        if ($ObjSearchPollDetail->options==1)
        {
            $opciones = explode('|',$selectedOptions);$c=0;
            $comentOpcion = explode('|',$selectedOptionsComment);//dd($opciones);
            if ($opciones[0]<>'')
            {
                foreach ($opciones as $valor) {
                    if ($valor<>''){
                        $consulta1 = $this->pollOptionRepo->getOptionsForPollCodigo($ObjSearchPollDetail->poll_id,$valor);//dd($consulta1[0]);
                        if (count($consulta1)>0){
                            $objPollOptionDetail = $this->pollOptionDetailRepo->getModel();
                            $objPollOptionDetail->poll_option_id=$consulta1[0]->id;
                            $objPollOptionDetail->store_id=$store_id;
                            $objPollOptionDetail->product_id=$product_id;
                            $objPollOptionDetail->company_id=$company_id;
                            $objPollOptionDetail->publicity_id=$publicity_id;
                            $objPollOptionDetail->visit_id = $visit_id;
                            $valorOption = $this->pollOptionDetailRepo->searchPollOptionDetail($objPollOptionDetail,"1");
                            if (count($valorOption)==0){
                                $objPollOptionDetail->result=1;
                                if (count($comentOpcion)>1){
                                    $objPollOptionDetail->otro=$comentOpcion[$c];
                                }else{
                                    $objPollOptionDetail->otro=$comentOpcion[0];
                                }

                                $objPollOptionDetail->auditor=$auditor;
                                $objPollOptionDetail->priority=$priority;
                                $objPollOptionDetail->save();
                                $idPollOptionDetail = $objPollOptionDetail->id;
                                //send emails
                                $motivo = $objPoll->question." (Id question: ".$objPoll->id.")"." (IdResp.: ".$idPollDetail.") opcion: ".$consulta1[0]->options.' ('.$idPollOptionDetail.')';
                                $questions = $this->getQuestionsSendEmail();
                                foreach ($questions as $question)
                                {
                                    if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['poll_option_id']==$consulta1[0]->id))
                                    {
                                        $gruposEmails = $this->getGroupsEmails();
                                        $mascaras = explode('|',$question['mask']);
                                        for($i=0;$i<count($mascaras);$i++) {
                                            $emails = $gruposEmails[$mascaras[$i]];//dd($emails);
                                            $this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails,$fono);
                                        }
                                    }
                                }
                                //end send emails
                            }else{
                                $valorOption->result=1;
                                $valorOption->otro=$comentOpcion[$c];
                                $valorOption->auditor=$auditor;
                                $valorOption->priority=$priority;
                                $valorOption->update();
                                $idPollOptionDetail = $valorOption->id;
                            }
                        }
                        $c=$c+1;
                    }
                }
            }else{
                $idPollOptionDetail=0;
            }

        }
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        return Response::json([ 'success'=> 1, 'last_poll_detail_id' => $idPollDetail]);
    }

    public function pruebasClass(){
        $objStore=$this->storeRepo->find(81349);$company_id=79;
        $objPoll = $this->pollRepo->find(1443);
        $objPollDetail = $this->pollDetailRepo->find(948291);
        if ($objPollDetail->stock_product_pop_id<>0){
            $objStockProductPopAll = $this->stockProductPopRepo->getStockForPublicity($objStore->cadenaRuc,564,$company_id);
            $cant_prod_stock_min=count($objStockProductPopAll);
            $responseStock = $this->pollDetailRepo->searchPollDetail($objPollDetail,"3");
            if ($cant_prod_stock_min == count($responseStock)){
                $c=0;
                foreach ($responseStock as $response) {
                    foreach ($objStockProductPopAll as $stockProductPop){
                        if ($response->stock_product_pop_id==$stockProductPop->id){
                            if ($response->comentario<=$stockProductPop->minimo){
                                $c=$c+1;
                                if ($c==1){
                                    $motivo = $objPoll->question.'(Id: '.$objPoll->id.') Productos encontrados NO cumplen Stock Mínimo:<br>';
                                }
                                $motivo .='Producto: '.$stockProductPop->fullname.'('.$stockProductPop->unidad.')'.' Stock Encontrado:'.$response->comentario.' Stock Mínimo: '.$stockProductPop->minimo.' Stock Optimo: '.$stockProductPop->optimo.'<br>';
                            }
                        }
                    }
                }dd($motivo);
                /*foreach ($questions as $question)
                {
                    if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id))
                    {
                        $gruposEmails = $this->getGroupsEmails();
                        $mascaras = explode('|',$question['mask']);
                        for($i=0;$i<count($mascaras);$i++) {
                            $emails = $gruposEmails[$mascaras[$i]];//dd($emails);
                            $this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
                        }

                    }
                }*/
            }
        }
    }

    public function insertImagesMercaderista() {
        if(Input::hasFile('fotoUp')) {
            $archivo=Input::file('fotoUp');
            $archivo->move('media/fotos/',$archivo->getClientOriginalName());
        }
        $product_id = Input::only('product_id');
        $poll_id = Input::only('poll_id');
        $store_id = Input::only('store_id');
        $publicities_id = Input::only('publicities_id');
        $tipo = Input::only('tipo');
        $archivo = Input::only('archivo');
        $company_id = Input::only('company_id');
        $monto = Input::only('monto');
        $razon_social = Input::only('razon_social');
        $category_product_id = Input::only('category_product_id');
        $visit_id = Input::only('visit_id');
        $mytime = Carbon::now();
        $horaSistemaUpdate = $mytime->toDateTimeString();
        $horaSistema = Input::only('created_at');

        DB::insert("INSERT INTO medias (store_id,poll_id,publicities_id,product_id, tipo,archivo,company_id,category_product_id,monto,razon_social,visit_id, created_at,updated_at) 
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)" ,
            array(
                $store_id['store_id'],
                $poll_id['poll_id'],
                $publicities_id['publicities_id'],
                $product_id['product_id'],
                $tipo['tipo'],
                $archivo['archivo'],
                $company_id['company_id'],
                $category_product_id['category_product_id'],
                $monto['monto'],
                $razon_social['razon_social'],
                $visit_id['visit_id'],
                $horaSistema['created_at'],
                $horaSistemaUpdate
            )
        );

        return \Response::json([ 'success'=> 1]);
    }

    public function insertHistoryPublicityStore($company_id="0",$publicity_id="0",$store_id="0",$visit_id="0",$ajax="0"){
        $idPublicityStore=0;
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $company_id = $valoresPost['company_id'];
            $ajax = 1;
            $store_id = $valoresPost['store_id'];
            $publicity_id = $valoresPost['publicity_id'];
            $visit_id = $valoresPost['visit_id'];
        }
        $objPublicityStore = $this->publicityStoreRepo->getModel();
        $objPublicityStore->publicity_id=$publicity_id;
        $objPublicityStore->company_id=$company_id;
        $objPublicityStore->visit_id=$visit_id;
        $objPublicityStore->store_id=$store_id;
        $valor = $this->publicityStoreRepo->searchPublicityStore($objPublicityStore);
        if (count($valor)==0){
            $objPublicityStore->save();
            $idPublicityStore = $objPublicityStore->id;
        }else{
            $valor->update();
            $idPublicityStore = $valor->id;
        }

        if ($ajax==1){
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            if ($idPublicityStore<>0){
                return Response::json([ 'success'=> 1, 'last_publicity_store_id' => $idPublicityStore]);
            }else{
                return Response::json([ 'success'=> 0, 'last_publicity_store_id' => $idPublicityStore]);
            }
        }else{

        }
    }

    public function productsForRegion($company_id="0",$competencia="0",$ajax="0")
    {
        if ($company_id=="0"){
            $valoresPost= Input::all();
            $competencia = $valoresPost['competencia'];
            $company_id = $valoresPost['company_id'];
            $ajax=1;
        }
        $valores = $this->productDetailRepo->getAllProductForCity($company_id,$competencia);
        if ($ajax=="0"){
            /*$titulo="";$logo='logoBayer.jpg';$publicitiesCampaigne=$products;
            return View::make('report/bayer/mercaderismo',compact('publicitiesCampaigne','titulo','logo'));*/
        }
        if ($ajax=="1"){
            if (count($valores)>0){
                $success=1;
            }else{
                $success=0;
            }
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> $success,'stock_product_pop' => $valores]);
        }

    }

} 
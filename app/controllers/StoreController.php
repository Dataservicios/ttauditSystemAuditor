<?php

use Auditor\Repositories\StoreRepo;
use Auditor\Managers\StoreManager;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CustomerRepo;

class StoreController extends BaseController{

    protected $storeRepo;
    protected $companyStoreRepo;
    protected $campaigneRepo;
    protected $customerRepo;

    public function __construct(CustomerRepo $customerRepo,CompanyRepo $campaigneRepo,CompanyStoreRepo $companyStoreRepo,StoreRepo $storeRepo)
    {
        $this->storeRepo = $storeRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->campaigneRepo = $campaigneRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        //$objStore= $this->storeRepo->getModel();
        $valoresPost= Input::all();//dd($valoresPost);
        $address= $valoresPost['address'];
        $store_id= $valoresPost['store_id'];
        $telephone= $valoresPost['telephone'];
        $cell= $valoresPost['cell'];
        $urbanization= $valoresPost['urbanization'];
        $objStore = $this->storeRepo->find($store_id);//dd($objStore);
        if ($address<>''){
            $objStore->address=$address;
        }
        if ($telephone<>''){
            $objStore->telephone = $telephone;
        }
        if ($cell<>''){
            $objStore->cell = $cell;
        }
        if ($urbanization<>''){
            $objStore->urbanization = $urbanization;
        }

        $objStore->update();
        return Response::json([ 'success'=> 1]);
    }

    public function duplicateStore()
    {
        $valoresPost= Input::all();
        $store_id= $valoresPost['store_id'];
        $company_id = $valoresPost['company_id'];
        $objStore = $this->storeRepo->find($store_id);
        $objDuplicateStore = $this->storeRepo->getModel();
        $objDuplicateStore->fullname = $objStore->fullname;
        $objDuplicateStore->address = $objStore->address;
        $objDuplicateStore->district = $objStore->district;
        $objDuplicateStore->region = $objStore->region;
        $objDuplicateStore->ubigeo = $objStore->ubigeo;
        $objDuplicateStore->distributor = $objStore->distributor;
        $objDuplicateStore->latitude = $objStore->latitude;
        $objDuplicateStore->longitude = $objStore->longitude;
        $objDuplicateStore->ruteado = 1;
        $objDuplicateStore->telephone = $objStore->telephone;
        if ($objDuplicateStore->save())
        {
            $objCompanyStore = $this->companyStoreRepo->getModel();
            $objCompanyStore->company_id=$company_id;
            $objCompanyStore->store_id = $objDuplicateStore->id;
            $objCompanyStore->ruteado=1;
            if ($objCompanyStore->save())
            {
                return Response::json([ 'success'=> 1, 'store_id' => $objDuplicateStore->id,'company_store_id' => $objCompanyStore->id]);
            }else{
                return Response::json([ 'success'=> 0, 'store_id' => $objDuplicateStore->id,'company_store_id' => 0]);
            }
        }else{
            return Response::json([ 'success'=> 0, 'store_id' => 0,'company_store_id' => 0]);
        }

    }

    public function listStores()
    {
        $stores =$this->storeRepo->listStore();
        $userType = Auth::user()->type;
        $opcion='3';
        /*dd($category);*/
        return View::make('store/list',compact('stores','userType','opcion'));

    }

    public function show($id)
    {
        $store = $this->storeRepo->find($id);
        return View::make('store/show',compact('store'));
    }

    public function store($id)
    {
        $store = $this->storeRepo->find($id);
        return View::make('store/store', compact('store'));
    }

    public function updateStore($id)
    {
        $store = $this->storeRepo->find($id);
        //dd(Input::all());
        $manager = new StoreManager($store, Input::all());
        $manager->save();
        return Redirect::route('storeEdit', $id);
    }

    public function newStore()
    {
        $store_types = \Lang::get('utils.store');
        return View::make('store/new',compact('store_types'));
    }

    public function importStore()
    {
        return View::make('store/import');
    }

    public function newRoute()
    {
        return View::make('store/routes');
    }

    public function registerStore()
    {
        $store = $this->storeRepo->newStore();
        //dd($store);
        $file = Input::file("photo");
        $store->photo = $file->getClientOriginalName();
        $manager = new StoreManager($store, Input::only(['fullname','type','owner','address','urbanization','district','region','ubigeo','distributor','latitude','longitude']));

        $manager->save();
        $file->move("img/stores",$file->getClientOriginalName());
        //dd($store);
        return Redirect::route('storeDetail', [$store->id]);

    }

    public function insertPollStore()
    {
        $valoresPost= Input::all(); //dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $fullname = $valoresPost['fullname'];
        $distributor1 = $valoresPost['code'];
        $telephone = $valoresPost['phone'];
        $district = $valoresPost['distrito'];
        $ubigeo = $valoresPost['departamento'];
        $address = $valoresPost['address'];
        $ejecutivo = $valoresPost['ejecutivo'];

        if ($distributor1=="Alicorp"){
            $codclient = $valoresPost['codclient'];
            $giro = $valoresPost['giro'];
            $distributor = $valoresPost['dex'];
        }else{
            $distributor = $valoresPost['code'];
        }
        $objStore = $this->storeRepo->getModel();
        $objStore->fullname = $fullname;
        $objStore->distributor = $distributor;
        $objStore->telephone = $telephone;
        $objStore->district = $district;
        $objStore->latitude = 0;
        $objStore->longitude = 0;
        $objStore->ruteado = 1;
        $objStore->region = $ubigeo;
        $objStore->ubigeo = $ubigeo;
        $objStore->address = $address;
        $objStore->ejecutivo = $ejecutivo;
        if ($distributor1=="Alicorp"){
            $objStore->codclient = $codclient;
            $objStore->rubro = $giro;
        }
        if ($objStore->save()){
            $companyStore = $this->companyStoreRepo->getModel();
            $companyStore->company_id=$company_id;
            $companyStore->store_id = $objStore->id;
            $companyStore->ruteado=1;
            $companyStore->save();
            return Response::json([ 'success'=> 1, 'store_id' => $objStore->id]);
        }else{
            return Response::json([ 'success'=> 0, 'store_id' => 0]);
        }


    }

    public function updateContact()
    {
        $valoresPost= Input::all();
        $store_id = $valoresPost['store_id'];
        $contact_new= $valoresPost['contact_new'];
        $telephone_new= $valoresPost['telephone_new'];
        $telephone = $valoresPost['telephone'];
        $contact= $valoresPost['contact'];
        $fnac= $valoresPost['fnac'];
        $objStoreRepo = $this->storeRepo->find($store_id);
        header('Access-Control-Allow-Origin: *');
        $contact1 = "Contacto: ".$objStoreRepo->owner." Fono: ".$objStoreRepo->telephone;
        $objStoreRepo->owner = $contact_new;
        $objStoreRepo->telephone = $telephone_new;
        $objStoreRepo->contact1 = $contact1;
        if ($fnac<>''){
            $objStoreRepo->fnac = $fnac;
        }
        if ($objStoreRepo->save())
        {
            return Response::json([ 'success'=> 1]);
        }else{
            return Response::json([ 'success'=> 0]);
        }
    }

    public function updateAddress()
    {
        $valoresPost= Input::all();
        $store_id = $valoresPost['store_id'];
        $user_id = $valoresPost['user_id'];
        $company_id = $valoresPost['company_id'];
        $direccion  = $valoresPost['direccion'];
        $referencia = $valoresPost['referencia'];
        $userName = $valoresPost['userName'];
        $storeName = Input::only('storeName');
        $comentario = Input::only('comentario');
        $objStoreRepo = $this->storeRepo->find($store_id);
        header('Access-Control-Allow-Origin: *');
        $address1 = "Dirección: ".$objStoreRepo->address." Referencia: ".$objStoreRepo->urbanization;
        $objStoreRepo->address = $direccion;
        $objStoreRepo->urbanization = $referencia;
        $objStoreRepo->address1 = $address1;
        $campaigneDetail = $this->campaigneRepo->find($company_id);//dd($campaigneDetail);
        $customer =$this->customerRepo->find($campaigneDetail->customer_id);
        $cliente = $customer->corto;

        if ($objStoreRepo->save())
        {
            $questions = $this->getQuestionsSendEmail();
            $textoContent = 'Se actualizo Dirección Tienda '.$objStoreRepo->fullname;
            $motivo = 'Cambio de Dirección '.$objStoreRepo->fullname.'('.$objStoreRepo->id.')';
            $datoAuditor= $userName."(".$user_id.")";
            $fechaHoraEnvio = $objStoreRepo->updated_at;
            $comment= $campaigneDetail->fullname."("."Cliente: ".$customer->fullname." id campaña: ".$company_id.")"."<br>"."Datos anterior=> ".$address1;
            $tipo_bodega = $objStoreRepo->tipo_bodega;
            $agente = $objStoreRepo->fullname;
            $dir = $objStoreRepo->codclient;
            $address =  $objStoreRepo->address." Referencia: ".$objStoreRepo->urbanization;
            $district = $objStoreRepo->district;
            $foto="";
            foreach ($questions as $question)
            {
                if (($question['company_id']=='change_address') and ($question['send']==1))
                {
                    $gruposEmails = $this->getGroupsEmails();
                    $mascaras = explode('|',$question['mask']);
                    for($i=0;$i<count($mascaras);$i++) {
                        $emails = $gruposEmails[$mascaras[$i]];

                        $this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comment,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
                    }
                }
            }
            return Response::json([ 'success'=> 1]);
        }else{
            return Response::json([ 'success'=> 0]);
        }
    }

    public function searchStore($dir, $type="auditor")
    {
        $valores = explode('|',$dir);
        $dir = $valores[0];
        $company_id = $valores[1];
        $stores = $this->storeRepo->searchStores($dir,$company_id,$type);
        header('Access-Control-Allow-Origin: *');
        return \Response::json($stores);
    }
} 
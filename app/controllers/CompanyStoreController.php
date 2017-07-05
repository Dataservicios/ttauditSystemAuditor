<?php
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\PublicityStoreRepo;

class CompanyStoreController extends BaseController{

    protected $companyStoreRepo;
    protected $publicityStoreRepo;

    public function __construct(PublicityStoreRepo $publicityStoreRepo,CompanyStoreRepo $companyStoreRepo)
    {
        $this->companyStoreRepo = $companyStoreRepo;
        $this->publicityStoreRepo = $publicityStoreRepo;
    }

    public function insertCompanyStore()
    {
        $valoresPost= Input::all(); //dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $ruteado = $valoresPost['ruteado'];
        $store_id = $valoresPost['store_id'];
        $objCompanyStore = $this->companyStoreRepo->getModel();
        $objCompanyStore->company_id=$company_id;
        $objCompanyStore->store_id = $store_id;
        $objCompanyStore->ruteado=$ruteado;
        if ($objCompanyStore->save())
        {
            return Response::json([ 'success'=> 1, 'id' => $objCompanyStore->id]);
        }else{
            return Response::json([ 'success'=> 0, 'id' => 0]);
        }

    }
    
    public function getStoresForRoutingForCity(){
        $valoresPost= Input::all(); //dd($valoresPost);
        $departament = $valoresPost['departament'];
        $objCompanyStores = $this->companyStoreRepo->getStoresForRouting(0,$departament);//dd($objCompanyStores);
        
        if (count($objCompanyStores)>0){
            foreach ($objCompanyStores as $objCompanyStore) {
                if ($objCompanyStore->study_id==2){
                    $publicity_id='564';$visit_id=0;
                    if ($this->publicityStoreRepo->existPublicityInStore($publicity_id,$objCompanyStore->store_id,$objCompanyStore->company_id,$visit_id)){
                        $valores[]=array('id'=>$objCompanyStore->store_id,'cadenaRuc'=>$objCompanyStore->cadenaRuc,'tipo'=>$objCompanyStore->type,'fullname'=>$objCompanyStore->fullname,'address'=>$objCompanyStore->address,'referencia'=>$objCompanyStore->urbanization,'provincia'=>$objCompanyStore->region,'departamento'=>$objCompanyStore->ubigeo,'district'=>$objCompanyStore->district,'codclient'=>$objCompanyStore->codclient,'active'=>$objCompanyStore->active,'company_id'=>$objCompanyStore->company_id,'campaigne'=>$objCompanyStore->campaigne,'latitud'=>$objCompanyStore->latitude,'longitud'=>$objCompanyStore->longitude,'customer'=>$objCompanyStore->customer,'customer_id'=>$objCompanyStore->customer_id,'estudio_id'=>$objCompanyStore->study_id,'estudio'=>$objCompanyStore->estudio,'cabecera'=>1);
                    }else{
                        $valores[]=array('id'=>$objCompanyStore->store_id,'cadenaRuc'=>$objCompanyStore->cadenaRuc,'tipo'=>$objCompanyStore->type,'fullname'=>$objCompanyStore->fullname,'address'=>$objCompanyStore->address,'referencia'=>$objCompanyStore->urbanization,'provincia'=>$objCompanyStore->region,'departamento'=>$objCompanyStore->ubigeo,'district'=>$objCompanyStore->district,'codclient'=>$objCompanyStore->codclient,'active'=>$objCompanyStore->active,'company_id'=>$objCompanyStore->company_id,'campaigne'=>$objCompanyStore->campaigne,'latitud'=>$objCompanyStore->latitude,'longitud'=>$objCompanyStore->longitude,'customer'=>$objCompanyStore->customer,'customer_id'=>$objCompanyStore->customer_id,'estudio_id'=>$objCompanyStore->study_id,'estudio'=>$objCompanyStore->estudio,'cabecera'=>0);
                    }
                }else{
                    $valores[]=array('id'=>$objCompanyStore->store_id,'cadenaRuc'=>$objCompanyStore->cadenaRuc,'tipo'=>$objCompanyStore->type,'fullname'=>$objCompanyStore->fullname,'address'=>$objCompanyStore->address,'referencia'=>$objCompanyStore->urbanization,'provincia'=>$objCompanyStore->region,'departamento'=>$objCompanyStore->ubigeo,'district'=>$objCompanyStore->district,'codclient'=>$objCompanyStore->codclient,'active'=>$objCompanyStore->active,'company_id'=>$objCompanyStore->company_id,'campaigne'=>$objCompanyStore->campaigne,'latitud'=>$objCompanyStore->latitude,'longitud'=>$objCompanyStore->longitude,'customer'=>$objCompanyStore->customer,'customer_id'=>$objCompanyStore->customer_id,'estudio_id'=>$objCompanyStore->study_id,'estudio'=>$objCompanyStore->estudio,'cabecera'=>0);
                }

            }

        }
        header('Access-Control-Allow-Origin: *');
        return Response::json($valores);
        
    }

    public function getStoresForRoutingForCompanyVisit(){
        $valoresPost= Input::all(); //dd($valoresPost);
        $departament = $valoresPost['departament'];
        $company_id = $valoresPost['company_id'];
        $visit_id = $valoresPost['visit_id'];
        if ($visit_id<>"0"){
            $objCompanyStores = $this->companyStoreRepo->getStoresForRoutingForCompanyVisit(0,$departament,$company_id,$visit_id);//dd($objCompanyStores);
        }else{
            $objCompanyStores = $this->companyStoreRepo->getStoresForRouting(0,$departament);
        }

        if (count($objCompanyStores)>0){
            foreach ($objCompanyStores as $objCompanyStore) {
                $publicity_id='564';
                if ($this->publicityStoreRepo->existPublicityInStore($publicity_id,$objCompanyStore->store_id,$objCompanyStore->company_id,$visit_id)){
                    $valores[]=array('id'=>$objCompanyStore->store_id,'cadenaRuc'=>$objCompanyStore->cadenaRuc,'tipo'=>$objCompanyStore->type,'fullname'=>$objCompanyStore->fullname,'address'=>$objCompanyStore->address,'referencia'=>$objCompanyStore->urbanization,'provincia'=>$objCompanyStore->region,'departamento'=>$objCompanyStore->ubigeo,'district'=>$objCompanyStore->district,'codclient'=>$objCompanyStore->codclient,'active'=>$objCompanyStore->active,'company_id'=>$objCompanyStore->company_id,'campaigne'=>$objCompanyStore->campaigne,'latitud'=>$objCompanyStore->latitude,'longitud'=>$objCompanyStore->longitude,'cabecera'=>1);
                }else{
                    $valores[]=array('id'=>$objCompanyStore->store_id,'cadenaRuc'=>$objCompanyStore->cadenaRuc,'tipo'=>$objCompanyStore->type,'fullname'=>$objCompanyStore->fullname,'address'=>$objCompanyStore->address,'referencia'=>$objCompanyStore->urbanization,'provincia'=>$objCompanyStore->region,'departamento'=>$objCompanyStore->ubigeo,'district'=>$objCompanyStore->district,'codclient'=>$objCompanyStore->codclient,'active'=>$objCompanyStore->active,'company_id'=>$objCompanyStore->company_id,'campaigne'=>$objCompanyStore->campaigne,'latitud'=>$objCompanyStore->latitude,'longitud'=>$objCompanyStore->longitude,'cabecera'=>0);
                }

            }

        }
        header('Access-Control-Allow-Origin: *');
        return Response::json($valores);

    }

} 
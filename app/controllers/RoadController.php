<?php

use Auditor\Repositories\RoadRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\VisitStoreRepo;

class RoadController extends BaseController{

    protected $roadRepo;
    protected $roadDetailRepo;
    protected $StoreRepo;
    protected $AuditRoadStoreRepo;
    protected $CompanyRepo;
    protected $UserRepo;
    protected $companyStoreRepo;
    protected $companyAuditRepo;
    protected $visitStoreRepo;

    public function __construct(VisitStoreRepo $visitStoreRepo,CompanyAuditRepo $companyAuditRepo,CompanyStoreRepo $companyStoreRepo,UserRepo $UserRepo,CompanyRepo $CompanyRepo,AuditRoadStoreRepo $AuditRoadStoreRepo,StoreRepo $StoreRepo, RoadDetailRepo $roadDetailRepo,RoadRepo $roadRepo)
    {
        $this->roadRepo = $roadRepo;
        $this->roadDetailRepo = $roadDetailRepo;
        $this->StoreRepo = $StoreRepo;
        $this->AuditRoadStoreRepo = $AuditRoadStoreRepo;
        $this->CompanyRepo = $CompanyRepo;
        $this->UserRepo = $UserRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->companyAuditRepo = $companyAuditRepo;
        $this->visitStoreRepo = $visitStoreRepo;
    }

    public function listRoads($company_id='0',$user_id='0')
    {
        $valoresPost= Input::all();
        //dd($valoresPost);

        /*$campaignesClient = $this->CompanyRepo->getCurrentCampaigns();
        $campaignes = array(0 => "Seleccionar Campaña Vigente") + $campaignesClient->lists('fullname','id');*/
        if (count($valoresPost)>0){
            $page = Input::get('page');
            $company_id = 0;
            $user_id = $valoresPost['user_id'];
            $auditor = $this->UserRepo->find($user_id);
            $nameAuditor = $auditor->fullname;
            $roads =$this->roadRepo->listRoads($company_id,$user_id);
        }else{//dd("ff");
            $roads=[];
            $nameCompany = "0";
            $nameAuditor = "0";
        }

        return View::make('roads/list',compact('nameAuditor','roads'));

    }

    public function show($id)
    {
        $road = $this->roadRepo->find($id);
        $roadDetails = $this->roadDetailRepo->getDetailStores($id);$auditados=0;
        $urlBase = \App::make('url')->to('/');
        /*Session::put('error', '0');
        Session::put('info', '0');*/
        foreach ($roadDetails as  $roadDetail)
        {
            if($roadDetail->audit==1) $auditados ++;
        }
        //dd($roadDetails[0]);
        return View::make('roads/show',compact('road','roadDetails','auditados','urlBase'));
    }

    public function deleteAgentRoute($values)
    {
        $valores = explode('|',$values);
        if (count($valores)==0) return Response::json(['success' => false, 'message' => 'Error en datos']);
        $id = $valores[0];
        $company_id = $valores[1];
        $road_id = $valores[2];
        $this->StoreRepo->updateRouteForStore($id,0);
        $this->companyStoreRepo->updateRouteForStore($id,$company_id,0);
        $this->AuditRoadStoreRepo->deleteForStore($id,$company_id,$road_id);
        $store= $this->StoreRepo->find($id);
        $this->roadDetailRepo->deleteForStore($id,$company_id);
        $message = "Punto con id ". $store->id. " y nombre " . $store->fullname . " fue sacado de la ruta";
        if(Request::ajax()){
            return Response::json(['success' => true, 'message' => $message]);
        }

    }

    public function deleteRoute($id)
    {
        $road = $this->roadRepo->find($id);
        $roadDetails = $this->roadDetailRepo->getDetailStores($id);$c=0;
        if (count($roadDetails)>0){
            foreach ($roadDetails as  $roadDetail)
            {
                $c = $c +1;
                $store_id = $roadDetail->store->id;
                $this->StoreRepo->updateRouteForStore($store_id,0);
                $this->companyStoreRepo->updateRouteForStore($store_id,$roadDetail->company_id,0);
                $this->AuditRoadStoreRepo->deleteForStore($store_id,$roadDetail->company_id,$id);
            }
        }


        $message = "Ruta con id ". $road->id. " y nombre " . $road->fullname . " fue eliminado con exito así como todos sus ".$c." agentes liberados";
        $road->delete();
        if(Request::ajax()){
            return Response::json(['success' => true, 'message' => $message]);
        }

    }

    public function addAgentRoad($road_id,$agent_id,$company_id)
    {

        if ($this->roadDetailRepo->existAgentInRoute($road_id,$agent_id,$company_id))
        {
            /*Session::flash('error', 'El Agente con id '.$agent_id . ' ya esta ingresado en esta ruta');
            Session::flash('info', '0');*/
            return Redirect::route('roadDetail',$road_id)->with('error','El Punto  con id '.$agent_id . ' ya esta ingresado en esta ruta con id: '.$road_id);
        }else{
            $this->StoreRepo->updateRouteForStore($agent_id,1);
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $this->AuditRoadStoreRepo->insertAuditsStore($agent_id,$road_id,$company_id, $AuditsCompany);
            $this->roadDetailRepo->insertStoreInRoute($agent_id,$road_id,$company_id);
            $this->companyStoreRepo->updateRouteForStore($agent_id,$company_id,1);
            /*Session::flash('error', '0');
            Session::flash('info', 'El Agente con id '.$agent_id . ' ya fue ingresado en esta ruta');*/
            return Redirect::route('roadDetail',$road_id)->with('info','El punto con id '.$agent_id . ' ya fue ingresado en esta ruta con id: '.$road_id);

        }
    }
    
    public function saveRouteVisits(){
        $user_id = Input::only('user_id');
        $id_store = Input::only('id_store');
        $nombreRuta = Input::only('nombreRuta');
        $customer_id=5;$study_id=2;

        
        $objRoad = $this->roadRepo->getModel();
        $objRoad->fullname = $nombreRuta['nombreRuta'];
        $objRoad->user_id = $user_id['user_id'];
        $objRoad->save();
        $lastInsert = $objRoad->id;

        if ($lastInsert>0) {
            $idRoad = $lastInsert;
            for ($i = 0; $i < count($id_store['id_store']); ++$i) {
                $valores = explode('|',$id_store['id_store'][$i]);
                $visit_id_now = $valores[2];
                $visit_id_new = $valores[3];
                $objRoadDetail = $this->roadDetailRepo->getModel();
                $objRoadDetail->store_id = $valores[0];
                $objRoadDetail->audit = 0;
                $objRoadDetail->road_id = $idRoad;
                $objRoadDetail->company_id = $valores[1];
                $objRoadDetail->save();
                $audits = $this->companyAuditRepo->getAuditsForCompany($valores[1]);
                if (count($audits)>0) {
                    //$affectedRows = CompanyStore::where('store_id', '=', $store_id)->where('company_id', '=', $company_id)->update(array('ruteado' => $valor));
                    foreach ($audits as $v) {//company_id,road_id,audit_id,store_id
                        $objAuditRoadStore = $this->AuditRoadStoreRepo->getModel();
                        $objAuditRoadStore->company_id = $valores[1];
                        $objAuditRoadStore->road_id = $idRoad;
                        $objAuditRoadStore->audit_id = $v->audit_id;
                        $objAuditRoadStore->store_id = $valores[0];
                        $objAuditRoadStore->visit_id = $visit_id_new;
                        $objAuditRoadStore->save();
                    }
                    if ($visit_id_now=="0"){
                        $this->companyStoreRepo->updateRouteForStore($valores[0],$valores[1],1);
                        $objStore = $this->StoreRepo->find($valores[0]);
                        $objStore->ruteado=1;
                        $objStore->update();
                    }else{
                        $this->visitStoreRepo->updateRoutingForVisit($valores[0],$valores[1],$visit_id_now,1);
                    }
                    $objVisitStore = $this->visitStoreRepo->getModel();
                    $objVisitStore->store_id= $valores[0];
                    $objVisitStore->company_id = $valores[1];
                    $objVisitStore->visit_id = $visit_id_new;
                    $objVisitStore->road_id = $idRoad;
                    $objVisitStore->ruteado=0;
                    $objVisitStore->save();

                }
            }
            header('Access-Control-Allow-Origin: *');
            return \Response::json([ 'success'=> 1]);
        }else{
            header('Access-Control-Allow-Origin: *');
            return \Response::json([ 'success'=> 0]);
        }
    }

} 
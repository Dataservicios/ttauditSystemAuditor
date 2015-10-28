<?php

use Auditor\Repositories\PresenceRepo;
use Auditor\Repositories\PresenceDetailRepo;
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Repositories\MediaRepo;


class ReportColgateController extends BaseController{

    protected $PresenceRepo;
    protected $PresenceDetailRepo;
    protected $UserCompanyRepo;
    protected $StoreRepo;
    protected $PublicitiesDetailRepo;
    protected $MediaRepo;

    public $urlBase;
    public $urlImagesPublicities;


    public function __construct(MediaRepo $MediaRepo,PublicitiesDetailRepo $PublicitiesDetailRepo,StoreRepo $StoreRepo, UserCompanyRepo $UserCompanyRepo, PresenceDetailRepo $PresenceDetailRepo, PresenceRepo $PresenceRepo)
    {
        $this->PresenceRepo = $PresenceRepo;
        $this->PresenceDetailRepo = $PresenceDetailRepo;
        $this->UserCompanyRepo = $UserCompanyRepo;
        $this->StoreRepo = $StoreRepo;
        $this->PublicitiesDetailRepo = $PublicitiesDetailRepo;
        $this->MediaRepo = $MediaRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
    }


    public function getCountForPresenceDetail($audit_id="0",$store_id="0")
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $presences = $this->PresenceDetailRepo->getCountPresenciasDetails();
            return View::make('report/colgate/presence',compact('presences','AuditsCompany','audit_id'));
        }

    }

    public function getCountForPublicitiesDetail($audit_id="0",$store_id="0")
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $publicities = $this->PublicitiesDetailRepo->getCountPublicitiesDetails();
            return View::make('report/colgate/publicity',compact('publicities','AuditsCompany','audit_id'));
        }

    }

    public function detailPresenceDetailForPresence($presence_id,$audit_id)
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $presences = $this->PresenceDetailRepo->listPresenciasDetailsForPresence($presence_id);$c=0;
            foreach ($presences as $presence)
            {
                $c=$c+1;
                $store = $this->StoreRepo->find($presence->store_id);
                $valores[] = array('num' =>$c,'id'=>$presence->id,'product_id'=>$presence->presence->product->id,'product'=>$presence->presence->product->fullname,'imagen'=>$presence->presence->product->imagen,'store_id'=>$store->id,'mayorista'=>$store->fullname, 'created_at' =>$presence->created_at);
            }
            return View::make('report/colgate/presenceDetail',compact('valores','AuditsCompany','audit_id'));
        }
    }

    public function detailPublicityDetailForPublicity($publicities_id,$audit_id)
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $publicities = $this->PublicitiesDetailRepo->listPublicitiesDetailsForPublicity($publicities_id);$c=0;
            foreach ($publicities as $publici)
            {
                $c=$c+1;
                $store = $this->StoreRepo->find($publici->store_id);
                $photos = $this->MediaRepo->photosPublicityStore($publici->publicity_id, $store->id);
                //dd($store->id);
                if(! empty($photos)){
                    //dd(\App::make('url')->to('/'));
                    foreach ($photos as $photo){
                        $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlImages.$photo->archivo);
                    }
                }else{
                    $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                }

                $valores[] = array('num' =>$c,'id'=>$publici->id,'publicity_id'=>$publici->publicity->id,'publicidad'=>$publici->publicity->fullname,'imagen'=>$publici->publicity->imagen,'store_id'=>$store->id,'mayorista'=>$store->fullname,'store_direccion'=>$store->address,'mayorista'=>$store->fullname, 'created_at' =>$publici->created_at, 'arrayFoto' => $datosFoto);
                unset($datosFoto);
            }
            return View::make('report/colgate/publicityDetail',compact('valores','AuditsCompany','audit_id'));
        }
    }
} 
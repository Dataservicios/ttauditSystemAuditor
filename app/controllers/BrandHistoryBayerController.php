<?php

use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\VisitorRepo;

class BrandHistoryBayerController extends BaseController{

    protected $customerRepo;
    protected $companyRepo;
    protected $visitorRepo;

    public $urlBase;
    public $urlImagesPublicities;
    public $urlImagesProducts;
    public $urlImages;
    public $urlImageBase;
    public $pollArray;
    public $estudio;
    public $customer_id;


    public function __construct(VisitorRepo $visitorRepo,CustomerRepo $customerRepo,CompanyRepo $companyRepo)
    {
        $this->customerRepo = $customerRepo;
        $this->companyRepo = $companyRepo;
        $this->visitorRepo = $visitorRepo;

        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
        $this->urlImagesProducts = '/media/images/bayer/products/';
        $this->customer_id = 5;

        $this->estudio='1';
        $this->saveSessions();
    }

    public function homeBrandHistory(){
        $titulo='Histórico por Marcas';
        $customer =$this->customerRepo->find($this->customer_id);//dd($customer);
        $logo = $this->urlBase.$this->urlImageBase.$customer->corto.'/'.$customer->logo;
        $objCompany = $this->companyRepo->getFirstCurrentCampaigns($this->customer_id,$this->estudio);
        $company_id = $objCompany->id;
        $urlBase = $this->urlBase;
        $audit_id=0;
        $menus = $this->generateMenusBayer($company_id,0,1);
        return View::make('report/bayer/brandHistory',compact('titulo','logo','menus','company_id','audit_id','urlBase'));
    }

} 
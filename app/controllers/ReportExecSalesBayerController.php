<?php

use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\ProductRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\ProductDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;


class ReportExecSalesBayerController extends BaseController{

    protected $categoryProductRepo;

    protected $PollRepo;
    protected $PollDetailRepo;
    protected $ProductRepo;
    protected $StoreRepo;
    protected $companyRepo;
    protected $customerRepo;
    protected $productDetailRepo;
    protected $PollOptionRepo;
    protected $PollOptionDetailRepo;

    public $urlBase;
    public $urlImagesPublicities;
    public $urlImagesProducts;
    public $urlImages;
    public $urlImageBase;
    public $pollArray;


    public function __construct(PollOptionDetailRepo $PollOptionDetailRepo,PollOptionRepo $PollOptionRepo,ProductDetailRepo $productDetailRepo,PollRepo $PollRepo,ProductRepo $ProductRepo,PollDetailRepo $PollDetailRepo, CategoryProductRepo $categoryProductRepo,CustomerRepo $customerRepo,CompanyRepo $companyRepo,StoreRepo $StoreRepo)
    {
        $this->StoreRepo = $StoreRepo;
        $this->categoryProductRepo = $categoryProductRepo;

        $this->PollRepo = $PollRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->ProductRepo = $ProductRepo;
        $this->companyRepo = $companyRepo;
        $this->customerRepo = $customerRepo;
        $this->productDetailRepo = $productDetailRepo;
        $this->PollOptionRepo = $PollOptionRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
        $this->urlImageBase = '/media/images/';
        $this->urlImagesProducts = '/media/images/bayer/products/';
        $this->pollArray[9] = array('abierto' => 103,'recomendo' => 71);
        $this->pollArray[11] = array('abierto' => 106,'recomendo' => 108, 'exhibicion' => 107);
        $this->pollArray[13] = array('abierto' => 142,'recomendo' => 144, 'exhibicion' => 143);
        $this->pollArray[16] = array('abierto' => 151,'recomendo' => 153, 'exhibicion' => 152);
        $this->pollArray[17] = array('abierto' => 194,'recomendo' => 196, 'exhibicion' => 195);
        $this->pollArray[19] = array('abierto' => 206,'recomendo' => 208, 'exhibicion' => 207);
    }

    public function homeComparationCampaigns()
    {
        
    }

} 
<?php

use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;



class PruebasController  extends BaseController{

    protected $userCompanyRepo;
    protected $customerRepo;
    protected $companyRepo;

    public function __construct(CompanyRepo $companyRepo,CustomerRepo $customerRepo,UserCompanyRepo $userCompanyRepo)
    {
        $this->userCompanyRepo = $userCompanyRepo;
        $this->customerRepo = $customerRepo;
        $this->companyRepo = $companyRepo;
    }

    public function ListCompanies()
    {

        $companies = $this->companyRepo->listCompanies();
        //dd($companies[2]->fullname) ;
        return View::make('pruebaAjax',compact('companies'));
    }

    public function ListCompaniesAjax()
    {


        //dd( \Response::ajax() );
       //if(Response::ajax()) {
//            return "Prueba ajax";
//
            $companies = $this->companyRepo->listCompanies();
//            //return response()->json([ 'success'=> 1, "version" => '1.3 ']);
           return Response::json($companies);
//        }
//		return view('pruebaAjax');


   }
    
} 
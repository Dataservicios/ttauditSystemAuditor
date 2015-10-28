<?php
use Auditor\Repositories\CompanyRepo;
use Auditor\Managers\CompanyManager;

class CompanyController extends BaseController{

    protected $companyRepo;

    public function __construct(CompanyRepo $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function products($id)
    {
        $company =$this->companyRepo->find($id);
        /*dd($company);*/
        return View::make('company/products',compact('company'));
    }

    public function listCompanies()
    {
        $companies =$this->companyRepo->listCompanies();
        /*dd($category);*/
        return View::make('company/list',compact('companies'));
    }

    public function newCompany()
    {
        return View::make('company/new');
    }

    public function register()
    {
        $company = $this->companyRepo->newCompany();
        //dd($company);
        $manager = new CompanyManager($company, Input::all());

        $manager->save();
        return Redirect::route('listCompanies');

    }

    public function getCategoryForCompany()
    {
        $id = Input::get('option'); return $this->companyRepo->getCategoriesProductForCompany($id);
    }

} 
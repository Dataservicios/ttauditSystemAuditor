<?php
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\SpaceRepo;
use Auditor\Managers\SpaceManager;

class SpaceController extends BaseController{

    protected $spaceRepo;

    public function __construct(SpaceRepo $spaceRepo)
    {
        $this->spaceRepo = $spaceRepo;
    }

    /*public function getIndex(){

    }*/

    public function listSpacesTotal(){
        $listcomp= $this->getCompanies();
        $combobox = array(0 => "--- Seleccione un Cliente --- ") + $listcomp;
        $selected = array();
        return View::make('audits/auditSpaces',compact('combobox','selected'));
    }


    public function insertSpace()
    {
        $listcomp= $this->getCompanies();
        $combobox = array(0 => "--- Seleccione una empresa --- ") + $listcomp;
        $selected = array();
        return View::make('audits/confSpaces',compact('combobox','selected'));
    }

    public function registerSpace()
    {
        $company = $this->spaceRepo->newSpace();
        //dd($company);
        $manager = new SpaceManager($company, Input::all());

        $manager->save();
        return Redirect::route('listCompanies');

    }

    public function listSpaces()
    {
        $companies =$this->companyRepo->listCompanies();
        /*dd($category);*/
        return View::make('company/list',compact('companies'));
    }

    public function listSpacesForCompany()
    {
        $id = Input::only('company_id');
        $companies= New CompanyRepo;
        $company = $companies->find($id);
        //dd($company[0]->fullname);
        $spaces =$this->spaceRepo->listSpacesForCompany($id);
        $listcomp= $this->getCompanies();
        $combobox = array(0 => "--- Seleccione un Cliente --- ") + $listcomp;
        $selected = array();
        //dd($spaces);
        return View::make('audits/auditSpaces',compact('combobox','selected','spaces','company'));
    }



} 
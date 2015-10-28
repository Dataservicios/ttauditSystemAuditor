<?php
namespace Auditor\Repositories;

use Auditor\Entities\Space;


class SpaceRepo extends BaseRepo{

    public function getModel()
    {
        return new Space;
    }

   /* public function listCompanies()
    {
        $companies = Company::paginate();
        return $companies;
    }*/

    public function newSpace()
    {
        $company = new Space();
        //$user->type = 'auditor';
        return $company;
    }

    public function listSpaces()
    {
        $companies = Space::paginate();
        return $companies;
    }

    public function listSpacesForCompany($idcompany)
    {
        $spaces = Space::where('company_id', $idcompany)->get();
        //dd($spaces);
        return $spaces;
    }

} 
<?php
namespace Auditor\Repositories;
use Auditor\Entities\CategoryProduct;
use Auditor\Entities\CompanyStore;


class CompanyStoreRepo extends BaseRepo{

    public function getModel()
    {
        return new CompanyStore;
    }

    public function getQuantityStoresForCompany($company_id)
    {
        $sql = "SELECT count(id) as regs FROM company_stores c where company_id='" . $company_id . "'";
        $registros =  \DB::select($sql);
        //dd($registros);
        return $registros[0]->regs;
    }

    public function getStoresForCompany($company_id)
    {
        $registros = \DB::table('company_stores')->join('stores','company_stores.store_id','=','stores.id')->select('stores.id','stores.codclient', 'stores.fullname')->where('company_stores.company_id', $company_id)->orderBy('stores.codclient', 'desc')->get();

        //dd($registros);
        return $registros;
    }
} 
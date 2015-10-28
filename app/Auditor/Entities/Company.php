<?php
namespace Auditor\Entities;
class Company extends \Eloquent {
	protected $fillable = array('fullname');
    protected $perPage = 15;
    protected $table = 'companies';

    public function products()
{
    return $this->hasMany('Auditor\Entities\Product');
}

    public function companyStores()
    {
        return $this->hasMany('Auditor\Entities\CompanyStore');
    }

    public function companyAudits()
    {
        return $this->hasMany('Auditor\Entities\CompanyAudit');
    }

    public function userCompanies()
    {
        return $this->hasMany('Auditor\Entities\UserCompany');
    }

    public function getPaginateProductsAttribute()
    {
        return Product::where('company_id', $this->id)->paginate();
    }
}
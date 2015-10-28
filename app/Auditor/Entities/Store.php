<?php
namespace Auditor\Entities;
class Store extends \Eloquent {
    protected $fillable = array('fullname','type','owner','address','urbanization','district','region','ubigeo','distributor','latitude','longitude','photo','ejecutivo','rubro');
    protected $perPage = 15;
    protected $table = 'stores';

    public function roadDetails()
    {
        return $this->hasMany('Auditor\Entities\RoadDetail');
    }

    public function companyStores()
    {
        return $this->hasMany('Auditor\Entities\CompanyStore');
    }

}
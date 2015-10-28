<?php
namespace Auditor\Entities;

class Audit extends \Eloquent {
	protected $fillable = [];

    public function companyAudits()
    {
        return $this->hasMany('Auditor\Entities\CompanyAudit');
    }




}
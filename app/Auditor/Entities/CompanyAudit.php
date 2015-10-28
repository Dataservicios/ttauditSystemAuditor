<?php
namespace Auditor\Entities;
class CompanyAudit extends \Eloquent {
	protected $fillable = [];

    public function audit()
    {
        return $this->belongsto('Auditor\Entities\Audit');
    }

    public function company()
    {
        return $this->belongsto('Auditor\Entities\Company');
    }

}
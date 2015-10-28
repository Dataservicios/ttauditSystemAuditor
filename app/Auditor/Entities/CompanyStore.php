<?php
namespace Auditor\Entities;
class CompanyStore extends \Eloquent {
	protected $fillable = [];

    public function store()
    {
        return $this->belongsto('Auditor\Entities\Store');
    }

    public function company()
    {
        return $this->belongsto('Auditor\Entities\Company');
    }

}
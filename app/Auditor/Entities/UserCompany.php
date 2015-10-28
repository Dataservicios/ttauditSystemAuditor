<?php
namespace Auditor\Entities;
class UserCompany extends \Eloquent {
	protected $fillable = [];

    public function user()
    {
        return $this->belongsto('Auditor\Entities\User');
    }

    public function company()
    {
        return $this->belongsto('Auditor\Entities\Company');
    }

}
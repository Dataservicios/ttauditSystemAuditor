<?php
namespace Auditor\Entities;
class Presence extends \Eloquent {
	protected $fillable = [];

    /*public function audit()
    {
        return $this->belongsto('Auditor\Entities\Audit');
    }*/

    public function product()
    {
        return $this->belongsto('Auditor\Entities\Product');
    }

    public function presenceDetails()
    {
        return $this->hasMany('Auditor\Entities\PresenceDetail');
    }

}
<?php
namespace Auditor\Entities;
class Road extends \Eloquent {
	protected $fillable = [];
    protected $perPage = 50;

    public function roadDetails()
    {
        return $this->hasMany('Auditor\Entities\RoadDetail');
    }

    public function company()
    {
        return $this->belongsto('Auditor\Entities\Company');
    }

    public function user()
    {
        return $this->belongsto('Auditor\Entities\User');
    }

}
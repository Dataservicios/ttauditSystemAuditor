<?php
namespace Auditor\Entities;
class Road extends \Eloquent {
	protected $fillable = [];

    public function roadDetails()
    {
        return $this->hasMany('Auditor\Entities\RoadDetail');
    }

    public function user()
    {
        return $this->belongsto('Auditor\Entities\User');
    }

}
<?php
namespace Auditor\Entities;
class RoadDetail extends \Eloquent {
	protected $fillable = [];

    public function road()
    {
        return $this->belongsto('Auditor\Entities\Road');
    }

    public function store()
    {
        return $this->belongsto('Auditor\Entities\Store');
    }
}
<?php
namespace Auditor\Entities;
class Publicity extends \Eloquent {
	protected $fillable = [];

	public function publicitiesDetails()
	{
		return $this->hasMany('Auditor\Entities\PublicityDetail');
	}

	public function categoryProduct()
	{
		return $this->belongsto('Auditor\Entities\CategoryProduct');
	}
}
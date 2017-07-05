<?php
namespace Auditor\Entities;
class Publicity extends \Eloquent {
	protected $fillable = [];
	protected $table = 'publicities';

	public function publicitiesDetails()
	{
		return $this->hasMany('Auditor\Entities\PublicityDetail');
	}

	public function publicitiesCampaigne()
	{
		return $this->hasMany('Auditor\Entities\PublicityCampaigne');
	}

	public function categoryProduct()
	{
		return $this->belongsto('Auditor\Entities\CategoryProduct');
	}

	public function pollDetail()
	{
		return $this->hasMany('Auditor\Entities\PollDetail');
	}

	public function publicitiesStore()
	{
		return $this->hasMany('Auditor\Entities\PublicityStore');
	}
}
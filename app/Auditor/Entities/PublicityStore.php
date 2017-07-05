<?php
namespace Auditor\Entities;
class PublicityStore extends \Eloquent {
	protected $fillable = [];
	protected $table = 'publicity_store';

	public function publicity()
	{
		return $this->belongsto('Auditor\Entities\Publicity');
	}

	public function store()
	{
		return $this->belongsto('Auditor\Entities\Store');
	}

	public function company()
	{
		return $this->belongsto('Auditor\Entities\Company');
	}
}
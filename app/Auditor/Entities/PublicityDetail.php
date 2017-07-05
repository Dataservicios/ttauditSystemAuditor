<?php
namespace Auditor\Entities;
class PublicityDetail extends \Eloquent {
	protected $fillable = ['store_id','publicity_id','user_id','result','company_id','created_at'];

	public function publicity()
	{
		return $this->belongsto('Auditor\Entities\Publicity');
	}
}
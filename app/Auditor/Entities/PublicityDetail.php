<?php
namespace Auditor\Entities;
class PublicityDetail extends \Eloquent {
	protected $fillable = [];

	public function publicity()
	{
		return $this->belongsto('Auditor\Entities\Publicity');
	}
}
<?php

namespace Auditor\Entities;
class PublicityCampaigne extends \Eloquent {
	protected $fillable = [];
	protected $table = 'publicity_campaigne';

	public function publicity()
	{
		return $this->belongsto('Auditor\Entities\Publicity');
	}
}
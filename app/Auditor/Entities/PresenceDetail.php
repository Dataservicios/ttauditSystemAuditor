<?php
namespace Auditor\Entities;
class PresenceDetail extends \Eloquent {
	protected $fillable = [];
    protected $perPage = 100;

    public function presence()
    {
        return $this->belongsto('Auditor\Entities\Presence');
    }

}
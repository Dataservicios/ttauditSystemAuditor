<?php
namespace Auditor\Entities;
class PresenceDetail extends \Eloquent {
	protected $fillable = [];

    public function presence()
    {
        return $this->belongsto('Auditor\Entities\Presence');
    }

}
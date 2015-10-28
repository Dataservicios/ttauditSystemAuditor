<?php
namespace Auditor\Entities;
class Poll extends \Eloquent {
	protected $fillable = ['company_audit_id','question','orden','sino','options'];
    protected $perPage = 15;
    protected $table = 'polls';

    public function pollDetail()
    {
        return $this->belongsto('Auditor\Entities\PollDetail');
    }
}
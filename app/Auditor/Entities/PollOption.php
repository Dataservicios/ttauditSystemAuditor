<?php
namespace Auditor\Entities;
class PollOption extends \Eloquent {
	protected $fillable = ['poll_id','options','options_abreviado','codigo'];
    protected $perPage = 15;
    protected $table = 'poll_options';

    public function pollOptionDetail()
    {
        return $this->hasMany('Auditor\Entities\PollOptionDetail');
    }
}
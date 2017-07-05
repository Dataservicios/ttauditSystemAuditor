<?php
namespace Auditor\Entities;
class PollOptionDetail extends \Eloquent {
    protected $fillable = ['poll_option_id','result','otro','store_id','auditor'];
    protected $perPage = 15;
    protected $table = 'poll_option_details';

    public function pollOption()
    {
        return $this->belongsto('Auditor\Entities\PollOption');
    }
}
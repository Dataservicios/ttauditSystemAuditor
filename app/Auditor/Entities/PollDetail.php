<?php
namespace Auditor\Entities;
class PollDetail extends \Eloquent {
	protected $fillable = ['poll_id','store_id','sino','options','limits','media','coment','result','limite','comentario','comentOptions','auditor'];
    protected $table = 'poll_details';


    public function poll()
    {
        return $this->belongsto('Auditor\Entities\Poll');
    }

    public function product()
    {
        return $this->belongsto('Auditor\Entities\Product');
    }

    public function publicity()
    {
        return $this->belongsto('Auditor\Entities\Publicity');
    }
}
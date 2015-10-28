<?php
namespace Auditor\Entities;
class SpaceDetail extends \Eloquent {
	protected $fillable = [];
    protected $table = 'space_details';

    public function space()
    {
        return $this->belongsto('Auditor\Entities\Space');
    }

    public function categoryProduct()
    {
        return $this->belongsto('Auditor\Entities\CategoryProduct');
    }

}
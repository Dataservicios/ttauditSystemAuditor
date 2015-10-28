<?php
namespace Auditor\Entities;
class Space extends \Eloquent {
    protected $fillable = array('company_id','category_product_id','green','ambar','red');
    protected $perPage = 15;
    protected $table = 'spaces';

   /* public function audit()
    {
        return $this->belongsto('Auditor\Entities\Audit');
    }*/

    public function categoryProduct()
    {
        return $this->belongsto('Auditor\Entities\CategoryProduct');
    }

    public function spaceDetail()
    {
        return $this->belongsto('Auditor\Entities\SpaceDetail');
    }

}
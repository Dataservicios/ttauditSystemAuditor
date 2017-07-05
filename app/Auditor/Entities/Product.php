<?php
namespace Auditor\Entities;

class Product extends \Eloquent {
	protected $fillable = [];
    protected $perPage = 10;

    public function company()
    {
        return $this->belongsto('Auditor\Entities\Company');
    }

    public function categoryProduct()
    {
        return $this->belongsto('Auditor\Entities\CategoryProduct');

    }
    public function productDetail()
    {
        return $this->belongsto('Auditor\Entities\ProductDetail');

    }

    public function pollDetail()
    {
        return $this->hasMany('Auditor\Entities\PollDetail');
    }

    public function productStoreRegion()
    {
        return $this->hasMany('Auditor\Entities\ProductStoreRegion');
    }
}
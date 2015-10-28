<?php
namespace Auditor\Entities;
class CategoryProduct extends \Eloquent {
	protected $fillable = [];

    public function products()
    {
        return $this->hasMany('Auditor\Entities\Product');
    }

    public function publicity()
    {
        return $this->hasMany('Auditor\Entities\Publicity');
    }

    public function getPaginateProductsAttribute()
    {
        return Product::where('category_product_id', $this->id)->paginate();
    }
}
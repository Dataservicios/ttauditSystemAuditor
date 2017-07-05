<?php
namespace Auditor\Entities;

class ProductStoreRegion extends \Eloquent {
	protected $fillable = [];
	protected $table = 'product_store_region';

	public function product()
	{
		return $this->belongsto('Auditor\Entities\Product');
	}
}
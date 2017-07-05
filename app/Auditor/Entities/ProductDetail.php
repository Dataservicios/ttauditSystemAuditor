<?php
namespace Auditor\Entities;

class ProductDetail extends \Eloquent {
	protected $fillable = [];
	protected $perPage = 10;
	protected $table = 'product_detail';

	public function product()
	{
		return $this->belongsto('Auditor\Entities\Product');
	}
}
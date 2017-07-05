<?php
namespace Auditor\Entities;
class Media extends \Eloquent {
	protected $fillable = ['store_id','poll_id','tipo','archivo','publicities_id','company_id','product_id','created_at'];
    protected $table = 'medias';
}
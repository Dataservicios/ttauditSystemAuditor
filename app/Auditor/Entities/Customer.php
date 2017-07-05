<?php
namespace Auditor\Entities;

class Customer extends \Eloquent {
	protected $fillable = [];
	protected $perPage = 15;
	protected $table = 'customers';
}
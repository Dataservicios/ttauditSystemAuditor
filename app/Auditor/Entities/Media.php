<?php
namespace Auditor\Entities;
class Media extends \Eloquent {
	protected $fillable = ['store_id','poll_id','tipo','archivo'];
    protected $table = 'medias';
}
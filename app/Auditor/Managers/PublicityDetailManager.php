<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 26/06/2015
 * Time: 01:08 AM
 */

namespace Auditor\Managers;


class PublicityDetailManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'store_id'      => 'required'
        ];
        return $rules;
    }
} 
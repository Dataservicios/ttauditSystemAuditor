<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class PhoneDetailManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'iduser' => 'required'
        ];
        return $rules;
    }


} 
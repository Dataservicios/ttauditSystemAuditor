<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class PollManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'company_id' => 'required',
            'question' => 'required'
        ];
        return $rules;
    }


} 
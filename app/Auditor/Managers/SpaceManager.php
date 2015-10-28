<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class SpaceManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'company_id' => 'required',
            'category_product_id' => 'required',
            'green' => 'required',
            'ambar' => 'required',
            'red' => 'required'
        ];
        return $rules;
    }


} 
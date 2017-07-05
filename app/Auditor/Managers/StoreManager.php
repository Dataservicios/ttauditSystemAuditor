<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class StoreManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'cadenaRuc' => 'required',
            'fullname' => 'required',
            'address' => 'required',
            'district' => 'required',
            'region'    => 'required',
            'ubigeo'=> 'required',
            'latitude'  =>  'required',
            'longitude' => 'required',
        ];
        return $rules;
    }


} 
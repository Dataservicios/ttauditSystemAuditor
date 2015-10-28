<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class UserManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'fullname' => 'required',
            'email'     => 'required|email|unique:users,email,' . $this->entity->id,
            'type'      => 'required',
            'password'  => 'confirmed',
            'password_confirmation' => ''
        ];
        return $rules;
    }


} 
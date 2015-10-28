<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:14 PM
 */

namespace Auditor\Managers;


class RegisterManager extends BaseManager {

    public function getRules()
    {
        $rules = [
            'fullname' => 'required',
            'email'     => 'required|email|unique:users,email',
            'type'      => 'required',
            'password'  => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
        return $rules;
    }


} 
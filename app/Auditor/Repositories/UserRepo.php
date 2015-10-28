<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\User;


class UserRepo extends BaseRepo{

    public function getModel()
    {
        return new User;
    }

    public function newUser()
    {
        $user = new User();
        //$user->type = 'auditor';
        return $user;
    }

    public function listUser()
    {
        $users = User::paginate();
        return $users;
    }


} 
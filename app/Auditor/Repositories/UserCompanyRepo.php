<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\UserCompany;


class UserCompanyRepo extends BaseRepo{

    public function getModel()
    {
        return new UserCompany();
    }

    public function getCompany($user_id)
    {
        $sql="SELECT companies.id, companies.fullname
              FROM
              user_companies  INNER JOIN companies ON (user_companies.company_id = companies.id)
              WHERE
              user_companies.user_id = '".$user_id."' and companies.active=1 order by id desc";
        $consulta=\DB::select($sql);
        return $consulta;
    }

    public function getUsersForCompany($company_id)
    {
        return UserCompany::where('company_id',$company_id)->get();
    }



} 
<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\Presence;


class PresenceRepo extends BaseRepo{

    public function getModel()
    {
        return new Presence();
    }



} 
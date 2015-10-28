<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 30/12/2014
 * Time: 12:38 PM
 */

namespace Auditor\Repositories;

use Auditor\Entities\Store;

class StoreRepo extends BaseRepo {

    public function getModel()
    {
        return new Store();
    }

    public function listStore()
    {
        $store = Store::paginate();
        return $store;
    }

    public function newStore()
    {
        $store = new Store();
        //$user->type = 'auditor';
        return $store;
    }

    public function getStoreForCod($codclient)
    {
        $store = \DB::table('stores')->where('codclient', $codclient)->get();
        return $store;
    }
} 
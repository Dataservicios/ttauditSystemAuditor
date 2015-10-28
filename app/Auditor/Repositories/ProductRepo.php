<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 14/12/2014
 * Time: 08:49 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\Product;
use Auditor\Entities\CategoryProduct;


class ProductRepo extends BaseRepo{

    public function getModel()
    {
        return new Product;
    }

    public function findLatest($take = 10)
    {
        return CategoryProduct::with([
            'products' => function ($q) use ($take) {
                $q->take($take);
                $q->orderBy('created_at', 'DESC');
            }, 'products.company'])->get();
    }

} 
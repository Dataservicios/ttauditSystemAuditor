<?php
namespace Auditor\Repositories;
use Auditor\Entities\CategoryProduct;

class CategoryProductRepo extends BaseRepo {

    public function getModel()
    {
        return new CategoryProduct;
    }

} 
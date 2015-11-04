<?php
namespace Auditor\Repositories;

use Auditor\Entities\Road;


class RoadRepo extends BaseRepo{

    public function getModel()
    {
        return new Road();
    }

    public function listRoads()
    {
        $companies = Road::paginate();
        return $companies;
    }

} 
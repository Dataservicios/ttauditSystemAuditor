<?php
namespace Auditor\Repositories;

use Auditor\Entities\SpaceDetail;


class SpaceDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new SpaceDetail;
    }

} 
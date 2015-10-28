<?php
namespace Auditor\Repositories;

use Auditor\Entities\Audit;


class AuditRepo extends BaseRepo{

    public function getModel()
    {
        return new Audit;
    }


} 
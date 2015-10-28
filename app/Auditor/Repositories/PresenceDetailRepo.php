<?php
namespace Auditor\Repositories;

use Auditor\Entities\PresenceDetail;


class PresenceDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PresenceDetail;
    }

    public function getCountPresenciasDetails()
    {
        $totalOptions = PresenceDetail::select(\DB::raw('count(presence_id) as num, presence_id'))->where('result_product', 1)->groupBy('presence_id')->orderBy('num', 'desc')->get();
        return $totalOptions;
    }

    public function listPresenciasDetailsForPresence($presence_id)
    {
        $totalOptions = PresenceDetail::where('presence_id', $presence_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

} 
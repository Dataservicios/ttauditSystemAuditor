<?php
namespace Auditor\Repositories;

use Auditor\Entities\PublicityDetail;


class PublicitiesDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PublicityDetail;
    }

    public function getCountPublicitiesDetails()
    {
        $totalOptions = PublicityDetail::select(\DB::raw('count(publicity_id) as num, publicity_id'))->where('result', 1)->groupBy('publicity_id')->orderBy('num', 'desc')->get();
        return $totalOptions;
    }

    public function listPublicitiesDetailsForPublicity($publicity_id)
    {
        $totalOptions = PublicityDetail::where('publicity_id', $publicity_id)->orderBy('created_at', 'desc')->get();
        return $totalOptions;
    }

} 
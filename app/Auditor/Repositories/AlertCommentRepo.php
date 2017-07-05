<?php
namespace Auditor\Repositories;

use Auditor\Entities\AlertComment;


class AlertCommentRepo extends BaseRepo{

    public function getModel()
    {
        return new AlertComment;
    }

    public function getListAlertComments($number,$alert_id,$order)
    {
        return AlertComment::where('alert_id',$alert_id)->orderBy('created_at', $order)->take($number)->get();
    }

    public function getCountCommentsForAlert($alert_id)
    {
        return AlertComment::where('alert_id',$alert_id)->count();
    }
} 
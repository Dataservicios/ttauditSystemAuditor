<?php
namespace Auditor\Repositories;

use Auditor\Entities\Visitor;


class VisitorRepo extends BaseRepo{

    public function getModel()
    {
        return new Visitor();
    }

    public function getCountSession($session_id)
    {
        return Visitor::where('session_id',$session_id)->count();
    }

    public function getVisitorForSession($session_id)
    {
        return Visitor::where('session_id',$session_id)->get();
    }

    public function deleteForTime($timeVisit)
    {
        $result=\DB::table('visitors')->where('tiempo_accion_click','<', $timeVisit)->where('nombre_completo', 'invitado')->delete();
        if ($result) return 1; else return 0;
    }

    public function getCountVisitForUser($user_id)
    {
        return Visitor::where('user_id',$user_id)->count();
    }

} 
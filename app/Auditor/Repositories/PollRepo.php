<?php
namespace Auditor\Repositories;

use Auditor\Entities\Poll;


class PollRepo extends BaseRepo{

    public function getModel()
    {
        return new Poll;
    }

    public function newPoll()
    {
        $company = new Poll();
        //$user->type = 'auditor';
        return $company;
    }

    public function getQuestions($id)
    {
        //dd($id);
        $sql = "SELECT s.id, s.question, s.created_at FROM polls s where s.company_id='" . $id . "'";
        return  \DB::select($sql);
    }

    public function getPollsForAuditForCompany($company_audit_id)
    {
        $polls = Poll::where('company_audit_id', $company_audit_id)->orderBy('orden', 'asc')->get();
        //dd($polls);
        return $polls;
    }

    public function getIdsForQuestionForCompany($question,$company_id="0")
    {
        if ($company_id=="0"){
            $polls = Poll::join('company_audits','polls.company_audit_id','=','company_audits.id')->select('polls.id','polls.sino','polls.options','polls.created_at','company_audits.company_id','polls.company_audit_id')->where('polls.question', $question)->get();
        }else{
            $polls = Poll::join('company_audits','polls.company_audit_id','=','company_audits.id')->select('polls.id','polls.sino','polls.options','polls.created_at','company_audits.company_id','polls.company_audit_id')->where('company_audits.company_id', $company_id)->where('polls.question', $question)->get();
        }
        //dd($polls);
        return $polls;
    }

    public function getQuestionsWithPhotos($company_id)
    {
        $polls = Poll::join('company_audits','polls.company_audit_id','=','company_audits.id')->select('polls.id','polls.question','polls.sino','polls.options','polls.created_at','company_audits.company_id','polls.company_audit_id')->where('company_audits.company_id', $company_id)->where('polls.media', 1)->get();
        return $polls;
    }

} 
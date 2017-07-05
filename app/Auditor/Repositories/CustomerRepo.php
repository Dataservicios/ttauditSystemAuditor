<?php
namespace Auditor\Repositories;

use Auditor\Entities\Customer;


class CustomerRepo extends BaseRepo{

    public function getModel()
    {
        return new Customer();
    }

    public function getCustomerActivs($active)
    {
        $polls = Customer::where('vigente', $active)->get();
        //dd($polls);
        return $polls;
    }

    /*public function getQuestions($id)
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
    }*/



} 
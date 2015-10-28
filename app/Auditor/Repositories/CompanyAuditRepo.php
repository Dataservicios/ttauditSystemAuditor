<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:24 PM
 */

namespace Auditor\Repositories;
use Auditor\Entities\CompanyAudit;


class CompanyAuditRepo extends BaseRepo{

    public function getModel()
    {
        return new CompanyAudit;
    }

    public function getIdForAuditForCompany($audit_id,$company_id)
    {
        $sql = "SELECT company_audits.id
                FROM
                company_audits
                WHERE
                company_audits.audit_id = '".$audit_id. "' AND
                company_audits.company_id = '".$company_id."' and
                audit = 1";
        $consulta=\DB::select($sql);
        //dd($sql);
        if (count($consulta)>0){
            return $consulta[0]->id;
        }else{
            return 0;
        }
    }

    public function getAuditsForCompany($company_id)
    {
        $auditsForCompany = CompanyAudit::where('company_id', $company_id)->orderBy('orden', 'asc')->get();
        return $auditsForCompany;
    }

} 
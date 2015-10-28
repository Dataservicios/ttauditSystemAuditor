<?php
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\AuditRepo;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    public function getCompanies()
    {
        $companies= New CompanyRepo;
        return $companies->allReg()->lists('fullname', 'id');
    }

	public function getAuditForCompany($company_id)
	{
		$userType = Auth::user()->type;
		if ($userType) {
			$CompanyAuditRepo = New CompanyAuditRepo;
			$auditsForCompany = $CompanyAuditRepo->getAuditsForCompany($company_id);//dd($auditsForCompany);
			if (count($auditsForCompany)>0){
				foreach ($auditsForCompany as $auditForCompany){
					$AuditRepo = new AuditRepo;
					$AuditsCompany[]=$AuditRepo->find($auditForCompany->audit_id);
				}
				//dd($AuditsCompany);
			}

		}
		return $AuditsCompany;
	}

}

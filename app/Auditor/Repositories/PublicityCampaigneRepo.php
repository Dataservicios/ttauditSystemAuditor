<?php
namespace Auditor\Repositories;

use Auditor\Entities\PublicityCampaigne;


class PublicityCampaigneRepo extends BaseRepo{

    public function getModel()
    {
        return new PublicityCampaigne;
    }
    
    public function getPublicityForCampaigne($company_id)
    {
        return PublicityCampaigne::where('company_id',$company_id)->get();
    }

} 
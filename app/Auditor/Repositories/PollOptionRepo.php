<?php
namespace Auditor\Repositories;

use Auditor\Entities\PollOption;


class PollOptionRepo extends BaseRepo{

    public function getModel()
    {
        return new PollOption;
    }

    public function getOptions($poll_id,$product_id="0")
    {
        if ($product_id=="0")
        {
            $pollOptions = PollOption::where('poll_id', $poll_id)->get();
        }else{
            $pollOptions = PollOption::where('poll_id', $poll_id)->where('product_id',$product_id)->get();
        }

        return $pollOptions;
    }

    public function getOptionsForPollCodigo($poll_id,$codigo)
    {
        $pollOptions = PollOption::where('poll_id', $poll_id)->where('codigo', $codigo)->get();
        return $pollOptions;
    }

    public function getIdForOptionsCompany($options,$company_id)
    {
        $total1 ="SELECT 
  `poll_options`.`id`,
  `poll_options`.`options`
FROM
  `poll_options`
  INNER JOIN `polls` ON (`poll_options`.`poll_id` = `polls`.`id`)
  INNER JOIN `company_audits` ON (`polls`.`company_audit_id` = `company_audits`.`id`)
WHERE
  `poll_options`.`options` = '".$options."' AND 
  `company_audits`.`company_id` = '".$company_id."'";
        $consulta=\DB::select($total1);
        return $consulta;
    }

} 
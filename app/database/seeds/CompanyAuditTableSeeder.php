<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\CompanyAudit;
use Auditor\Entities\AuditRoadStore;

class CompanyAuditTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
        $c=6;

        foreach(range(1, 5) as $index)
        {
            $c=$c+1;
            CompanyAudit::create([
                'audit_id'  => $c,
                'company_id'=> 1,
                'audit'=> 1,
                'orden'=>$c-6,
            ]);
        }

        $d=1;
        foreach(range(1, 3) as $index1)
        {
            $d=$d+1;
            $c=0;
            foreach(range(1, 4) as $index)
            {
                $c=$c+1;
                CompanyAudit::create([
                    'audit_id'  => $c,
                    'company_id'=> $d,
                    'audit'=> 1,
                    'orden'=>$c,
                ]);
            }
        }

	}

}
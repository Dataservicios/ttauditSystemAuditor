<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\RoadDetail;
use Auditor\Entities\AuditRoadStore;

class RoadDetailTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $c=0;
        $array = array(2, 4,5,6,7,9,14,16,17,18,19,25,26,29,30);
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            $c = $array[$i];
            RoadDetail::create([
                'store_id'  => $c,
                'audit'      => 0,
                'road_id'     => 1
            ]);
            $d=6;
            foreach(range(1, 5) as $index1)
            {
                $d=$d+1;
                AuditRoadStore::create([
                    'company_id'    =>1,
                    'road_id'     => 1,
                    'audit_id'      => $d,
                    'store_id'  => $c,
                    'audit'  => 0
                ]);
            }
        }

        $array = array(1,3,8,10,11,12,13,15,20,21,22,23,24,27,28);
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            $c = $array[$i];
            RoadDetail::create([
                'store_id'  => $c,
                'audit'      => 0,
                'road_id'     => 2
            ]);
            $d=6;
            foreach(range(1, 5) as $index1)
            {
                $d=$d+1;
                AuditRoadStore::create([
                    'company_id'    =>1,
                    'road_id'     => 2,
                    'audit_id'      => $d,
                    'store_id'  => $c,
                    'audit'  => 0
                ]);
            }
        }


        foreach(range(1, 9) as $index)
        {
            $c=$c+1;
            RoadDetail::create([
                'store_id'  => $c,
                'audit'      => 0,
                'road_id'     => 3
            ]);
            $d=6;
            foreach(range(1, 5) as $index1)
            {
                $d=$d+1;
                AuditRoadStore::create([
                    'company_id'    =>1,
                    'road_id'     => 3,
                    'audit_id'      => $d,
                    'store_id'  => $c,
                    'audit'  => 0
                ]);
            }
        }



	}

}
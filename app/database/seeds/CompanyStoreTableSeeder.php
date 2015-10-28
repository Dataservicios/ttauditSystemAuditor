<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\CompanyStore;

class CompanyStoreTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
        $c=0;
		/*foreach(range(1, 10) as $index)
		{
            $c=$c+1;
			CompanyStore::create([
                'company_id'    => 2,
                'store_id'      => $c,
			]);
		}
        foreach(range(1, 10) as $index)
        {
            $c=$c+1;
            CompanyStore::create([
                'company_id'    => 3,
                'store_id'      => $c,
            ]);
        }
        foreach(range(1, 10) as $index)
        {
            $c=$c+1;
            CompanyStore::create([
                'company_id'    => 4,
                'store_id'      => $c,
            ]);
        }
        foreach(range(1, 10) as $index)
        {
            $c=$c+1;
            CompanyStore::create([
                'company_id'    => 5,
                'store_id'      => $c,
            ]);
        }*/
        foreach(range(1, 30) as $index)
        {
            $c=$c+1;
            CompanyStore::create([
                'company_id'    => 1,
                'store_id'      => $c,
            ]);
        }

        foreach(range(1, 9) as $index)
        {
            $c=$c+1;
            CompanyStore::create([
                'company_id'    => 2,
                'store_id'      => $c,
            ]);
        }
	}

}
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\Road;

class RoadTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $c=10;
        foreach(range(1, 1) as $index)
        {
            $c=$c+1;
            Road::create([
                'fullname'  => 'Ruta Día '.$c.'-04-2015',
                'user_id'   => 12
            ]);
        }

		foreach(range(1, 1) as $index)
		{
            $c=$c+1;
			Road::create([
                'fullname'  => 'Ruta Día '.$c.'-04-2015',
                'user_id'   => 13
			]);
		}

        foreach(range(1, 1) as $index)
        {
            $c=$c+1;
            Road::create([
                'fullname'  => 'Ruta Día '.$c.'-04-2015',
                'user_id'   => 5
            ]);
        }



	}

}
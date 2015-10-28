<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\User;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		/*foreach(range(1, 10) as $index)
		{
            $nombre = $faker->name;
            User::create([
                'fullname'  => $nombre,
                'type'      => 'auditor',
                'email'     => $faker->email,
                'password'  => \Hash::make(123456)
            ]);

		}*/

        User::create([
            'fullname'  => 'Zarella',
            'type'      => 'auditor',
            'email'     => 'zarijo26@hotmail.com',
            'password'  => \Hash::make(123456)
        ]);
        User::create([
            'fullname'  => 'Roxana',
            'type'      => 'auditor',
            'email'     => 'salet_2202@hotmail.com',
            'password'  => \Hash::make(123456)
        ]);

	}

}
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\User;
use Auditor\Entities\Company;
use Auditor\Entities\UserCompany;

class UserCompanyTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
        $user = User::create([
            'fullname'  => 'Franco Bill Ramirez Sandoval',
            'type'      => 'admin',
            'email'     => 'franbrsj@gmail.com',
            'password'  => \Hash::make('franbrsj09')
        ]);
        $user = User::create([
            'fullname'  => 'Ricardo Gallo',
            'type'      => 'admin',
            'email'     => 'ricardogalloa@yahoo.com',
            'password'  => \Hash::make(123456)
        ]);
        $user = User::create([
            'fullname'  => 'Manuel Roggero',
            'type'      => 'admin',
            'email'     => 'mroggeroc@gmail.com',
            'password'  => \Hash::make(123456)
        ]);
        $user = User::create([
            'fullname'  => 'Johnny Maldonado',
            'type'      => 'admin',
            'email'     => 'jmmvargas@gmail.com',
            'password'  => \Hash::make(123456)
        ]);
        $user = User::create([
            'fullname'  => 'Jaime cribillero',
            'type'      => 'auditor',
            'email'     => 'jcdiaz356@gmail.com',
            'password'  => \Hash::make(123456)
        ]);
        User::create([
            'fullname'  => 'Karla',
            'type'      => 'admin',
            'email'     => 'k_arla_8@hotmail.com',
            'password'  => \Hash::make(123456)
        ]);

        $empresas= array("Interbank", "Procter & Gamble", "Alicorp","Backus", "Data International");
        $c=0;

		foreach(range(1,5) as $index)
		{
            $empresa= $faker->company;
            $nombre = $faker->name;
            $company = Company::create([
                'fullname' => $empresas[$c]
            ]);
            $user = User::create([
                'fullname'  => $nombre,
                'type'      => 'company',
                'email'     => $faker->email,
                'password'  => \Hash::make(123456)
            ]);
			UserCompany::create([
                'user_id'   => $user->id,
                'company_id'=>$company->id
			]);
            $c=$c+1;
		}
	}

}
<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        $this->call('AuditTableSeeder');
        $this->call('CategoryProductTableSeeder');
        $this->call('UserCompanyTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('CompanyAuditTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('StoreTableSeeder');
        $this->call('CompanyStoreTableSeeder');
        $this->call('RoadTableSeeder');
        $this->call('RoadDetailTableSeeder');
	}

}

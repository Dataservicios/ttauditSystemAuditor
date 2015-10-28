<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditRoadStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_road_stores', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('company_id');
            $table->integer('road_id');
            $table->integer('audit_id');
            $table->integer('store_id');
            $table->boolean('audit');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('audit_road_stores');
	}

}

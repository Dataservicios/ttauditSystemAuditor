<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoadDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('road_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->boolean('audit');
            $table->integer('road_id')->unsigned();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('road_id')->references('id')->on('roads')->onDelete('cascade');
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
		Schema::drop('road_details');
	}

}

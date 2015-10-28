<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePublicityDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publicity_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('publicity_id')->unsigned();
            $table->integer('store_id');
            $table->boolean('result');
            $table->string('photo',100);

            $table->foreign('publicity_id')->references('id')->on('publicities');
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
		Schema::drop('publicity_details');
	}

}

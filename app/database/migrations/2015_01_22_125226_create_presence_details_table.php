<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePresenceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('presence_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('presence_id')->unsigned();
            $table->integer('store_id');
            $table->boolean('result_product');
            $table->boolean('result_price');

            $table->foreign('presence_id')->references('id')->on('presences');
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
		Schema::drop('presence_details');
	}

}

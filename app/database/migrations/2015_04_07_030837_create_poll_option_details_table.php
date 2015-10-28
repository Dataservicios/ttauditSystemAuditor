<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollOptionDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_option_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('poll_option_id')->unsigned();
            $table->boolean('result');
            $table->string('otro');
            $table->integer('store_id');

            $table->foreign('poll_option_id')->references('id')->on('poll_options');
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
		Schema::drop('poll_option_details');
	}

}

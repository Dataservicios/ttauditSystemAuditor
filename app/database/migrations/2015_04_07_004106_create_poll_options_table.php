<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_options', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('poll_id')->unsigned();
            $table->string('options');
            $table->string('codigo');

            $table->foreign('poll_id')->references('id')->on('polls');
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
		Schema::drop('poll_options');
	}

}

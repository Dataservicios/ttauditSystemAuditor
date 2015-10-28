<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollRangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_ranges', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('poll_id')->unsigned();
            $table->string('nombre');
            $table->string('superior');
            $table->string('inferior');
            $table->string('umedida');

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
		Schema::drop('poll_ranges');
	}

}

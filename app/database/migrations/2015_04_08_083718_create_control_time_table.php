<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControlTimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('control_time', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('closes');
            $table->integer('user_id');
            $table->integer('store_id');
            $table->integer('audit_id');
            $table->string('lat_close');
            $table->string('long_close');
            $table->string('lat_open');
            $table->string('long_open');
            $table->dateTime('time_open');
            $table->dateTime('time_close');

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
		Schema::drop('control_time');
	}

}

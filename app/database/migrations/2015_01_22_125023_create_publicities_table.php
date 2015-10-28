<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePublicitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publicities', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->longText('fullname');

            $table->foreign('company_id')->references('id')->on('companies');
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
		Schema::drop('publicities');
	}

}

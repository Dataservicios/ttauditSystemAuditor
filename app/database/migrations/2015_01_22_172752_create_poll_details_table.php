<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_details', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('poll_id')->unsigned();
            $table->integer('store_id');
            $table->boolean('sino');
            $table->boolean('options');
            $table->boolean('limits');
            $table->boolean('media');
            $table->boolean('coment');
            $table->boolean('result');
            $table->string('limite');
            $table->mediumText('comentario');

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
		Schema::drop('poll_details');
	}

}

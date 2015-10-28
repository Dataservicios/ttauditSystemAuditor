<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('polls', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('company_audit_id')->unsigned();
            $table->longText('question');
            $table->integer('orden');

            $table->foreign('company_audit_id')->references('id')->on('company_audits');
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
		Schema::drop('polls');
	}

}

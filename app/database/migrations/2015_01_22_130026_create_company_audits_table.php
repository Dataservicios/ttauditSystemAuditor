<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyAuditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_audits', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('audit_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->boolean('audit');
            $table->integer('orden');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
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
		Schema::drop('company_audits');
	}

}

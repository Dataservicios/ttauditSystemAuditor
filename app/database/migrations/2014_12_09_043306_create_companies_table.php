<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('fullname');
            $table->string('ruc');
            $table->string('direction');
            $table->string('contacto');
            $table->string('puesto_contacto');
            $table->string('telefono_contacto');
            $table->string('celular_contacto');
            $table->string('email_contacto');
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
		Schema::drop('companies');
	}

}

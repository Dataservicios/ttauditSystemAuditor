<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spaces', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('company_id')->unsigned();;
            $table->integer('category_product_id')->unsigned();
            $table->string('green');
            $table->string('ambar');
            $table->string('red');

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('category_product_id')->references('id')->on('category_products');
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
		Schema::drop('spaces');
	}

}

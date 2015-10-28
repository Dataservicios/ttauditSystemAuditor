<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpaceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('space_details', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('space_id')->unsigned();
            $table->integer('category_product_id');
            $table->integer('store_id');
            $table->longText('photo');
            $table->double('area_total',10,2);
            $table->double('sub_area',10,2);

            $table->foreign('space_id')->references('id')->on('spaces')->onDelete('cascade');
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
		Schema::drop('space_details');
	}

}

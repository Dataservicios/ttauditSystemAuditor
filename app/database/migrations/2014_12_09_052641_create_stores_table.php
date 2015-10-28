<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('fullname');
            $table->enum('type', ['Bar','Restaurante','Farmacia','Casa de Cambio','Grifo', 'Bodega', 'Mini Market','Puesto de Mercado']);
            $table->string('owner');
            $table->string('address');
            $table->string('urbanization');
            $table->string('district');
            $table->string('region');
            $table->string('ubigeo');
            $table->string('distributor');
            $table->string('codclient');
            $table->string('photo',60);
            $table->string('latitude');
            $table->string('longitude');
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
		Schema::drop('stores');
	}

}

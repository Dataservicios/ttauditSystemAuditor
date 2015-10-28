<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\Product;

class ProductTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 1) as $index)
		{
            Product::create([
                'fullname'  => 'Atención Retiro',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 1,
                'category_product_id'=> 30
            ]);
            Product::create([
                'fullname'  => 'Atención de Pago de tarjetas de Credito',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 1,
                'category_product_id'=> 30
            ]);
            Product::create([
                'fullname'  => 'Atención Deposito',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 1,
                'category_product_id'=> 30
            ]);
            Product::create([
                'fullname'  => 'Pago de Multinivel',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 1,
                'category_product_id'=> 30
            ]);
            Product::create([
                'fullname'  => 'Detergente Ariel Regular',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'Detergente Ariel Regular',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'Detergente Ariel Revitacolor',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'Detergente Ariel UltraBlanqueador',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'Shampoo Head & Shoulders LIMPIEZA RENOVADORA',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 25
            ]);
            Product::create([
                'fullname'  => 'Shampoo Head & Shoulders MANZANA FRESH',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 2,
                'category_product_id'=> 25
            ]);
            Product::create([
                'fullname'  => 'MAYONESA A LA CENA',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 19
            ]);
            Product::create([
                'fullname'  => 'KETCHUP A LA CENA',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 19
            ]);
            Product::create([
                'fullname'  => 'ACEITE PRIMOR PREMIUM',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 16
            ]);
            Product::create([
                'fullname'  => 'ACEITE COCINERO',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 16
            ]);

			Product::create([
                'fullname'  => 'ACEITE CAPRI 100% VEGETAL',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 16
			]);
            Product::create([
                'fullname'  => 'BOLIVAR X 360GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'BOLIVAR X 520GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'BOLIVAR MATIC X 360GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'BOLIVAR MATIC X 520GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'OPAL 2 EN 1 X 360GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'OPAL 2 EN 1 X 520GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'OPAL X 160GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'OPAL X 360GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'OPAL X 520GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'MARSELLA X 160GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'MARSELLA X 360GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'MARSELLA X 520GR',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 3,
                'category_product_id'=> 20
            ]);
            Product::create([
                'fullname'  => 'Cristal Botella 1.1 Lt.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Cristal Botella 650ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Cristal Lata 473 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Cristal Lata 355 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Cristal Lata 250 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Pilsen Botella 630 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'Pilsen Lata 473 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 9
            ]);
            Product::create([
                'fullname'  => 'San Mateo Bidon 21 L..',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 8
            ]);
            Product::create([
                'fullname'  => 'San Mateo Bidon 7 L.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 8
            ]);
            Product::create([
                'fullname'  => 'San Botella 600ml. sin gas',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 8
            ]);
            Product::create([
                'fullname'  => 'San Botella 600ml. con gas',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 8
            ]);

            Product::create([
                'fullname'  => 'Guarana Botella 3L.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 7
            ]);
            Product::create([
                'fullname'  => 'Guarana Botella 2 L.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 7
            ]);
            Product::create([
                'fullname'  => 'Guarana Botella 500 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 7
            ]);
            Product::create([
                'fullname'  => 'Guarana Botella 500 ml. Light.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 7
            ]);
            Product::create([
                'fullname'  => 'Guarana Lata 355 ml.',
                'eam'       => $faker->randomNumber(6),
                'precio'    => $faker->randomFloat(2,1,45),
                'company_id'=> 4,
                'category_product_id'=> 7
            ]);

		}

	}

}
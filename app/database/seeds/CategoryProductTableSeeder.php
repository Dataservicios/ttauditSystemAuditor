<?php
use Auditor\Entities\CategoryProduct;

class CategoryProductTableSeeder extends Seeder {

	public function run()
	{
        $category1=CategoryProduct::create([
                'fullname' =>'Bebidas'
            ]
        );
        $category2=CategoryProduct::create([
                'fullname' =>'Alimentos'
            ]
        );
        $category3=CategoryProduct::create([
                'fullname' =>'Cuidado del Hogar'
            ]
        );
        $category4=CategoryProduct::create([
                'fullname' =>'Cuidado Personal'
            ]
        );
        $category5=CategoryProduct::create([
                'fullname' =>'Servicios Financieros'
            ]
        );
        $category6=CategoryProduct::create([
                'fullname' =>'Telefonia'
            ]
        );


        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Gaseosas'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Agua'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Cerveza'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Rehidratantes'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Jugos'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Yogurt'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Leche'
        ]);
        CategoryProduct::create([
            'idpadre' => $category1->id,
            'fullname' => 'Energizantes'
        ]);

        CategoryProduct::create([
            'idpadre' => $category2->id,
            'fullname' => 'Pastas'
        ]);
        CategoryProduct::create([
            'idpadre' => $category2->id,
            'fullname' => 'Aceites'
        ]);
        CategoryProduct::create([
            'idpadre' => $category2->id,
            'fullname' => 'Conservas'
        ]);
        CategoryProduct::create([
            'idpadre' => $category2->id,
            'fullname' => 'Cereales'
        ]);
        CategoryProduct::create([
            'idpadre' => $category2->id,
            'fullname' => 'Salsas'
        ]);

        CategoryProduct::create([
            'idpadre' => $category3->id,
            'fullname' => 'Detergentes'
        ]);
        CategoryProduct::create([
            'idpadre' => $category3->id,
            'fullname' => 'Lejía'
        ]);
        CategoryProduct::create([
            'idpadre' => $category3->id,
            'fullname' => 'Cloro'
        ]);
        CategoryProduct::create([
            'idpadre' => $category3->id,
            'fullname' => 'Suavizantes'
        ]);

        CategoryProduct::create([
            'idpadre' => $category4->id,
            'fullname' => 'Desodorantes'
        ]);
        CategoryProduct::create([
            'idpadre' => $category4->id,
            'fullname' => 'Shampoos'
        ]);
        CategoryProduct::create([
            'idpadre' => $category4->id,
            'fullname' => 'Jabones'
        ]);
        CategoryProduct::create([
            'idpadre' => $category4->id,
            'fullname' => 'Cremas Faciales'
        ]);

        CategoryProduct::create([
            'idpadre' => $category5->id,
            'fullname' => 'ATMs'
        ]);
        CategoryProduct::create([
            'idpadre' => $category5->id,
            'fullname' => 'Agencias'
        ]);
        CategoryProduct::create([
            'idpadre' => $category5->id,
            'fullname' => 'Agentes'
        ]);
        CategoryProduct::create([
            'idpadre' => $category5->id,
            'fullname' => 'Venta/Cobranza'
        ]);

        CategoryProduct::create([
            'idpadre' => $category6->id,
            'fullname' => 'Recargas'
        ]);
        CategoryProduct::create([
            'idpadre' => $category6->id,
            'fullname' => 'Módulo de Venta'
        ]);
        CategoryProduct::create([
            'idpadre' => $category6->id,
            'fullname' => 'Distribuidores Autorizados'
        ]);

	}

}
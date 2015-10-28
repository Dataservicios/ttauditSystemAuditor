<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\Store;

class StoreTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		/*foreach(range(1, 40) as $index)
		{
			Store::create([
                'fullname'  => $faker->text(35),
                'type'      => $faker->randomElement(['Bar','Restaurante','Farmacia','Casa de Cambio','Grifo', 'Bodega', 'Mini Market','Puesto de Mercado']),
                'owner'     => $faker->name,
                'address'   => $faker->streetAddress,
                'urbanization' => $faker->streetName,
                'district'   => $faker->city,
                'region'    => $faker->country,
                'ubigeo'    => $faker->postcode,
                'distributor' => $faker->text(45),
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude
			]);
		}*/

        Store::create([
            'fullname'  => "Cosmeticos Daniella",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Cl. Mar de las Antillas Mz.E Lt.2 Asoc. El Provenir",
            'urbanization' => "Ate Vitarte",
            'district'   => "Ate",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM2810",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Librería Bazar El Molino",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Grau 350",
            'urbanization' => "Barranco",
            'district'   => "Barranco",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR11524",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Casa de cambio Aquino",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Cl. Fulgencio Valdez N° 689 Urb. Chacra Colorada",
            'urbanization' => "Breña",
            'district'   => "Breña",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR02431",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Morbank",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Av. Argentina 3258 Interior 161 Pab. 1 - C.C. Minka ",
            'urbanization' => "Callao",
            'district'   => "Callao",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR15517",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Servicios Generales Carlitos 2 - I",
            'type'      => 'Mini Market',
            'owner'     => $faker->name,
            'address'   => "Av. Universitaria 509 - Urb. Tungasuca 1 Etapa",
            'urbanization' => "Carabayllo",
            'district'   => "Carabayllo",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR13823",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Librería My Lord",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Victor A. Belaúnde Oeste 275",
            'urbanization' => "Comas",
            'district'   => "Comas",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR24269",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Multiservicios Miami ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Victor A. Belaunde Oeste 163 Urb. Huaquillay - Etapa II",
            'urbanization' => "Comas",
            'district'   => "Comas",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR14826",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Bodega Sandoval - El Agustino",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Jr. Hoyle Palacios 107",
            'urbanization' => "El Agustino",
            'district'   => "El Agustino",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR09424",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Ohana - C.C. Mega Plaza",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Alfredo Mendiola 3698 Local 154",
            'urbanization' => "Independencia",
            'district'   => "Independencia",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM1280",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Kokeshi",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Jr. Huamanchuco 1403",
            'urbanization' => "Jesus María",
            'district'   => "Jesus María",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM2799",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Librería Bazar Carmín ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. La Molina 1047 Tda.104 Urb. El Sol",
            'urbanization' => "La Molina",
            'district'   => "La Molina",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR24314",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Librería Bazar Metali-K",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Nicolas Arriola 828 Tda.6",
            'urbanization' => "La Victoria",
            'district'   => "La Victoria",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR14119",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "411 - Andahuaylas",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Jr. Andahuaylas 1039 tienda 101 - C.C. La Gran Mesa",
            'urbanization' => "La Victoria",
            'district'   => "La Victoria",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM1494",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Farma San Bartolomé - Izaguirre 906",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av. Carlos Izaguirre 906",
            'urbanization' => "Los Olivos",
            'district'   => "Los Olivos",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR04807",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Casa de Cambio Dollar City",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Antigua Panamericana Sur Puesto 67 A - Mercado de Lurín",
            'urbanization' => "Lurín",
            'district'   => "Lurín",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR16013",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Comercial Solsa ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Jr. Leoncio Prado 854 Int. 2",
            'urbanization' => "Magdalena del Mar",
            'district'   => "Magdalena del Mar",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR15808",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Casa de Cambios La Aurora",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Cl. Arias Schreiber 169 - La  Aurora",
            'urbanization' => "Miraflores",
            'district'   => "Miraflores",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR29705",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Cambios Clement",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Av. José Leguía y Meléndez 960",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR02328",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Venta de Celulares Espejo",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Juan Lecaros 2da. Cuadra puesto 8 Mercado Central nro. 1",
            'urbanization' => "Puente Piedra",
            'district'   => "Puente Piedra",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM2492",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Multiservicios & Operaciones Micky - 772",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Alcázar 772 Urb. El Manzano",
            'urbanization' => "Rimac",
            'district'   => "Rimac",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR15932",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Digital Imagen",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Cl. Jorge Muelle 193 - Torres de Limatambo",
            'urbanization' => "San Borja",
            'district'   => "San Borja",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM3481",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Copigama",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Tamayo 156",
            'urbanization' => "San Isidro",
            'district'   => "San Isidro",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR29405",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Boticas Pharma Plaza",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av. Jorge Basadre Oeste 387 - Urb. San Ignacio",
            'urbanization' => "Urb. San Ignacio",
            'district'   => "San Juan de Lurigancho",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR49315",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Peluquería y Locutorio Oscar ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Ramón Vargas Machuca 350 Urb. San Juan Zona B",
            'urbanization' => "Urb. San Ignacio",
            'district'   => "San Juan de Lurigancho",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR27410",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Bazar Mercería Zula ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Jr. Charles Sutton 298 - Urb. Ingeniería",
            'urbanization' => "Urb. Ingeniería",
            'district'   => "San Martín de Porres",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR24233",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "San Miguel Money Exchange",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Jr. Chamaya 190 Tda. 42",
            'urbanization' => "San Miguel",
            'district'   => "San Miguel",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM1339",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Bianca",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Psj. Real 25 Mercado de Productores",
            'urbanization' => "Santa Anita",
            'district'   => "Santa Anita",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM3407",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Fiestas y Colores",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Los próceres 179 Mz G2 Lt.4 Urb. Los Proceres",
            'urbanization' => "Santiago de Surco",
            'district'   => "Santiago de Surco",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM2797",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Licorería El Reducto ",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Angamos Este 2280",
            'urbanization' => "Surquillo",
            'district'   => "Surquillo",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIR24617",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);
        Store::create([
            'fullname'  => "Librería J y J",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Pedro Beltran 125 - Urb. Ciudad Satelite",
            'urbanization' => "Urb. Ciudad Satelite",
            'district'   => "Ventanilla",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'codclient'  =>  "DIRM3680",
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);


        Store::create([
            'fullname'  => "Bodega Gustitos",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "Av. Zaragoza 177 ",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-12.096921393",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Comercial Don Lalo",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "AV. La Alborada 1754 ",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-11.976033364",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Minimarket Benji",
            'type'      => 'Bodega',
            'owner'     => $faker->name,
            'address'   => "AV. La Alborada 1754 ",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-11.976033364",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Botica San Igancio",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av. Bolivar 2012 Pueblo Libre",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-11.976033364",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Especialidades Médica Pediátricas",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av. Jose Leguía y Melendez 1720 Pueblo Libre",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-12.277049640",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Cambios Clement",
            'type'      => 'Casa de Cambio',
            'owner'     => $faker->name,
            'address'   => "Av. Jose Leguía y Melendez 960 Pueblo Libre",
            'urbanization' => "Pueblo Libre",
            'district'   => "Pueblo Libre",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-12.074354000",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Botica Los Precursores",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av Los Precursores 693 San Miguel",
            'urbanization' => "San Miguel",
            'district'   => "San Miguel",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "12.131937000",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Caledonia",
            'type'      => 'Mini Market',
            'owner'     => $faker->name,
            'address'   => "Av Los Precursores 346 Tda 7 San Miguel",
            'urbanization' => "San Miguel",
            'district'   => "San Miguel",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-11.938119000",
            'longitude' => $faker->longitude
        ]);

        Store::create([
            'fullname'  => "Farma Red Perú",
            'type'      => 'Farmacia',
            'owner'     => $faker->name,
            'address'   => "Av Los Precursores 281 San Miguel",
            'urbanization' => "San Miguel",
            'district'   => "San Miguel",
            'region'    => "Lima",
            'ubigeo'    => $faker->postcode,
            'distributor' => $faker->text(45),
            'latitude' => "-12.191701447",
            'longitude' => $faker->longitude
        ]);
	}

}
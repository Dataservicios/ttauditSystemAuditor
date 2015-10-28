<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Auditor\Entities\Audit;

class AuditTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 1) as $index)
		{
			Audit::create([
                'fullname' => "Medir Espacios de Exhibición"
			]);
            Audit::create([
                'fullname' => "Presencia de Producto"
            ]);
            Audit::create([
                'fullname' => "Presencia de Materiales de Exhibición"
            ]);
            Audit::create([
                'fullname' => "Encuesta de servicio"
            ]);
            Audit::create([
                'fullname' => "Medición de Tiempos de Atención"
            ]);
            Audit::create([
                'fullname' => "Observaciones"
            ]);
            Audit::create([
                'fullname' => "Introducción"
            ]);
            Audit::create([
                'fullname' => "Uso de Interbank Agente"
            ]);
            Audit::create([
                'fullname' => "Evaluación de Transacción"
            ]);
            Audit::create([
                'fullname' => "Evaluación del Trato"
            ]);
            Audit::create([
                'fullname' => "Información"
            ]);
		}
	}

}
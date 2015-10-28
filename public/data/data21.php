<?php

	$data = array(
					array(
							"respuesta" => "Le pidió regrese más tarde",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "Lo guio hacia otro Agente",
	 						"cantidad" => 1
						),
					array(
							"respuesta" => "La persona que atiende (operador) no estaba disponible",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "Le dijo como llegar a alguna Tienda Interbank",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "Otro",
	 						"cantidad" => 4
						)
					
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
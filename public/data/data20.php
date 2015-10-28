<?php

	$data = array(
					array(
							"respuesta" => "No había sistema",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "La línea estaba copada para el depósito",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "La persona que atiende (operador) no estaba disponible",
	 						"cantidad" => 1
						),
					array(
							"respuesta" => "El establecimiento estaba congestionado",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "No había efectivo disponible para el retiro",
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
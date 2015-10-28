<?php

	$data = array(
					array(
							"respuesta" => "Pidiendole porfavor mientras terminaba atendiendo a otra persona",
	 						"cantidad" => 0
						),
					array(
							"respuesta" => "Preguntándole desde que llego, que operación iba a realizar, para saber cómo atenderlo",
	 						"cantidad" => 1
						),
					array(
							"respuesta" => "otro",
	 						"cantidad" => 1
						)
					
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
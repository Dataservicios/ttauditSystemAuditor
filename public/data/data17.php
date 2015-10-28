<?php

	$data = array(
					array(
							"tipo" => "Normal",
	 						"cantidad" => 2
						),
					array(
							"tipo" => "Rapida",
	 						"cantidad" => 18
						),
					array(
							"tipo" => "Muy lento",
	 						"cantidad" => 1
						),
					array(
							"tipo" => "Lento",
	 						"cantidad" => 1
						)
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
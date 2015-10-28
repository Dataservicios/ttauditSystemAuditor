<?php

	$data = array(
					array(
							"tipo" => "Auditadas",
	 						"cantidad" => 30,
	 						"color" => "#009B3A"
						),
					array(
							"tipo" => "No auditadas",
	 						"cantidad" => 0,
	 						"color" => "#FF8000"
						)
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
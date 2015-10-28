<?php

	$data = array(
					array(
							"respuesta" => "Me atendieron ",
	 						"cantidad" => 2
						),
					array(
							"respuesta" => "No me atendieron ",
	 						"cantidad" => 0
						)					
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
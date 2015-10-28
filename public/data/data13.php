<?php

	$data = array(
					array(
							"transaccion" => "El encargado estaba ocupado",
	 						"cantidad" => 0
						),
					array(
							"transaccion" => "Por que me indico que no habia sistema",
	 						"cantidad" => 0
						),
					array(
							"transaccion" => "otro",
	 						"cantidad" => 2
						)
					
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
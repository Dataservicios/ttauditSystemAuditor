<?php

	$data = array(
					array(
							"transaccion" => "Pago TC",
	 						"cantidad" => 4
						),
					array(
							"transaccion" => "Retiro",
	 						"cantidad" => 14
						),
					array(
							"transaccion" => "Depósito",
	 						"cantidad" => 6
						),
					array(
							"transaccion" => "Pago de servicio",
	 						"cantidad" => 0
						)
					
				);

		header('Content-Type: application/json');
		echo json_encode($data);
?>
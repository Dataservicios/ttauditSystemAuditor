<?php
if ($_GET['grafico']==1){
    $data = array(
        array(
            "agente" => "Bodega",
            "cantidad" => 4
        ),
        array(
            "agente" => "Farmacia",
            "cantidad" => 3
        ),

        array(
            "agente" => "Locutorio",
            "cantidad" => 1
        ),

        array(
            "agente" => "Librerias",
            "cantidad" => 5
        ),
        array(
            "agente" => "Tiendas Com",
            "cantidad" => 16
        ),
        array(
            "agente" => "Otros",
            "cantidad" => 13
        )

    );
}

if ($_GET['grafico']==10){
    $data = array(
        array(
            "agente" => "Interbak",
            "cantidad" => 12
        ),
        array(
            "agente" => "Otro Agente",
            "cantidad" => 0
        ),

        array(
            "agente" => "En cualquiera",
            "cantidad" => 8
        ),

        array(
            "agente" => "No Precisa",
            "cantidad" => 0
        )

    );
}
		header('Content-Type: application/json');
		echo json_encode($data);
?>
<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
$var = $_POST['company_id'] ;
//echo $var ;

if($var == 30) {


//    for ($i = 1; $i <= 5; $i++) {
//        //$cantidad = rand(1,100);
//        $competencias[] = [
//                    "nombre"  => "Apronax" . $i,
//                    "cantida"  => rand(1,100) ,
//                ];
//    }

    for ($i = 1; $i <= 8; $i++) {
        //$cantidad = rand(1,100);
        $data[] = [
            "estudio" => "ESTUDIO " . $i,
            "competencia1"  => rand(1,100) ,
            "competencia2"  => rand(1,100) ,
            "competencia3"  => rand(1,100) ,
            "competencia4"  => rand(1,100) ,
            "competencias" => 4,
            "names" => "apronax 1, bephantene 2, aspirina 3 , apronax 4",
            "color" =>  "#08A5DE,#FF0000,#FFFF00,#008000",
        ];
    }
    //echo json_encode( $data );
}

if($var == 32) {




    for ($i = 1; $i <= 4; $i++) {
        //$cantidad = rand(1,100);
        $data[] = [
            "estudio" => "ESTUDIO " . $i,
            "apronax"  => rand(1,100) ,
            "bephantene"  => rand(1,100) ,
            "loreal"  => rand(1,100) ,
            "otros"  => rand(1,100) ,

        ];
    }
    //echo json_encode( $data );
}
else if ($var == 31) {
    for ($i = 1; $i <= 5; $i++) {
        //$cantidad = rand(1,100);
        $data[] = [
            "respuesta" => "Estudio " . $i,
            "cantidad"  => rand(1,100) ,
            "porcentaje"=> 20 ,
            "color"     => "#ffffff"
        ];
    }
}


else {
    $data[] = [];
}

echo json_encode( $data );

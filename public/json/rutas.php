<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

//for ($i = 1; $i <= 8; $i++) {
    //$cantidad = rand(1,100);
    $data[] = [
        "store_id" => "1" ,
        "fullname" => "FARMACIA NATTY" ,
        "latitude_open"     => -12.147262,
        "longitude_open"    => -76.970707,
        "latitude_close"    => -12.147262,
        "longitude_close"   => -76.970807,
        "latitude_store"    => -12.147262,
        "longitude_store"   => -76.970807,

    ];

$data[] = [
    "store_id" => "2" ,
    "fullname" => "BOTICAS INTER FARMA" ,
    "latitude_open"  => -12.147262,
    "longitude_open"  => -76.970707,
    "latitude_close"  => -12.147262,
    "longitude_close"  => -76.970707,
    "latitude_store"  => -11.9977443,
    "longitude_store"  => -77.0549606,

];
//}


echo json_encode( $data );
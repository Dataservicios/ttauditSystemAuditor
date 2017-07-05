<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 9/05/2017
 * Time: 03:46
 */
header('Content-Type: application/json');
$company_id = $_POST['company_id'];
$store_id= $_POST['store_id'];
include("includes/configure.php");
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$statement=$pdo->prepare('SELECT `medias`.`id`, `medias`.`store_id`, `medias`.`archivo` FROM `medias`  WHERE  `company_id` = :company_id AND  `store_id` = :store_id ');
$statement->bindValue(':company_id',$company_id, PDO::PARAM_INT);
$statement->bindValue(':store_id',$store_id, PDO::PARAM_INT);
$statement->execute();
$files;
$dir = '../media/fotos/';
//$dir = '../medias/fotos/';
//while( $datos = $statement->fetch() ){
//    //echo $datos['archivo'] ;
//    if (is_file($dir.$datos['archivo'])) {
//        if (unlink($dir.$datos['archivo']) ){
//            //$ficherosEliminados++;
//            $files = $datos['archivo'] . "," . $files ;
//        }
//    }
//};


//

echo "Eliminados : <strong>". $ficherosEliminados ."</strong>";


//sizeof($results);
$data=[
    "success"=> 1,
    "files_images"=>$files,
];




$json=json_encode($data);
//$json=json_encode($results);


echo $json;
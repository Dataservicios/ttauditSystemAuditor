<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 8/05/2017
 * Time: 01:00
 */
header('Content-Type: application/json');
$codclient = $_POST['codclient'];
include("includes/configure.php");
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$statement=$pdo->prepare('SELECT 
  `stores`.`id`,
  `stores`.`cadenaRuc`,
  `stores`.`fullname`,
  `stores`.`address`,
  `stores`.`district`,
  `stores`.`region`,
  `stores`.`codClient`,
  `company_stores`.`company_id`,
  `companies`.`fullname` as nomb_company
FROM
  `stores`
  INNER JOIN `company_stores` ON (`stores`.`id` = `company_stores`.`store_id`)
  LEFT OUTER JOIN `companies` ON (`company_stores`.`company_id` = `companies`.`id`)
WHERE
  `stores`.`codclient` =:codclient 
  ORDER BY
  `stores`.`id`  DESC ');

$statement->bindValue(':codclient', $codclient);
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);

//$results = [
//    "id"=> "75",
//    "fullname"=> "Cliente Perfecto Estudio 5 2017",
//    "logo"=> "ali.jpg",
//    "markerPoint"=> "http://ttaudit.com/rutas-auditor/img/marker_app_alicorp.png",
//
//];

$data=[
    "success"=> sizeof($results),
    "stores"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
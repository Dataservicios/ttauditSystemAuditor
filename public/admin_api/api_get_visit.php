<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 8/05/2017
 * Time: 01:00
 */
header('Content-Type: application/json');

//$visible = $_POST['visible'];
include("includes/configure.php");
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$statement=$pdo->prepare('SELECT 
  `visits`.`id`,
  `visits`.`fullname`,
  `visits`.`company_id`,
  `companies`.`fullname` as `company`,
  `companies`.`customer_id`,
  `customers`.`fullname` as `customer`
FROM
  `visits`
  LEFT OUTER JOIN `companies` ON (`visits`.`company_id` = `companies`.`id`)
  LEFT OUTER JOIN `customers` ON (`companies`.`customer_id` = `customers`.`id`)
WHERE
  `visits`.`active` = 1
ORDER BY
  `visits`.`company_id`,
  `visits`.`order`');

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
    "visits"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
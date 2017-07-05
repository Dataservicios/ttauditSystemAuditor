<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 8/05/2017
 * Time: 01:00
 */
header('Content-Type: application/json');
$active = $_POST['active'];
//$visible = $_POST['visible'];
$app_id = $_POST['app_id'];
include("includes/configure.php");
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$statement=$pdo->prepare('SELECT 
  `companies`.`id`,
  `companies`.`fullname`,
  `companies`.`active`,
  `companies`.`customer_id`,
  `companies`.`visible`,
  `companies`.`auditoria`,
  `companies`.`logo`,
  `companies`.`markerPoint`,
  `companies`.`app_id`,
  `companies`.`created_at`,
  `companies`.`updated_at`
FROM
  `companies`
WHERE
  `companies`.`active` =:active AND 
  `companies`.`app_id` =:app_id ');

$statement->bindValue(':app_id', $app_id);
$statement->bindValue(':active', $active);

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
    "company"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
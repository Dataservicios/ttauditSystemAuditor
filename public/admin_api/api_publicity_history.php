<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 8/05/2017
 * Time: 01:00
 */
header('Content-Type: application/json');
//$visible = $_POST['visible'];
$company_id = $_POST['company_id'];
include("includes/configure.php");
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$statement=$pdo->prepare('SELECT 
  `medias`.`id`,
  `medias`.`category_product_id`,
  \'Publicity\' AS `fullname`,
  `medias`.`store_id`,
  `medias`.`archivo` as `imagen`,
  `medias`.`created_at`,
  `medias`.`updated_at`,
  \'sin descripcion\' AS `description`,
  `companies`.`fullname` AS `company_name`,
  `medias`.`company_id`
FROM
  `medias`
  LEFT OUTER JOIN `companies` ON (`medias`.`company_id` = `companies`.`id`)
WHERE
  `medias`.`company_id` = 73
  LIMIT 10');

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
    "publicity"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
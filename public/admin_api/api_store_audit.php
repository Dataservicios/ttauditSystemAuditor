<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 9/05/2017
 * Time: 01:42
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
  `company_stores`.`company_id` = :company_id  AND 
  `company_stores`.`store_id` = :store_id AND 
  `company_stores`.`ruteado` = 1');

$statement->bindValue(':company_id', $company_id);
$statement->bindValue(':store_id',  $store_id);

$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
//sizeof($results);
$data=[
    "success"=> sizeof($results),
    "stores"=>$results
];
$json=json_encode($data);
//$json=json_encode($results);


echo $json;
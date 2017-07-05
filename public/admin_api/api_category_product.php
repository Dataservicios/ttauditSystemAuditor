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
  `category_products`.`id`,
  `category_products`.`idpadre`,
  `category_products`.`fullname`,
  `category_products`.`type`,
  `category_products`.`created_at`,
  `category_products`.`updated_at`,
  `category_products`.`customer_id`,
  `products`.`company_id`
FROM
  `products`
  LEFT OUTER JOIN `category_products` ON (`products`.`category_product_id` = `category_products`.`id`)
WHERE
  `products`.`company_id` =:company_id
GROUP BY
  category_products.id');

$statement->bindValue(':company_id', $company_id);
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
    "categories"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
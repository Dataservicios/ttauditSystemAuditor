<?php
/**
 * Created by PhpStorm.
 * User: jcdia
 * Date: 8/05/2017
 * Time: 01:00
 */
include("includes/configure.php");

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

//$stmt = $pdo->query('SELECT fullname FROM users');
//while ($row = $stmt->fetch())
//{
//    echo $row['fullname'] . "\n";
//}

$statement=$pdo->prepare('SELECT 
  `companies`.`id`,
  `companies`.`fullname`,
  `companies`.`active`,
  `companies`.`customer_id`,
  `companies`.`visible`,
  `companies`.`auditoria`,
  `companies`.`created_at`,
  `companies`.`updated_at`
FROM
  `companies`
WHERE
  `companies`.`active` = 1 AND 
  `companies`.`visible` = 1');
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
//sizeof($results);
$data=[
    "success"=> sizeof($results),
    "companies"=>$results
];
$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
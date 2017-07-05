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

$statement=$pdo->prepare('SELECT * FROM users');
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
$data=[
    "success"=> 1,
    "Resul"=>$results
];
$json=json_encode();

header('Content-Type: application/json');
echo $json;
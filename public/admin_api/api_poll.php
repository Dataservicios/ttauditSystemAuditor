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
  `polls`.`id`,
  `polls`.`company_audit_id`,
  `polls`.`question`,
  `polls`.`orden`,
  `polls`.`sino`,
  `polls`.`options`,
  `polls`.`option_type`,
  `polls`.`media`,
  `polls`.`comment`,
  `polls`.`comentType`,
  `polls`.`comentTag`,
  `polls`.`publicity`,
  `polls`.`categoryProduct`,
  `polls`.`product`,
  `polls`.`created_at`,
  `polls`.`updated_at`
FROM
  `polls`
  RIGHT OUTER JOIN `company_audits` ON (`polls`.`company_audit_id` = `company_audits`.`id`)
WHERE
  `company_audits`.`company_id`=:company_id');

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
    "polls"=>$results
];

$json=json_encode($data);
//$json=json_encode($results);

header('Content-Type: application/json');
echo $json;
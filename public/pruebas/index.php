<?php include("includes/configure.php"); ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
//Test

//$queEmp = "SELECT
//  `audits`.`id` AS `Audit_id`,
//  `audits`.`fullname`,
//  `stores`.`id` AS `Store_id`,
//  `stores`.`fullname` AS `tienda` ,
//  `polls`.`id` AS `Polls_id`,
//  `polls`.`question`,
//  `poll_details`.`sino`,
//  `poll_details`.`options`,
//  `poll_details`.`result`
//FROM
//  `audits`
//  INNER JOIN `company_audits` ON (`audits`.`id` = `company_audits`.`audit_id`)
//  INNER JOIN `polls` ON (`company_audits`.`id` = `polls`.`company_audit_id`)
//  INNER JOIN `poll_details` ON (`polls`.`id` = `poll_details`.`poll_id`)
//  INNER JOIN `stores` ON (`stores`.`id` = `poll_details`.`store_id`)
//WHERE
//  `audits`.`id` = 8 AND
//  `polls`.`id` = 2
//ORDER BY
//  `polls`.`orden`";
//$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
//$totEmp = mysql_num_rows($resEmp);
//$contador=0;
//if ($totEmp> 0) {
//    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
//        $contador++;
//        echo '<b>' . $contador . " ---- " . $rowEmp['tienda'] . '</b><br>';
//    }
//}
?>
<a href="create_grafico_excel.php?polls_id=2&audits_id=8&sino=1" target="_blank" >EXPORTAL A EXCEL create_grafico_excel.php?polls_id=2&audits_id=8&sino=1</a><br>
<a href="create_grafico_excel.php?polls_id=26&audits_id=7&options=1&coment=1" target="_blank" >EXPORTAL A EXCEL (create_grafico_excel.php?polls_id=26&audits_id=7&options=1&coment=1)</a><br>
</body>
</html>
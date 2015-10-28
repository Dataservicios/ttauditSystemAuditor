<?php
include("includes/configure.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 21/06/2015
 * Time: 11:14 PM
 */

$directorio = opendir("/home/ttaudit/public_html/media/audio/"); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_dir($archivo)){
        $conatador=0;
        //echo $archivo . "<br />";
        $trozos = explode(".", $archivo);
        $queEmp = "SELECT id, fullname ,address, district, region , ubigeo, codclient FROM ttaudit_auditors.stores s where codclient = '". $trozos[0] ."'; ";
        $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
        $totEmp = mysql_num_rows($resEmp);
        $rowEmp = mysql_fetch_assoc($resEmp);


        echo $rowEmp['fullname'] . "<br />";
        echo "<audio src=\"../../media/audio/$archivo \" controls preload=\"none\"  >";
        echo "HTML5 audio not supported";
        echo "</audio>";
    }
}
?>



</body>
</html>


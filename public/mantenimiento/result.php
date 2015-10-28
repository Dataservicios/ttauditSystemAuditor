<?php
include("includes/configure.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); ?>
<!doctype html>
<html lang=sp>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div>

        <?php
        $queEmp = "SELECT id, fullname, codclient FROM stores s  where id='". $_GET['id']."' order by codclient";
        $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
        $totEmp = mysql_num_rows($resEmp);
        $conatador=0;

        ?>
        <div>
            <?php
            if($_GET['file_exite']=="true") {
                echo "<h4>Ya exixte una imagen asignada a esta tienda:</h4>";
            } else {
               echo "<h4>Se guardó correctamente la imágen del la tienda:</h4>";
            }
            ?>

                <?php

                if ($totEmp> 0) {
                    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
                        echo '<b>ID: '.  $rowEmp['id'] .'<br>CODIDO: ' . $rowEmp['codclient'] . "<br> TIENDA: " . $rowEmp['fullname'] . '</b>';
                    }
                }

                ?>

        </div>
        <div>

            <a href="stored-close-imagen.php">VOLVER</a>
        </div>

    </div>
</body>
</html>
<?php
include("includes/configure.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); ?>
        

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylesheet.css"/>
    <link rel="stylesheet" href="css/mapa-styles.css"/>
</head>
<body>
<div class="contenedor">

    <div class="wrapper">
        <h4>Seleccione</h4>

        <div class="controles">
            <?php
            $queEmp = "SELECT ubigeo FROM stores s group by ubigeo;";
            $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
            $totEmp = mysql_num_rows($resEmp);
            $conatador=0;

            ?>
            <select class="form-control" id="zonas" onchange="abreMapa(this)">
                <option value=0>--Seleccione una zona--</option>
                <?php

                if ($totEmp> 0) {
                    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
                        echo '<option value="'.  $rowEmp['ubigeo'] .'">' . $rowEmp['ubigeo'] . '</option>';
                    }
                }

                ?>
            </select>
        </div>
    </div>

</div>

<script type="text/javascript" src="lib/jquery.js"></script>

<script>


    // $("div").click(function () {
    //
    //      $("p").slideToggle("slow");
    //
    //
    //    });

    //$(document).ready(function() {


    function abreMapa(valor){
        //$('#auditor').on('change', 'select', function (e) {
        // var val = $(e.target).val();
        // var text = $(e.target).find("option:selected").text(); //only time the find is required
        // var name = $(e.target).attr('name');
        console.log(valor.value);
        //valor.
        if(valor.value != 0){
            //window.location.href = "http://www.ttaudit.com/geolocalizaciones/geolocalizacionUser.php?road_id=" + valor.value;
            var fullname = valor.options[valor.selectedIndex].text;
            var url= "http://www.ttaudit.com/geolocalizaciones/geolocalizacionUbigeo.php?ubigeo=" + valor.value  ;
            var win = window.open(url, '_blank');
            win.focus();
        }
    }

</script>
</body>
</html>
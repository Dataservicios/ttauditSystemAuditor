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
    <link rel="stylesheet" href="css/stylesheet.css"/>
</head>
<body>

<div class="contenedor">

     <h4> Subida de imágenes </h4>

    <form method="post" enctype="multipart/form-data">
        <?php
        $queEmp = "SELECT id, fullname, codclient FROM stores s order by codclient;";
        $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
        $totEmp = mysql_num_rows($resEmp);
        $conatador=0;

        ?>
        <div>
            Seleccione la Tienda
            <select class="form-control input-sm" id="Escuela" name="store_id">

                <?php

                if ($totEmp> 0) {
                    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
                        echo '<option value="'.  $rowEmp['id'] .'">' . $rowEmp['codclient'] . " - " . $rowEmp['fullname'] . '</option>';
                    }
                }

                ?>
            </select>
        </div>
         <div>
             <input type="file" accept="image/*" name="file_image" id="image" />
         </div>
        <div>

            <input type="submit" value='Subir Foto' onclick="return validateForm()"/>
        </div>

        
    </form>

    <div>

        <?php




       if(isset($_POST['store_id'])) {




           //
           $uploadDir = "../media/fotos/";

           $fileName = $_FILES['file_image']['name'];
           $tmpName = $_FILES['file_image']['tmp_name'];
           $fileSize = $_FILES['file_image']['size'];
           $fileType = $_FILES['file_image']['type'];

           $uploadOk = 1;
           $imageFileType = pathinfo($fileName,PATHINFO_EXTENSION);
           if($imageFileType != "jpg"  && $imageFileType != "jpeg"
               && $imageFileType != "gif" ) {
               echo "Formato permitido solo JPG.";
               $uploadOk = 0;
           }
           $nuevoFilename =   $_POST['store_id'] . "___" . date("Y-m-d"). ".jpg" ;


           $queEmp = "SELECT store_id, archivo  FROM medias m where store_id='" . $_POST['store_id'] . "' and poll_id=27";
           $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
           $totEmp = mysql_num_rows($resEmp);
           if($totEmp > 0){
                   $query="UPDATE medias SET  archivo='" . $nuevoFilename . "', updated_at = now()  where store_id = '" . $_POST['store_id']  . "' and poll_id='27' " ;
                   mysql_query($query, $conexion_db) or die(mysql_error());
             // header("Location: http://ttaudit.com/mantenimiento/result.php?id=" . $_POST['store_id'] . "&file_exite=true" );

               //echo $totEmp;
           } else {
               $query="INSERT INTO medias (store_id, poll_id, tipo, archivo, created_at, updated_at) VALUES ('" . $_POST['store_id'] . "', '27','1', '" . $nuevoFilename . "',now() ,now() )" ;
               mysql_query($query, $conexion_db) or die(mysql_error());
              // echo $totEmp;

           }


           if($uploadOk == 1) {
               $filePath = $uploadDir . $nuevoFilename ;

               $result = move_uploaded_file($tmpName,$filePath);

               if(!$result)
               {
                   echo "Error to Uploading file";
                   exit;
               }

               if(!get_magic_quotes_gpc())
               {

                   $fileName = addslashes($fileName);
                   $filePath = addslashes($filePath);
               }






               echo "Se ha añadido correctamente";
               echo $_POST['store_id']."<br>";
               echo $fileName."<br>";
               echo $imageFileType."<br>";

               header("Location: http://ttaudit.com/mantenimiento/result.php?id=" . $_POST['store_id'] );

           }


           //$image = mysql_real_escape_string($filePath);
           //$image = base64_encode($filePath);

//           $query = "INSERT INTO profilepic ('id','Pro Pic','extention') VALUES ('33','$filePath','$fileType')";
//
//           echo $query;
//
//           mysql_query($query) or die("Error, Query failed");



       }


        ?>

    </div>
   
    
</div>

</body>
</html>
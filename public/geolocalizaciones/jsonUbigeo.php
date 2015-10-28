<?php
include("includes/configure.php");
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
?>
<?php
$queEmp = "SELECT id,fullname,address,urbanization,district,region,ubigeo,codclient,latitude,longitude FROM stores s where ubigeo='". $_POST['ubigeo']."'; ";
$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);
$conatador=0;


$data = array();
                if ($totEmp> 0) {
                    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
                        //echo '<option value="'.  $rowEmp['ubigeo'] .'">' . $rowEmp['ubigeo'] . '</option>';
                        $data[]= array(
                            "id" => $rowEmp['id'],
                            "fullname" => $rowEmp['fullname'],
                            "address" => $rowEmp['address'],
                            "referencia" => $rowEmp['urbanization'],
                            "district" => $rowEmp['district'],
                            "provincia" => $rowEmp['region'],
                            "departamento" => $rowEmp['fullname'],
                            "codclient" => $rowEmp['ubigeo'],
                            "latitude" => $rowEmp['latitude'],
                            "longitud" => $rowEmp['longitude']

                        );
                    }
                }


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($data);

?>
<?php
error_reporting(E_ALL);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

date_default_timezone_set('America/Lima');

include("includes/configure.php");



if (PHP_SAPI == 'cli')

	die('This example should only be run from a Web Browser');



/** Include PHPExcel */

require_once dirname(__FILE__) . '/includes/Classes/PHPExcel.php';



if(isset($_GET['limite_inf'])) $limite_inf = $_GET['limite_inf'];

if(isset($_GET['id_company'])) $id_company = $_GET['id_company'];





$limite_inf = $limite_inf*50;



$poll_ids_sino_con_comentarios = array(1,4,5,20,41,44,45,60);

$poll_ids_sino_sin_comentarios = array(6,7,8,12,14,21,22,46,47,48,52,54,61,62,70);

$poll_ids_options = array(9,10,11,16,24,25,26,28,30,31,32,33,34,35,36,37,38,39,40,49,50,51,56,64,65,66,68);

$poll_ids_options_media = array(42,43,67);

$poll_ids_solo_comentarios = array(23,63);

$poll_ids_solo_limites = array(13,53);

$poll_ids_options_con_limites = array(17,18,19,57,58,59);

$poll_ids_sino_con_comentarios_media = array(3,27);

$poll_ids_sino_sin_comentarios_media = array(2,15,55);





$queEmp = "select a.id from polls a

left outer join company_audits b

on (a.company_audit_id = b.id)

where company_id = ". $id_company ."

order by id";



$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());

$totEmp = mysql_num_rows($resEmp);



$encuestas = array();



while ($rowEmp = mysql_fetch_assoc($resEmp)) {

	//echo '<b>' . $rowEmp['tienda'] . '</b><br>';



	$queEmp = "

		select sum(case when company_audit_id < (select company_audit_id from polls where id = ".  $rowEmp['id'] .") then max else 0 end ) 

		+ (select orden from polls where id = ".  $rowEmp['id'] .")

		orden from

		(

		select company_audit_id, max(orden) max

		from polls

		group by company_audit_id

		)a

		";



	$poll_id =  $rowEmp['id'];



	$resEmp_1 = mysql_query($queEmp, $conexion_db) or die(mysql_error());

	$rowEmp_1 = mysql_fetch_assoc($resEmp_1);



	$orden =  $rowEmp_1['orden'];





	$encuestas[$orden] = $poll_id;

}





ksort($encuestas);



$columna_inicial = 1;



//generar_hoja_excel(calcular_query_sino_sin_comment(27));





// Create new PHPExcel object

$objPHPExcel = new PHPExcel();

$objWorksheet = $objPHPExcel->getActiveSheet();



// Negrita con Fondo Gris



$style =  array(

	'font'    => array(

		'size' => '11',

		'color'     => array(

			'rgb' => '000000'

		)

	),

	'borders' => array(

		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array(

				'rgb' => '000000'

			)

		)

	),

	'fill' => array(

		'type' => PHPExcel_Style_Fill::FILL_SOLID,

		'startcolor' => array(

			'argb' => '7A8B8B',

		)

	)

);



// Negrita con Fondo Verde y Letra Blanca



$style_1 =  array(

	'font'    => array(

		'size' => '9',

		'bold'      => true,

		'color'     => array(

			'argb' => 'F5FFFA'

		)

	),

	'borders' => array(

		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array(

				'rgb' => '000000'

			)

		)

	),

	'fill' => array(

		'type' => PHPExcel_Style_Fill::FILL_SOLID,

		'startcolor' => array(

			'argb' => '00C957',

		)

	)

);



// Negrita con Letra Verde





$style_2 =  array(

	'font'    => array(

		'size' => '9',

		'bold'      => true,

		'color'     => array(

			'argb' => '00C957'

		)

	),

	'borders' => array(

		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array(

				'rgb' => '000000'

			)

		)

	)

);





// Letra Normal



$style_3 =  array(

	'font'    => array(

		'size' => '9'

	),

	'borders' => array(

		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array(

				'rgb' => '000000'

			)

		)

	)

);



// Negrita con Letra Negra



$style_4 =  array(

	'font'    => array(

		'size' => '9',

		'bold'      => true

	),

	'borders' => array(

		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array(

				'rgb' => '000000'

			)

		)

	)

);

$objPHPExcel->createSheet(NULL, 1);



$query_detalle_puntos = "select a.store_id, b.codclient, b.fullname,
														
														b.address , b.district,  latitude, longitude, ejecutivo, coordinador,
														
														DATE_FORMAT(a.updated_at, '%d/%m/%Y') fecha, 
														
														min(DATE_FORMAT(a.updated_at, '%H:%i:%s')) hora, e.fullname as auditor
														
														from poll_details a
														
														left outer join stores b
														
														on (a.store_id = b.id)
														
														left outer join road_details c
														
														on (c.store_id = b.id)
														
														left outer join roads d
														
														on (c.road_id = d.id)
														
														left outer join users e
														
														on (d.user_id = e.id)
														
														left outer join company_stores f
														
														on (a.store_id = f.store_id)
														
														where a.store_id in (select store_id from road_details where audit=1)
														
														and f.company_id = " . $id_company ."

														group by a.store_id, b.codclient, b.fullname, 
														
														b.address , b.district,  latitude, longitude, ejecutivo, coordinador,
														
														DATE_FORMAT(a.updated_at, '%d/%m/%Y'), e.fullname
														
														order by a.updated_at desc

														limit " . $limite_inf. ", 50";

$resEmp = mysql_query($query_detalle_puntos, $conexion_db) or die(mysql_error());

$total_comercios = mysql_num_rows($resEmp);

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', 'Store_id');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B3', 'PSE');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C3', 'Comercio');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D3', utf8_encode('Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E3', 'Distrito');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F3', 'Latitud');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G3', 'Longitud');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H3', 'Ejecutivo');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I3', 'Coordinador');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J3', 'Fecha');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K3', 'Hora');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L3', 'Auditor');



$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B2', '1. Nombre Agente');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C2', '1. Nombre Agente');

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I2', utf8_encode('2. Dirección'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J2', utf8_encode('3. Día de Visita'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K2', utf8_encode('3. Día de Visita'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L2', utf8_encode('3. Día de Visita'));



$objPHPExcel->setActiveSheetIndex(1)->mergeCells('B2:C2');

$objPHPExcel->setActiveSheetIndex(1)->mergeCells('D2:I2');

$objPHPExcel->setActiveSheetIndex(1)->mergeCells('J2:L2');



$objPHPExcel->setActiveSheetIndex(1)->getStyle('A2:L2')->applyFromArray($style);

$objPHPExcel->setActiveSheetIndex(1)->getStyle('A3:L3')->applyFromArray($style_1);



$contador_1 = 3;



while ($rowEmp = mysql_fetch_assoc($resEmp)) {

	$contador_1 ++;

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'. $contador_1, utf8_encode($rowEmp['store_id'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'. $contador_1, utf8_encode($rowEmp['codclient'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'. $contador_1, utf8_encode($rowEmp['fullname'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'. $contador_1, utf8_encode($rowEmp['address'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'. $contador_1, utf8_encode($rowEmp['district'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'. $contador_1, utf8_encode($rowEmp['latitude'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'. $contador_1, utf8_encode($rowEmp['longitude'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'. $contador_1, utf8_encode($rowEmp['ejecutivo'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'. $contador_1, utf8_encode($rowEmp['coordinador'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'. $contador_1, utf8_encode($rowEmp['fecha'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'. $contador_1, utf8_encode($rowEmp['hora'] ));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'. $contador_1, utf8_encode($rowEmp['auditor'] ));



	$objPHPExcel->setActiveSheetIndex(1)->getStyle('A'.$contador_1.':C'.$contador_1)->applyFromArray($style_2);

	$objPHPExcel->setActiveSheetIndex(1)->getStyle('D'.$contador_1.':L'.$contador_1)->applyFromArray($style_3);





	//$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'. $contador_1, '=IFERROR(VLOOKUP(A'.$contador_1.',raw!B:I,3,0),"""")'  );

}



$objPHPExcel->getActiveSheet()->setTitle('resumen');



// Set document properties

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")

	->setLastModifiedBy("Maarten Balliauw")

	->setTitle("REPORTE1")

	->setSubject("Office 2007 XLSX Test Document")

	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")

	->setKeywords("office 2007 openxml php")

	->setCategory("Test result file");



$j = 12;

$k = 2;



foreach ($encuestas as $key => $value) {





	$nro_pregunta = $key;

	$poll_id_temp1 = $encuestas[$key];



	if (in_array($poll_id_temp1, $poll_ids_options))

	{

		$columnas = calcular_query_opciones($poll_id_temp1);


	}elseif(in_array($poll_id_temp1, $poll_ids_options_media) )

	{

		$columnas = calcular_query_opciones_media($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_sino_sin_comentarios)) {



		$columnas = calcular_query_sino_sin_comment($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_sino_con_comentarios)){



		$columnas = calcular_query_sino_comment($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_solo_comentarios)){



		$columnas = calcular_query_solo_comentarios($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_solo_limites)){



		$columnas = calcular_query_limites($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_options_con_limites)) {



		$columnas = calcular_query_opciones_con_limites($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_sino_sin_comentarios_media)) {



		$columnas = calcular_query_sino_sin_comment_media($poll_id_temp1);



	}elseif(in_array($poll_id_temp1, $poll_ids_sino_con_comentarios_media)) {



		$columnas = calcular_query_sino_comment_media($poll_id_temp1);



	}


	$buscar_ini = 2*($k-1) + $j - 13 ;

	$temp_fila = 1 ;

	$iniciar_conbinacion = $j;

	foreach ($columnas as $key => $value) {

		if ($key >= 2) {



			$temp_fila++;



			$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates($j,3) , utf8_encode($columnas[$key])  );



			$objPHPExcel->setActiveSheetIndex(1)->getStyle(coordinates($j,3))->applyFromArray($style_1);



			$nombre_pregunta = encontrar_nombre_pregunta($poll_id_temp1);



			$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates($j,2), $nro_pregunta . '. ' . $nombre_pregunta);



			$objPHPExcel->setActiveSheetIndex(1)->getStyle(coordinates($j,2))->applyFromArray($style);







			for ($t=4; $t <= $total_comercios+3 ; $t++) {



				if (utf8_encode($columnas[$key]) == "Comentario" or utf8_encode($columnas[$key]) == "Opcion" or utf8_encode($columnas[$key]) == "Estandar") {



					$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates($j,$t) ,  '=IFERROR(IF(VALUE(IFERROR(VLOOKUP(A'. $t .',raw!'.coordinates($buscar_ini,1) .':'.

						coordinates($buscar_ini+$temp_fila, 100000) .','.$temp_fila.',0),""))=0,"","x"),IFERROR(VLOOKUP(A'. $t .',raw!'.coordinates($buscar_ini,1) .':'.

						coordinates($buscar_ini+$temp_fila, 100000) .','.$temp_fila.',0),""))');

				}elseif (   utf8_encode($columnas[$key]) == "Foto"         ) {



					$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates($j,$t)  , '=IF(IFERROR(VLOOKUP(A'. $t .',raw!'.coordinates($buscar_ini,1) .':'.

						coordinates($buscar_ini+$temp_fila, 100000) .','.$temp_fila.',0),0)=0, "" , HYPERLINK(VLOOKUP(A'. $t .',raw!'.coordinates($buscar_ini,1) .':'.

						coordinates($buscar_ini+$temp_fila, 100000) .','.$temp_fila.',0),"Foto") )');



				}else{





					$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates($j,$t) ,  '=IFERROR(IF(VLOOKUP(A'. $t .',raw!'.coordinates($buscar_ini,1) .':'.

						coordinates($buscar_ini+$temp_fila, 100000) .','.$temp_fila.',0)="0",0,2),"")');

				}







				$objPHPExcel->setActiveSheetIndex(1)->getStyle(coordinates($j,$t))->applyFromArray($style_3);

			}

			$j++;

		}



	}



	$objPHPExcel->setActiveSheetIndex(1)->mergeCells(coordinates($iniciar_conbinacion,2).':'.coordinates($j-1,2));



	$k++;





	$columna_inicial = generar_hoja_excel($columnas, $columna_inicial) + 1;



}







// Cambiamos el Nombre de la Hoja

$objPHPExcel->getActiveSheet()->setTitle('raw');

// Cambiar el índice hoja activa a la primera hoja, por lo que Excel abre esto como la primera hoja

$objPHPExcel->setActiveSheetIndex(1);



$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);





// Redirect output to a client’s web browser (Excel2007)

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//header('Content-Disposition: attachment;filename="01simple.xlsx"');

header('Content-Disposition: attachment;filename="REPORTE_FINAL.xlsx"');



header('Cache-Control: max-age=0');

// If you're serving to IE 9, then the following may be needed

header('Cache-Control: max-age=1');



// If you're serving to IE over SSL, then the following may be needed

header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified

header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

header ('Pragma: public'); // HTTP/1.0



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');

exit;









function encontrar_nombre_pregunta($poll_id){

	global $conexion_db;



	$queEmp = "select * from polls where id = " . $poll_id;

	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());



	while ($rowEmp = mysql_fetch_assoc($resEmp)) {



		$nombre = utf8_encode($rowEmp['question']);



	}







	return $nombre;

}





function generar_hoja_excel($columnas, $numero_columna){

	global $conexion_db, $objPHPExcel;



	$contcolum = 0;



	$queEmp = $columnas[0];

	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());

	$totEmp = mysql_num_rows($resEmp);



	$contcolum = $numero_columna;

	// Añadiendo Cabecera

	foreach ($columnas as $key => $value) {

		if ($key <> 0) {

			$objPHPExcel->setActiveSheetIndex(0)->getCell(coordinates($contcolum,2))->setValueExplicit(utf8_encode($columnas[$key]), PHPExcel_Cell_DataType::TYPE_STRING);

			$contcolum = $contcolum + 1;

		}

	}



	$contador = 2;



	while ($rowEmp = mysql_fetch_assoc($resEmp)) {

		$contcolum = $numero_columna;

		$contador ++;



		foreach ($columnas as $key => $value) {

			if ($key <> 0) {



				if ($key == 1) {

					$objPHPExcel->setActiveSheetIndex(0)->setCellValue(coordinates($contcolum,$contador), $rowEmp[$columnas[$key]] );

				}else{

					$objPHPExcel->setActiveSheetIndex(0)->getCell(coordinates($contcolum,$contador))->setValueExplicit(utf8_encode($rowEmp[$columnas[$key]]), PHPExcel_Cell_DataType::TYPE_STRING);

				}



				$contcolum = $contcolum + 1;

			}

		}

	}



	$columna_final = $contcolum;



	return $columna_final;

}





function coordinates($x,$y){

	return PHPExcel_Cell::stringFromColumnIndex($x).$y;

}





function calcular_query_opciones($poll_id){

	global $conexion_db;

	$i = 2;

	$columnas = array();



	$query = "select store_id  ";

	$opciones = "";

	$columnas[1] = "store_id";



	$queEmp = "select codigo, options  from poll_options where poll_id = " . $poll_id  ;

	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());

	$totEmp = mysql_num_rows($resEmp);



	while ($rowEmp = mysql_fetch_assoc($resEmp)) {

		$columnas[$i] = $rowEmp['options'];

		$opciones =  $opciones . ", sum(case when options = '". $rowEmp['codigo'] . "' then 1 else 0 end) '" . $rowEmp['options'] . "'";

		$i = $i + 1;

	}



	$query = $query .  $opciones . " from

							(SELECT a.store_id,

							d.fullname AS store_name,

							f.result,

							f.otro, 

							a.comentario,

							e.codigo AS options

							FROM

							poll_details a

							left outer join polls b on (a.poll_id = b.id)

							left outer join company_audits c on (c.id = b.company_audit_id)

							left outer join stores d on (a.store_id = d.id)

							left outer join poll_options e on (e.poll_id = b.id)

							inner join poll_option_details f on (f.poll_option_id = e.id and a.created_at = f.created_at) 

							left outer join audits g on (g.id = c.audit_id)

							where a.poll_id = " . $poll_id . " 

							)x

							group by store_id";

	$columnas[0] = $query;



	return $columnas;

}





function calcular_query_opciones_con_limites($poll_id){

	global $conexion_db;

	$i = 2;

	$columnas = array();



	$query = "select store_id  ";

	$opciones = "";

	$columnas[1] = "store_id";



	$queEmp = "select codigo, options  from poll_options where poll_id = " . $poll_id  ;

	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());

	$totEmp = mysql_num_rows($resEmp);



	while ($rowEmp = mysql_fetch_assoc($resEmp)) {

		$columnas[$i] = $rowEmp['options'];

		$opciones =  $opciones . ", sum(case when options = '". $rowEmp['codigo'] . "' then 1 else 0 end) '" . $rowEmp['options'] . "'";

		$i = $i + 1;

	}



	$query = $query .  $opciones . " , limite as Estandar from

							(SELECT a.store_id,

							d.fullname AS store_name,

							f.result,

							f.otro, 

							a.limite,

							e.codigo AS options

							FROM

							poll_details a

							left outer join polls b on (a.poll_id = b.id)

							left outer join company_audits c on (c.id = b.company_audit_id)

							left outer join stores d on (a.store_id = d.id)

							left outer join poll_options e on (e.poll_id = b.id)

							inner join poll_option_details f on (f.poll_option_id = e.id and a.created_at = f.created_at) 

							left outer join audits g on (g.id = c.audit_id)

							where a.poll_id = " . $poll_id . " 

							)x

							group by store_id, limite";



	$columnas[0] = $query;

	$columnas[$i] = "Estandar";



	return $columnas;

}



function calcular_query_opciones_media($poll_id){

	global $conexion_db;

	$opciones = "";

	$i = 3;
	
	$query = "select x.store_id, x.result as Respuesta" ;
	
	$columnas = array();


	
	
	$columnas[1] = "store_id";

	$columnas[2] = "Respuesta";


	$queEmp = "select codigo, options  from poll_options where poll_id = " . $poll_id  ;

	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());

	$totEmp = mysql_num_rows($resEmp);

	while ($rowEmp = mysql_fetch_assoc($resEmp)) {

		$columnas[$i] = $rowEmp['options'];
		
		$query = $query . ", case when  `" .  $rowEmp['options'] . "` is null then 0 else `" .  $rowEmp['options'] . "` end as '" .  $rowEmp['options'] . "' " ;

		$opciones =  $opciones . ", sum(case when options = '". $rowEmp['codigo'] . "' then 1 else 0 end) '" . $rowEmp['options'] . "'";

		$i = $i + 1;
	}

	$query = $query . ",  CONCAT('http://ttaudit.com/media/fotos/' , archivo) as Foto ";

	$query = $query . "

	from poll_details x
	
	left outer join (

		select store_id  ";
	
	$query = $query .  $opciones . " from

							(SELECT a.store_id,

							e.codigo AS options
							
							FROM
							
							poll_details a
							
							left outer join polls b on (a.poll_id = b.id)
							
							left outer join company_audits c on (c.id = b.company_audit_id)
							
							left outer join stores d on (a.store_id = d.id)
							
							left outer join poll_options e on (e.poll_id = b.id)
							
							inner join poll_option_details f on (f.poll_option_id = e.id and a.store_id = f.store_id) 
							
							left outer join audits g on (g.id = c.audit_id)
							
							LEFT OUTER JOIN medias h ON ( a.poll_id = h.poll_id AND a.store_id = h.store_id ) 
							
							where a.poll_id = " . $poll_id . " 
							
							)x
							
							group by store_id ) y
							
							on (y.store_id = x.store_id)
							
							left outer join medias z
							
							on (x.poll_id = z.poll_id and x.store_id = z.store_id)
							
							where x.poll_id = " . $poll_id ;


	$columnas[$i] = "Foto";

	$columnas[0] = $query;

	return $columnas;

}




function calcular_query_sino_sin_comment($poll_id){

	$columnas = array();



	$query = "select 

						a.store_id,

						a.result as Respuesta

						FROM

						poll_details a

						left outer join polls b on (a.poll_id = b.id)

						left outer join company_audits c on (c.id = b.company_audit_id)

						left outer join stores d on (a.store_id = d.id)

						left outer join audits g on (g.id = c.audit_id)

						where a.poll_id = " . $poll_id ;





	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Respuesta";



	return $columnas;

}



function calcular_query_sino_comment($poll_id){



	$columnas = array();





	$query = "select  

						a.store_id,

						a.result as Respuesta,

						a.comentario as Comentario

						FROM

						poll_details a

						left outer join polls b on (a.poll_id = b.id)

						left outer join company_audits c on (c.id = b.company_audit_id)

						left outer join stores d on (a.store_id = d.id)

						left outer join audits g on (g.id = c.audit_id)

						where a.poll_id = " . $poll_id ;







	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Respuesta";

	$columnas[3] = "Comentario";





	return $columnas;

}





function calcular_query_solo_comentarios($poll_id){



	$columnas = array();

	$query = "select store_id, comentario as Comentario

						from poll_details a

						left outer join polls b on (a.poll_id = b.id)  

						left outer join company_audits c on (c.id = b.company_audit_id) 

						left outer join stores d on (a.store_id = d.id) 

						left outer join audits g on (g.id = c.audit_id)

						where poll_id = " . $poll_id . "

						group by store_id, comentario

						";





	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Comentario";



	return $columnas;

}





function calcular_query_sino_sin_comment_media($poll_id){

	$columnas = array();



	$query = "select 

	a.store_id,

	a.result as Respuesta,

	CONCAT('http://ttaudit.com/media/fotos/' , archivo) as Foto

	FROM

	poll_details a

	left outer join polls b on (a.poll_id = b.id)

	left outer join company_audits c on (c.id = b.company_audit_id)

	left outer join stores d on (a.store_id = d.id)

	left outer join audits g on (g.id = c.audit_id)

	left outer join medias h on (a.poll_id = h.poll_id and a.store_id = h.store_id)

	where a.poll_id = " . $poll_id  ;





	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Respuesta";

	$columnas[3] = "Foto";



	return $columnas;

}



function calcular_query_sino_comment_media($poll_id){



	$columnas = array();



	$query = "select 

	a.store_id,

	a.result as Respuesta,

	comentario as Comentario,

	CONCAT('http://ttaudit.com/media/fotos/' , archivo) as Foto

	FROM

	poll_details a

	left outer join polls b on (a.poll_id = b.id)

	left outer join company_audits c on (c.id = b.company_audit_id)

	left outer join stores d on (a.store_id = d.id)

	left outer join audits g on (g.id = c.audit_id)

	left outer join medias h on (a.poll_id = h.poll_id and a.store_id = h.store_id)

	where a.poll_id = " . $poll_id ;



	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Respuesta";

	$columnas[3] = "Comentario";

	$columnas[4] = "Foto";



	return $columnas;

}









function calcular_query_limites($poll_id){



	$columnas = array();



	$query = "select 

	distinct

	a.store_id,

	rtrim(substring(a.limite,position('|' in a.limite)+1, length(a.limite))) as Opcion

	FROM

	poll_details a

	left outer join polls b on (a.poll_id = b.id)

	left outer join company_audits c on (c.id = b.company_audit_id)

	left outer join stores d on (a.store_id = d.id)

	left outer join audits g on (g.id = c.audit_id)

	where a.poll_id = " . $poll_id;



	$columnas[0] = $query;

	$columnas[1] = "store_id";

	$columnas[2] = "Opcion";



	return $columnas;

}

?>
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

/* Ejecuta el Store Procedure que tiene el resumen del reporte */
//mysql_query("call sp_reporte_company_8", $conexion_db) or die(mysql_error());

$query_detalle_puntos = "call sp_consulta_reporte_dia_company_8";
$resEmp = mysql_query($query_detalle_puntos, $conexion_db) or die(mysql_error());
$total_comercios = mysql_num_rows($resEmp);

/* Definen la Cabecera */
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
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B2', 'Nombre Agente');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D2', utf8_encode('Dirección'));
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J2', utf8_encode('Día de Visita'));

$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(12 , 2), utf8_encode('1. Indicar Rubro (id = 66)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(18 , 2), utf8_encode('2. ¿Se encuentra abierto el agente? (id = 67)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(23 , 2), utf8_encode('3. Al llegar al establecimiento el cliente incógnito deberá preguntar directamente por el agente de Interbank. Ejemplo: Buenos días/tardes, ¿hay agente de Interbank aquí? (id = 41)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(25 , 2), utf8_encode('4. ¿El letrero de IBK Agente era visible desde fuera? (id = 42)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(32 , 2), utf8_encode('5. ¿El Interbank Agente es visible estando dentro del establecimiento? (id = 43)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(37 , 2), utf8_encode('6. ¿Existe algún otro Agente / corresponsal bancario? (id = 44)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(39 , 2), utf8_encode('7. El CI deberá preguntar, ¿Puedo pagar una tarjeta de crédito de Interbank acá? (id = 45)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(41 , 2), utf8_encode('8. En el caso de que exista más de un agente en el comercio, preguntar, ¿acá puedo pagar mi teléfono? (id = 46)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(42 , 2), utf8_encode('9. Si responde que si en la P8, preguntar ¿Y en cuál agente me conviene pagar mi teléfono? (id = 64)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(46 , 2), utf8_encode('10. Si me envían dinero del exterior ¿Lo puedo cobrar acá? (id = 69)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(47 , 2), utf8_encode('11. Escoger tipo de Transacción (id = 68)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(51 , 2), utf8_encode('12. Al preguntar si se podía hacer la operación correspondiente, ¿el dependiente aceptó realizar la operación? (id = 47)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(52 , 2), utf8_encode('13. ¿Su solicitud fue atendido de inmediato? (id = 48)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(53 , 2), utf8_encode('14. Su solicitud no fue atendida de inmediato porque (id = 49)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(56 , 2), utf8_encode('15. Mientras esperaba. ¿La persona que lo atendió se preocupó por su tiempo? (id = 50)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(59 , 2), utf8_encode('16. Después de esperar (id = 51)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(61 , 2), utf8_encode('17. ¿La transacción se llegó a realizar de manera exitosa? (Se considera exitosa cuando se entrega el voucher) (id = 52)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(62 , 2), utf8_encode('18. ¿El agente hizo algún cobro fuera del voucher? (id = 70)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(63 , 2), utf8_encode('19. ¿Cuántos MINUTOS transcurrieron entre que solicitó la transacción y la persona terminó (le entregá el voucher)? (id = 53)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(64 , 2), utf8_encode('20. ¿La persona que lo atendió tuvo que solicitar ayuda de alguna otra persona o hacer alguna consulta al respecto? (id = 54)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(65 , 2), utf8_encode('21. ¿Le entregaron ESPONTÁNEAMENTE un comprobante luego de la transacción? (Si no le entregaron espontáneamente el voucher deben solicitarlo y adjuntarlo al formulario) (id = 55)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(67 , 2), utf8_encode('22. (SÓLO SI NO SE REALIZÓ LA TRANSACCIÓN) ¿Por qué no se pudo realizar la transacción? (id = 56)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(73 , 2), utf8_encode('23. (SÓLO SI NO SE REALIZÓ LA TRANSACCIÓN) ¿Le dieron alguna solución para poder realizar la transacción? (id = 65)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(77 , 2), utf8_encode('24. En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías la amabilidad de la persona que te atendió? (id = 57)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(85 , 2), utf8_encode('25. En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías el conocimiento de la persona que lo atendió? (id = 58)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(90 , 2), utf8_encode('26. En una escala del 0 al 3 donde 0 significa Debajo del estándar, 2 Estándar y 3 Superior, ¿cómo calificarías la disposición de la persona que lo atendió? (id = 59)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(94 , 2), utf8_encode('27. El CI deberá mostrar interés: Voy a abrir un negocio, ¿usted me recomendaría tener un agente Interbank? (id = 60)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(96 , 2), utf8_encode('28. ¿Sabe si tienen alguna página web para conseguir información (id = 61)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(97 , 2), utf8_encode('29. ¿La persona encargada le proporcionó dicha información (id = 62)') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(98 , 2), utf8_encode('30. Otras apreciaciones a comentar (id = 63)') );

$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(12 , 3), utf8_encode('Bodega') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(13 , 3), utf8_encode('Farmacia') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(14 , 3), utf8_encode('Locutorio') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(15 , 3), utf8_encode('Librerias') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(16 , 3), utf8_encode('Tiendas Com') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(17 , 3), utf8_encode('Otro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(18 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(19 , 3), utf8_encode('Local Cerrado') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(20 , 3), utf8_encode('Ya no es Agente') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(21 , 3), utf8_encode('Existe señalización pero pidio retiro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(22 , 3), utf8_encode('Foto') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(23 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(24 , 3), utf8_encode('Comentario') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(25 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(26 , 3), utf8_encode('Letrero de metal o madera') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(27 , 3), utf8_encode('Rompe tráfico') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(28 , 3), utf8_encode('Letrero luminoso') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(29 , 3), utf8_encode('Letrero luminoso Bandera') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(30 , 3), utf8_encode('Letrero compartido') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(31 , 3), utf8_encode('Foto') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(32 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(33 , 3), utf8_encode('Colgante') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(34 , 3), utf8_encode('Mostrador') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(35 , 3), utf8_encode('Banner') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(36 , 3), utf8_encode('Foto') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(37 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(38 , 3), utf8_encode('Comentario') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(39 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(40 , 3), utf8_encode('Comentario') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(41 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(42 , 3), utf8_encode('Interbank') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(43 , 3), utf8_encode('Otro Agente') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(44 , 3), utf8_encode('En cualquiera/En el que usted decida/En los dos') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(45 , 3), utf8_encode('No Precisa') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(46 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(47 , 3), utf8_encode('Pago de TC') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(48 , 3), utf8_encode('Retiro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(49 , 3), utf8_encode('Deposito') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(50 , 3), utf8_encode('Pago de Servicios') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(51 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(52 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(53 , 3), utf8_encode('El encargado estaba ocupado	') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(54 , 3), utf8_encode('Porque me indicó que no había sistema') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(55 , 3), utf8_encode('Otro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(56 , 3), utf8_encode('Pidiéndole que por favor espere mientras terminaba de atender a otro cliente') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(57 , 3), utf8_encode('Preguntándole desde que llegá, qué operación iba a realizar, para saber cómo atenderlo cuando se desocupe') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(58 , 3), utf8_encode('Otro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(59 , 3), utf8_encode('Me atendieron ') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(60 , 3), utf8_encode('No me atendieron') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(61 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(62 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(63 , 3), utf8_encode('Opcion') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(64 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(65 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(66 , 3), utf8_encode('Foto') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(67 , 3), utf8_encode('No había sistema') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(68 , 3), utf8_encode('La línea estaba copada para el depósito') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(69 , 3), utf8_encode('La persona que atiende (operador) no estaba disponible') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(70 , 3), utf8_encode('POS no operativo') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(71 , 3), utf8_encode('No había efectivo disponible para el retiro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(72 , 3), utf8_encode('Otro') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(73 , 3), utf8_encode('Le pidió regrese más tarde') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(74 , 3), utf8_encode('Lo guio hacia otro Agente') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(75 , 3), utf8_encode('Le dijo como llegar a alguna Tienda Interbank') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(76 , 3), utf8_encode('Otros Indicar Cual') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(77 , 3), utf8_encode('Saluda ') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(78 , 3), utf8_encode('Usa el por favor') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(79 , 3), utf8_encode('Da las gracias') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(80 , 3), utf8_encode('Sonríe') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(81 , 3), utf8_encode('Mira a los ojos') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(82 , 3), utf8_encode('No interrumpe') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(83 , 3), utf8_encode('Despedida') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(84 , 3), utf8_encode('Estandar') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(85 , 3), utf8_encode('Conoce las operaciones que se puede realizar en agente ') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(86 , 3), utf8_encode('Sabe cómo operar el pos al realizar la operación') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(87 , 3), utf8_encode('No solicita ayuda para realizar la operación') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(88 , 3), utf8_encode('Conoce la página web para conseguir información') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(89 , 3), utf8_encode('Estandar') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(90 , 3), utf8_encode('Pendiente de  usted durante la atención') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(91 , 3), utf8_encode('Concentrado en la operación mientras atendía ') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(92 , 3), utf8_encode('Le ofreció un producto o servicio adicional') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(93 , 3), utf8_encode('Estandar') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(94 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(95 , 3), utf8_encode('Comentario') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(96 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(97 , 3), utf8_encode('Respuesta') );
$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(98 , 3), utf8_encode('Comentario') );

/* Une las Celdas para la cabecera */
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('B2:C2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('D2:I2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('J2:L2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('M2:R2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('S2:W2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('X2:Y2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('Z2:AF2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AG2:AK2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AL2:AM2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AN2:AO2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AP2:AP2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AQ2:AT2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AU2:AU2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AV2:AY2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('AZ2:AZ2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BA2:BA2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BB2:BD2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BE2:BG2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BH2:BI2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BJ2:BJ2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BK2:BK2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BL2:BL2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BM2:BM2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BN2:BO2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BP2:BU2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BV2:BY2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('BZ2:CG2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CH2:CL2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CM2:CP2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CQ2:CR2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CS2:CS2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CT2:CT2');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('CU2:CU2');


/* Aplica estilo a las cabeceras */
$objPHPExcel->setActiveSheetIndex(1)->getStyle('B2:CU2')->applyFromArray($style);
$objPHPExcel->setActiveSheetIndex(1)->getStyle('B3:CU3')->applyFromArray($style_1);


/* Define el Ancho de las Celdas */
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);




$contador_1 = 3;


/* Llenamos el detalle del reporte */
while ($rowEmp = mysql_fetch_assoc($resEmp)) {

	$contador_1 ++;
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(1 , $contador_1), utf8_encode($rowEmp['codclient'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(2 , $contador_1), utf8_encode($rowEmp['fullname'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(3 , $contador_1), utf8_encode($rowEmp['address'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(4 , $contador_1), utf8_encode($rowEmp['district'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(5 , $contador_1), utf8_encode($rowEmp['latitude'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(6 , $contador_1), utf8_encode($rowEmp['longitude'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(7 , $contador_1), utf8_encode($rowEmp['ejecutivo'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(8 , $contador_1), utf8_encode($rowEmp['coordinador'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(9 , $contador_1), utf8_encode($rowEmp['fecha'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(10 , $contador_1), utf8_encode($rowEmp['hora'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(11 , $contador_1), utf8_encode($rowEmp['auditor'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(12 , $contador_1), utf8_encode($rowEmp['66_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(13 , $contador_1), utf8_encode($rowEmp['66_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(14 , $contador_1), utf8_encode($rowEmp['66_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(15 , $contador_1), utf8_encode($rowEmp['66_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(16 , $contador_1), utf8_encode($rowEmp['66_e'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(17 , $contador_1), utf8_encode($rowEmp['66_f'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(18 , $contador_1), utf8_encode($rowEmp['67_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(19 , $contador_1), utf8_encode($rowEmp['67_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(20 , $contador_1), utf8_encode($rowEmp['67_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(21 , $contador_1), utf8_encode($rowEmp['67_c'] ));

	if (utf8_encode($rowEmp['67_Foto']) == null || utf8_encode($rowEmp['67_Foto']) == "") {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(22 , $contador_1), '' );
	} else {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(22 , $contador_1), '=HYPERLINK( "'. utf8_encode($rowEmp['67_Foto']) .'"  , "Foto" )' );
	}
	//$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(22 , $contador_1), '=HYPERLINK( "'. utf8_encode($rowEmp['67_Foto']) .'"  , "Foto" )' );
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(23 , $contador_1), utf8_encode($rowEmp['41_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(24 , $contador_1), utf8_encode($rowEmp['41_Comentario'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(25 , $contador_1), utf8_encode($rowEmp['42_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(26 , $contador_1), utf8_encode($rowEmp['42_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(27 , $contador_1), utf8_encode($rowEmp['42_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(28 , $contador_1), utf8_encode($rowEmp['42_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(29 , $contador_1), utf8_encode($rowEmp['42_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(30 , $contador_1), utf8_encode($rowEmp['42_e'] ));

	if (utf8_encode($rowEmp['42_Foto']) == null || utf8_encode($rowEmp['42_Foto']) == "") {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(31 , $contador_1), '' );
	} else {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(31 , $contador_1), '=HYPERLINK( "'. utf8_encode($rowEmp['42_Foto']) .'"  , "Foto" )' );
	}
	
	//$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(31 , $contador_1), utf8_encode($rowEmp['42_Foto'] ));
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(32 , $contador_1), utf8_encode($rowEmp['43_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(33 , $contador_1), utf8_encode($rowEmp['43_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(34 , $contador_1), utf8_encode($rowEmp['43_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(35 , $contador_1), utf8_encode($rowEmp['43_c'] ));

	if (utf8_encode($rowEmp['43_Foto']) == null || utf8_encode($rowEmp['43_Foto']) == "") {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(36 , $contador_1), '' );
	} else {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(36 , $contador_1), '=HYPERLINK( "'. utf8_encode($rowEmp['43_Foto']) .'"  , "Foto" )' );
	}
	
	//$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(36 , $contador_1), utf8_encode($rowEmp['43_Foto'] ));
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(37 , $contador_1), utf8_encode($rowEmp['44_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(38 , $contador_1), utf8_encode($rowEmp['44_comentario'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(39 , $contador_1), utf8_encode($rowEmp['45_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(40 , $contador_1), utf8_encode($rowEmp['45_comentario'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(41 , $contador_1), utf8_encode($rowEmp['46_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(42 , $contador_1), utf8_encode($rowEmp['64_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(43 , $contador_1), utf8_encode($rowEmp['64_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(44 , $contador_1), utf8_encode($rowEmp['64_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(45 , $contador_1), utf8_encode($rowEmp['64_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(46 , $contador_1), utf8_encode($rowEmp['69_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(47 , $contador_1), utf8_encode($rowEmp['68_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(48 , $contador_1), utf8_encode($rowEmp['68_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(49 , $contador_1), utf8_encode($rowEmp['68_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(50 , $contador_1), utf8_encode($rowEmp['68_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(51 , $contador_1), utf8_encode($rowEmp['47_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(52 , $contador_1), utf8_encode($rowEmp['48_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(53 , $contador_1), utf8_encode($rowEmp['49_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(54 , $contador_1), utf8_encode($rowEmp['49_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(55 , $contador_1), utf8_encode($rowEmp['49_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(56 , $contador_1), utf8_encode($rowEmp['50_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(57 , $contador_1), utf8_encode($rowEmp['50_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(58 , $contador_1), utf8_encode($rowEmp['50_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(59 , $contador_1), utf8_encode($rowEmp['51_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(60 , $contador_1), utf8_encode($rowEmp['51_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(61 , $contador_1), utf8_encode($rowEmp['52_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(62 , $contador_1), utf8_encode($rowEmp['70_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(63 , $contador_1), utf8_encode($rowEmp['53_Opcion'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(64 , $contador_1), utf8_encode($rowEmp['54_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(65 , $contador_1), utf8_encode($rowEmp['55_Respuesta'] ));
	
	if (utf8_encode($rowEmp['55_Foto']) == null || utf8_encode($rowEmp['55_Foto']) == "") {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(66 , $contador_1), '' );
	} else {
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(66 , $contador_1), '=HYPERLINK( "'. utf8_encode($rowEmp['55_Foto']) .'"  , "Foto" )' );
	}

	//$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(66 , $contador_1), utf8_encode($rowEmp['55_Foto'] ));
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(67 , $contador_1), utf8_encode($rowEmp['56_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(68 , $contador_1), utf8_encode($rowEmp['56_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(69 , $contador_1), utf8_encode($rowEmp['56_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(70 , $contador_1), utf8_encode($rowEmp['56_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(71 , $contador_1), utf8_encode($rowEmp['56_e'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(72 , $contador_1), utf8_encode($rowEmp['56_f'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(73 , $contador_1), utf8_encode($rowEmp['65_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(74 , $contador_1), utf8_encode($rowEmp['65_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(75 , $contador_1), utf8_encode($rowEmp['65_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(76 , $contador_1), utf8_encode($rowEmp['65_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(77 , $contador_1), utf8_encode($rowEmp['57_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(78 , $contador_1), utf8_encode($rowEmp['57_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(79 , $contador_1), utf8_encode($rowEmp['57_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(80 , $contador_1), utf8_encode($rowEmp['57_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(81 , $contador_1), utf8_encode($rowEmp['57_e'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(82 , $contador_1), utf8_encode($rowEmp['57_f'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(83 , $contador_1), utf8_encode($rowEmp['57_g'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(84 , $contador_1), utf8_encode($rowEmp['57_Opcion'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(85 , $contador_1), utf8_encode($rowEmp['58_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(86 , $contador_1), utf8_encode($rowEmp['58_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(87 , $contador_1), utf8_encode($rowEmp['58_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(88 , $contador_1), utf8_encode($rowEmp['58_d'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(89 , $contador_1), utf8_encode($rowEmp['58_Opcion'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(90 , $contador_1), utf8_encode($rowEmp['59_a'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(91 , $contador_1), utf8_encode($rowEmp['59_b'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(92 , $contador_1), utf8_encode($rowEmp['59_c'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(93 , $contador_1), utf8_encode($rowEmp['59_Opcion'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(94 , $contador_1), utf8_encode($rowEmp['60_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(95 , $contador_1), utf8_encode($rowEmp['60_comentario'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(96 , $contador_1), utf8_encode($rowEmp['61_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(97 , $contador_1), utf8_encode($rowEmp['62_Respuesta'] ));
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue(coordinates(98 , $contador_1), utf8_encode($rowEmp['63_comentario'] ));

	$objPHPExcel->setActiveSheetIndex(1)->getStyle('B'.$contador_1.':C'.$contador_1)->applyFromArray($style_2);
	$objPHPExcel->setActiveSheetIndex(1)->getStyle('D'.$contador_1.':CU'.$contador_1)->applyFromArray($style_3);
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


function coordinates($x,$y){
	return PHPExcel_Cell::stringFromColumnIndex($x).$y;
}


?>
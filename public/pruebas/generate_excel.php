<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Lima');
include("includes/configure.php");

//Recibiendo datos por la url
if(isset($_GET['polls_id'])) $polls_id =$_GET['polls_id'];


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/includes/Classes/PHPExcel.php';

	//DEFINIENDO VARIABLES
	$conatador=4;  //INTEGER CONTADOR PARA CELDAS
	$question; //STRING PREGUNTA
	$audit_name; // STRING AUDITORIA
	$store_name;
	$colorBorde = "FF000000";


$poll_ids_sino = array(1,2,3,4,5,6,7,8,12,14,15,20,21,22,27);
$poll_ids_options_no_limit = array(9,10,11,16,24,25,26,28);


if (in_array($polls_id, $poll_ids_sino)) {
	// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    $objWorksheet = $objPHPExcel->getActiveSheet();

	// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("REPORTE1")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

    //Creand VARIABLE PARA márgenes a la celda
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );

	// Añadiendo data
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A4', 'TIENDA')
        ->setCellValue('B4', 'RESPUESTA');

    // DEFINE COLOR DE TEXTO
    $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    //CreandO COLOR DE FONDO A LAS CELDAS
    $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFill()->getStartColor()->setARGB('2080D0');
	//Estableciendo formato
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);

	$queEmp = "SELECT g.id AS Audit_id,
				g.fullname AS audit_name,
				d.fullname AS store_name,
				b.id AS Polls_id,
				b.question,
				a.comentario,
				h.archivo,
				a.media,
				a.options ,
				a.coment,
				a.result,
				e.codigo,
				d.id,
				e.options AS type_options,
				a.limite
				FROM
				poll_details a
				left outer join polls b on (a.poll_id = b.id)
				left outer join company_audits c on (c.id = b.company_audit_id)
				left outer join stores d on (a.store_id = d.id)
				left outer join poll_options e on (e.poll_id = b.id)
				left outer join poll_option_details f on (f.poll_option_id = e.id and d.id = f.store_id) 
				left outer join audits g on (g.id = c.audit_id)
				left outer join medias h on (h.store_id = d.id and h.poll_id = a.poll_id)
				where a.poll_id = " . $polls_id;


	$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
    $totEmp = mysql_num_rows($resEmp);

    
    //recorriendo datos para añadir a la hoja de calculo
	if ($totEmp> 0) {
		$flg_coment = 0 ;
		$flg_media = 0 ;

 		
	    while ($rowEmp = mysql_fetch_assoc($resEmp)) {
	        //echo '<b>' . $rowEmp['tienda'] . '</b><br>';
	        $conatador ++;
	        if($rowEmp['result']==1){
	            $valor = "SI";
	        }else if($rowEmp['result']==0){
	            $valor = "NO";
	        } else{
	            $valor = "";
	        }

		if ($polls_id == 1) {
	        	$question= utf8_encode("¿Hay Agente Interbank Aqui?");
	        }else{
	        	$question= utf8_encode($rowEmp['question']);
	        }

	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$conatador, utf8_encode($rowEmp['store_name']) )
	            ->setCellValue('B'.$conatador, $valor ) ;

	        if ($rowEmp['coment'] == '1') {

	        	if ($flg_coment == 0) {      	

				    $objPHPExcel->setActiveSheetIndex(0)
				        ->setCellValue('C4', 'COMENTARIO');
	    			
				    $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	    			$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				    $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->getStartColor()->setARGB('2080D0');
				    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				    $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);

				    $flg_coment = 1;
	        	}
	        	

	        	$objPHPExcel->setActiveSheetIndex(0)
	            	->setCellValue('C'.$conatador, utf8_encode($rowEmp['comentario']) ) ;
	        	$objPHPExcel->getActiveSheet()->getStyle('C'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
	        }


	        if ($rowEmp['media'] == '1') {

	        	if ($flg_media == 0) {      
	        		if ($flg_coment == 0) {
			        		$objPHPExcel->setActiveSheetIndex(0)
						        ->setCellValue('C4', 'MEDIA');
			    			
						    $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			    			$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						    $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->getStartColor()->setARGB('2080D0');
						    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
						    $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
	        			}					   

				    $flg_media = 1;
				}

				if ($flg_coment == 0) {


	        		$objPHPExcel->setActiveSheetIndex(0)
				        ->setCellValue('C'.$conatador, 'Ver Foto');

		        	$objPHPExcel->setActiveSheetIndex(0)
		        		->getCell('C'.$conatador)->getHyperlink()->setUrl('http://www.ttaudit.com/media/fotos/'.utf8_encode($rowEmp['archivo']) );
		        	$objPHPExcel->getActiveSheet()->getStyle('C'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
				}else{

	        		$objPHPExcel->setActiveSheetIndex(0)
				        ->setCellValue('D'.$conatador, 'Ver Foto');
					$objPHPExcel->setActiveSheetIndex(0)
		        		->getCell('D'.$conatador)->getHyperlink()->setUrl('http://www.ttaudit.com/media/fotos/'.utf8_encode($rowEmp['archivo']) );

		        	$objPHPExcel->getActiveSheet()->getStyle('D'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
				}
	        }


	        $audit_name = utf8_encode($rowEmp['audit_name']);

	        //APLICANDO BORDE A LAS CELDAS
	        $objPHPExcel->getActiveSheet()->getStyle('A'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
	        $objPHPExcel->getActiveSheet()->getStyle('B'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
	    



	    }
		
	    $objPHPExcel->getActiveSheet()->getCell('A1')->setValueExplicit($question, PHPExcel_Cell_DataType::TYPE_STRING);


	    //  hoja de calculo CREANDO RESUMEN DE DATOS
	    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'RESUMEN')
	        ->setCellValue('G4', 'SI')
	        ->setCellValue('G5', 'NO')
	        ->setCellValue('H4', '=COUNTIF(B5:B'.$conatador.',"SI")')
	        ->setCellValue('H5', '=COUNTIF(B5:B'.$conatador.',"NO")');

	    //ejecuta la funcion ("Como un refresco para la celda")
	    $objPHPExcel->getActiveSheet()->getCell('H4')->getCalculatedValue();
	    $objPHPExcel->getActiveSheet()->getCell('H5')->getCalculatedValue();
	    // DEFINE COLOR DE TEXTO
	    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	    //CreandO COLOR DE FONDO A LAS CELDAS
	    $objPHPExcel->getActiveSheet()->getStyle('G3:H3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $objPHPExcel->getActiveSheet()->getStyle('G3:H3')->getFill()->getStartColor()->setARGB('2080D0');


	    //APLICANDO BORDE A LAS CELDAS
	    $objPHPExcel->getActiveSheet()->getStyle('G4:H5')->applyFromArray($styleThinBlackBorderOutline);

	    $dataSeriesLabels = array(
	        new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$G$3', NULL, 1),	//	2010
	    );
	    //GENERANDO GRÁFICO
	    $xAxisTickValues = array(
	        new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$G$4:$G$5', NULL, 2),	//	Q1 to Q4
	    );

	    $dataSeriesValues = array(
	        new PHPExcel_Chart_DataSeriesValues('Number', 'REPORTE1!$H$4:$H$5', NULL, 2),
	    );
	    //	Build the dataseries
	    $series = new PHPExcel_Chart_DataSeries(
	        PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	        PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
	        range(0, count($dataSeriesValues)-1),			// plotOrder
	        $dataSeriesLabels,								// plotLabel
	        $xAxisTickValues,								// plotCategory
	        $dataSeriesValues								// plotValues
	    );

	    //	Set additional dataseries parameters
	    //		Make it a horizontal bar rather than a vertical column graph
	    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);

	    //	Set the series in the plot area
	    $plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series));
	    //	Set the chart legend
	    //$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);
	    $title = new PHPExcel_Chart_Title($question);
	    $yAxisLabel = new PHPExcel_Chart_Title('Valores');
	    //	Create the chart
	    $chart = new PHPExcel_Chart(
	        'chart1',		// name
	        $title,			// title
	        $legend,		// legend
	        $plotArea,		// plotArea
	        true,			// plotVisibleOnly
	        0,				// displayBlanksAs
	        NULL,			// xAxisLabel
	        $yAxisLabel		// yAxisLabel
	    );
	    //	Ajuste la posición del gráfico  en la hoja de trabajo
	    $chart->setTopLeftPosition('G7');
	    $chart->setBottomRightPosition('O20');
	    //	Add the chart to the worksheet
	    $objWorksheet->addChart($chart);

	    $objPHPExcel->getActiveSheet()->setTitle('REPORTE1');
	    // Cambiar el índice hoja activa a la primera hoja, por lo que Excel abre esto como la primera hoja
	    $objPHPExcel->setActiveSheetIndex(0);

	    // Redirect output to a client’s web browser (Excel2007)
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    //header('Content-Disposition: attachment;filename="01simple.xlsx"');
	    header('Content-Disposition: attachment;filename="'.$audit_name.'.xlsx"');

	    header('Cache-Control: max-age=0');
	    // If you're serving to IE 9, then the following may be needed
	    header('Cache-Control: max-age=1');

	    // If you're serving to IE over SSL, then the following may be needed
	    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	    header ('Pragma: public'); // HTTP/1.0

	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	    $objWriter->setIncludeCharts(TRUE);
	    $objWriter->save('php://output');
	    exit;

	}
}




    

?>
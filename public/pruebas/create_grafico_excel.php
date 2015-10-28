<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Lima');
include("includes/configure.php");

//Recibiendo datos por la url
if(isset($_GET['polls_id'])) $polls_id =$_GET['polls_id'];;
if(isset($_GET['audits_id'])) $audits_id=$_GET['audits_id'];
if(isset($_GET['sino'])) $sino = $_GET['sino'];
if(isset($_GET['options'])) $options = $_GET['options'];
if(isset($_GET['coment'])) $coment = $_GET['coment'];


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
	
	if(!empty($polls_id) && !empty($audits_id)){
    //echo "aaaa";
    if(!empty($sino) && $sino ==1){
                // Create new PHPExcel object
                    $objPHPExcel = new PHPExcel();
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                //
                // Estableciendo document propertiespropiedades al documento
                //$objPHPExcel->Properties()->setCreator("Dataservicios")
                //    ->setLastModifiedBy("Jaime Eduardo Cribillero Diaz")
                //    ->setTitle("REPORTE1")
                //    ->setSubject("Office 2007 XLSX Test Document")
                //    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                //    ->setKeywords("office 2007 openxml php")
                //    ->setCategory("Test result file");
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
                //echo $queEmp . "----";
                //Añadiendo datos desde una Consultando datos .
                    $queEmp = "SELECT
                          `audits`.`id` AS `Audit_id`,
                          `audits`.`fullname`,
                          `stores`.`id` AS `Store_id`,
                          `stores`.`fullname` AS tienda,
                          `polls`.`id` AS `Polls_id`,
                          `polls`.`question`,
                          `poll_details`.`sino`,
                          `poll_details`.`options`,
                          `poll_details`.`result`,
                          `poll_details`.`limits`,
                          `poll_details`.`media`,
                          `poll_details`.`coment`,
                          `poll_details`.`comentario`,
                          `poll_details`.`limite`
                        FROM
                          `audits`
                          INNER JOIN `company_audits` ON (`audits`.`id` = `company_audits`.`audit_id`)
                          INNER JOIN `polls` ON (`company_audits`.`id` = `polls`.`company_audit_id`)
                          INNER JOIN `poll_details` ON (`polls`.`id` = `poll_details`.`poll_id`)
                          INNER JOIN `stores` ON (`stores`.`id` = `poll_details`.`store_id`)
                        WHERE
                          `audits`.`id` = " . $audits_id . " AND
                          `polls`.`id` = " . $polls_id . " AND
                          `poll_details`.`sino` = " . $sino . "
                        ORDER BY
                          `polls`.`orden`";

                    $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
                    $totEmp = mysql_num_rows($resEmp);

                //recorriendo datos para añadir a la hoja de calculo
                    if ($totEmp> 0) {
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

                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$conatador, utf8_encode($rowEmp['tienda']) )
                                ->setCellValue('B'.$conatador, $valor ) ;
                            $question=utf8_encode($rowEmp['question']);
                            $audit_name = utf8_encode($rowEmp['fullname']);

                            //APLICANDO BORDE A LAS CELDAS
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1',$question);
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
                            new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$G$3', NULL, 1),    //  2010
                        );
                        //GENERANDO GRÁFICO
                        $xAxisTickValues = array(
                            new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$G$4:$G$5', NULL, 2),   //  Q1 to Q4
                        );

                        $dataSeriesValues = array(
                            new PHPExcel_Chart_DataSeriesValues('Number', 'REPORTE1!$H$4:$H$5', NULL, 2),
                        );
                        //  Build the dataseries
                        $series = new PHPExcel_Chart_DataSeries(
                            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
                            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
                            range(0, count($dataSeriesValues)-1),           // plotOrder
                            $dataSeriesLabels,                              // plotLabel
                            $xAxisTickValues,                               // plotCategory
                            $dataSeriesValues                               // plotValues
                        );

                        //  Set additional dataseries parameters
                        //      Make it a horizontal bar rather than a vertical column graph
                        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);

                        //  Set the series in the plot area
                        $plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series));
                        //  Set the chart legend
                        //$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);
                        $title = new PHPExcel_Chart_Title($question);
                        $yAxisLabel = new PHPExcel_Chart_Title('Valores');
                        //  Create the chart
                        $chart = new PHPExcel_Chart(
                            'chart1',       // name
                            $title,         // title
                            $legend,        // legend
                            $plotArea,      // plotArea
                            true,           // plotVisibleOnly
                            0,              // displayBlanksAs
                            NULL,           // xAxisLabel
                            $yAxisLabel     // yAxisLabel
                        );
                        //  Ajuste la posición del gráfico  en la hoja de trabajo
                        $chart->setTopLeftPosition('G7');
                        $chart->setBottomRightPosition('O20');
                        //  Add the chart to the worksheet
                        $objWorksheet->addChart($chart);

                        $objPHPExcel->getActiveSheet()->setTitle('REPORTE1');
                        // Cambiar el índice hoja activa a la primera hoja, por lo que Excel abre esto como la primera hoja
                        $objPHPExcel->setActiveSheetIndex(0);
                    

                       

                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                        $objWriter->setIncludeCharts(TRUE);
                        $objWriter->save('php://output');
                        exit;

                    }
    }


	if(!empty($options) && !empty($coment) && $options ==1 && $coment==1){
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        $objWorksheet = $objPHPExcel->getActiveSheet();
        //
        // Estableciendo document propertiespropiedades al documento
        //$objPHPExcel->Properties()->setCreator("Dataservicios")
        //    ->setLastModifiedBy("Jaime Eduardo Cribillero Diaz")
        //    ->setTitle("REPORTE1")
        //    ->setSubject("Office 2007 XLSX Test Document")
        //    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //    ->setKeywords("office 2007 openxml php")
        //    ->setCategory("Test result file");
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
            ->setCellValue('B4', 'TIPO')
            ->setCellValue('C4', 'COMENTARIO');

        // DEFINE COLOR DE TEXTO
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        //CreandO COLOR DE FONDO A LAS CELDAS
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFill()->getStartColor()->setARGB('2080D0');
        //Estableciendo formato
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
        //echo $queEmp . "----";
        //Añadiendo datos desde una Consultando datos .
        $queEmp = "SELECT
                  `audits`.`id` AS `Audit_id`,
                  `audits`.`fullname` AS audit_name,
                  `stores`.`fullname` AS store_name,
                  `polls`.`id` AS `Polls_id`,
                  `polls`.`question`,
                  `poll_details`.`comentario`,
                  `poll_details`.`options` ,
                  `poll_details`.`result`,
                  `poll_options`.`codigo`,
                  `stores`.`id`,
                  `poll_options`.`options` AS type_options
                FROM
                  `audits`
                  INNER JOIN `company_audits` ON (`audits`.`id` = `company_audits`.`audit_id`)
                  INNER JOIN `polls` ON (`company_audits`.`id` = `polls`.`company_audit_id`)
                  INNER JOIN `poll_details` ON (`polls`.`id` = `poll_details`.`poll_id`)
                  INNER JOIN `stores` ON (`stores`.`id` = `poll_details`.`store_id`)
                  INNER JOIN `poll_options` ON (`polls`.`id` = `poll_options`.`poll_id`)
                  INNER JOIN `poll_option_details` ON (`poll_options`.`id` = `poll_option_details`.`poll_option_id`)
                  AND (`stores`.`id` = `poll_option_details`.`store_id`)
                WHERE
                  `polls`.`id` = " . $polls_id  . " AND
                  `company_audits`.`audit_id` = " . $audits_id . " AND
                  `poll_details`.`options` = " . $options . "  AND
                  `poll_details`.`coment` = " . $coment . "
                ORDER BY
                  `polls`.`orden`";

        $resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
        $totEmp = mysql_num_rows($resEmp);

        //recorriendo datos para añadir a la hoja de calculo
        if ($totEmp> 0) {
            while ($rowEmp = mysql_fetch_assoc($resEmp)) {
                //echo '<b>' . $rowEmp['tienda'] . '</b><br>';
                $conatador ++;
//                if($rowEmp['result']==1){
//                    $valor = "SI";
//                }else if($rowEmp['result']==0){
//                    $valor = "NO";
//                } else{
//                    $valor = "";
//                }

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$conatador, utf8_encode($rowEmp['store_name']) )
                    ->setCellValue('B'.$conatador, utf8_encode($rowEmp['type_options']) )
                    ->setCellValue('C'.$conatador, utf8_encode($rowEmp['comentario']) );
                $question=utf8_encode($rowEmp['question']);
                $audit_name = utf8_encode($rowEmp['audit_name']);

                //APLICANDO BORDE A LAS CELDAS
                $objPHPExcel->getActiveSheet()->getStyle('A'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$conatador)->applyFromArray($styleThinBlackBorderOutline);
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',$question);

            $query = "SELECT * FROM poll_options p where poll_id=". $polls_id ;

            $resQuery = mysql_query($query, $conexion_db) or die(mysql_error());
            $totQuery = mysql_num_rows($resQuery);

            //  hoja de calculo CREANDO RESUMEN DE DATOS
            $objPHPExcel->getActiveSheet()->setCellValue('G3', 'RESUMEN')
                ->setCellValue('G4', 'TIPO')
                ->setCellValue('H4', 'CODIGO');

//                ->setCellValue('H4', '=COUNTIF(B5:B'.$conatador.',"SI")')
//                ->setCellValue('H5', '=COUNTIF(B5:B'.$conatador.',"NO")');
                $contadorTipo=4;
                $contadorFilas=0;
                if ($totQuery> 0) {
                        while ($rowQuery = mysql_fetch_assoc($resQuery)) {
                            $contadorTipo ++ ;
                            $contadorFilas ++;
                            $objPHPExcel->getActiveSheet()->setCellValue('G'.$contadorTipo , utf8_encode($rowQuery['options']))
                                ->setCellValue('H'.$contadorTipo , utf8_encode($rowQuery['codigo']))
                                ->setCellValue('I'.$contadorTipo, '=COUNTIF(B5:B'.$conatador.',"'.utf8_encode($rowQuery['options']).'")');

                            $objPHPExcel->getActiveSheet()->getCell('I'.$contadorTipo)->getCalculatedValue();

                        }

                        $dataSeriesLabels = array(
                            new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$H$4', NULL, 1),    //  2010
                        );
                        //GENERANDO GRÁFICO
                        $xAxisTickValues = array(
                            new PHPExcel_Chart_DataSeriesValues('String', 'REPORTE1!$H$5:$H$'.$contadorTipo , NULL, $contadorFilas),    //  Q1 to Q4
                        );

                        $dataSeriesValues = array(
                            new PHPExcel_Chart_DataSeriesValues('Number', 'REPORTE1!$I$5:$I$'.$contadorTipo, NULL, $contadorFilas),
                        );
                        //  Build the dataseries
                        $series = new PHPExcel_Chart_DataSeries(
                            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
                            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
                            range(0, count($dataSeriesValues)-1),           // plotOrder
                            $dataSeriesLabels,                              // plotLabel
                            $xAxisTickValues,                               // plotCategory
                            $dataSeriesValues                               // plotValues
                        );

                        //  Set additional dataseries parameters
                        //      Make it a horizontal bar rather than a vertical column graph
                        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);

                        //  Set the series in the plot area
                        $plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series));
                        //  Set the chart legend
                        //$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);
                        $title = new PHPExcel_Chart_Title($question);
                        $yAxisLabel = new PHPExcel_Chart_Title('Valores');
                        //  Create the chart
                        $chart = new PHPExcel_Chart(
                            'chart1',       // name
                            $title,         // title
                            $legend,        // legend
                            $plotArea,      // plotArea
                            true,           // plotVisibleOnly
                            0,              // displayBlanksAs
                            NULL,           // xAxisLabel
                            $yAxisLabel     // yAxisLabel
                        );
                        //  Ajuste la posición del gráfico  en la hoja de trabajo
                        $chart->setTopLeftPosition('G'. ($contadorTipo + 2 ));
                        $chart->setBottomRightPosition('O'. ($contadorTipo + 20));
                        //  Add the chart to the worksheet
                        $objWorksheet->addChart($chart);



                }

//
//            // DEFINE COLOR DE TEXTO
            $objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
            //CreandO COLOR DE FONDO A LAS CELDAS
            $objPHPExcel->getActiveSheet()->getStyle('G4:I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('G4:I5')->getFill()->getStartColor()->setARGB('2080D0');

//
//            //APLICANDO BORDE A LAS CELDAS
            $objPHPExcel->getActiveSheet()->getStyle('G4:I9')->applyFromArray($styleThinBlackBorderOutline);
//
//

            $objPHPExcel->getActiveSheet()->setTitle('REPORTE1');
            // Cambiar el índice hoja activa a la primera hoja, por lo que Excel abre esto como la primera hoja
            $objPHPExcel->setActiveSheetIndex(0);

            

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
            exit;

        }
    }




}



    

?>
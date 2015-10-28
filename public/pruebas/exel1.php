<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
include("includes/configure.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objWorksheet = $objPHPExcel->getActiveSheet();
//
//$objWorksheet->fromArray(
//    array(
//        array('SI',   12),
//        array('NO',   56),
//    )
//);

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("REPORTE1")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '¿El letrero de IBK Agente era visible desde fuera? ')
            ->setCellValue('A2', 'TIENDA')
            ->setCellValue('B2', 'RESPUESTA!');
//Estableciendo formato
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);

//Consultando datos .
$queEmp = "SELECT
  `audits`.`id` AS `Audit_id`,
  `audits`.`fullname`,
  `stores`.`id` AS `Store_id`,
  `stores`.`fullname` AS `tienda` ,
  `polls`.`id` AS `Polls_id`,
  `polls`.`question`,
  `poll_details`.`sino`,
  `poll_details`.`options`,
  `poll_details`.`result`
FROM
  `audits`
  INNER JOIN `company_audits` ON (`audits`.`id` = `company_audits`.`audit_id`)
  INNER JOIN `polls` ON (`company_audits`.`id` = `polls`.`company_audit_id`)
  INNER JOIN `poll_details` ON (`polls`.`id` = `poll_details`.`poll_id`)
  INNER JOIN `stores` ON (`stores`.`id` = `poll_details`.`store_id`)
WHERE
  `audits`.`id` = 8 AND
  `polls`.`id` = 2
ORDER BY
  `polls`.`orden`";
$resEmp = mysql_query($queEmp, $conexion_db) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);
$conatador=4;

//LLenando datos a excel
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
            ->setCellValue('A'.$conatador, $rowEmp['tienda'] )
            ->setCellValue('B'.$conatador, $valor ) ;
    }
}

//CREANDO RESUMEN DE DATOS
//$objPHPExcel->getActiveSheet()->setCellValue('D3', 'RESUMEN')
//    ->setCellValue('D4', 'SI')
//    ->setCellValue('D5', 'NO')
//    ->setCellValue('E4', '=CONTAR.SI(B5:B'.$conatador.',"SI")')
//    ->setCellValue('E5', '=CONTAR.SI(B5:B'.$conatador.',"NO")');

//$objPHPExcel->getActiveSheet()->getCell('E4')->getCalculatedValue();

//$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Range #1')
//    ->setCellValue('K2', 3)
//    ->setCellValue('K3', 7)
//    ->setCellValue('K4', 13)
//    ->setCellValue('K5', '=SUM(K2:K4)');
$objPHPExcel->getActiveSheet()->getCell('K5')->getCalculatedValue() ;

//echo date('H:i:s') , " Sum of Range #1 is " , $objPHPExcel->getActiveSheet()->getCell('E5')->getCalculatedValue() , EOL;
//echo date('H:i:s') , " Sum of Range #1 is " , $objPHPExcel->getActiveSheet()->getCell('E5')->getCalculatedValue() , EOL;

$objPHPExcel->getActiveSheet()->setCellValue('D3', 'RESUMEN')
    ->setCellValue('D4', 'SI')
    ->setCellValue('D5', 'NO')
    ->setCellValue('E4', '10')
    ->setCellValue('E5', '15')
    ->setCellValue('E8', '=COUNTIF(B5:B40,"NO")');
$objPHPExcel->getActiveSheet()->getCell('E8')->getCalculatedValue() ;

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('REPORTE1');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
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

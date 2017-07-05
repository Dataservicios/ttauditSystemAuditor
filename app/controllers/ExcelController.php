<?php
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 1/25/2016
 * Time: 4:14 PM
 */


use Maatwebsite\Excel\Facades\Excel;
use Auditor\Repositories\ProductRepo;

class ExcelController extends  BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        Excel::create('Laravel Excel', function($excel) {
            $excel->sheet('Productos', function($sheet) {
                //$products = Product::all();
                //$sheet->fromArray($products);
                //$sheet->fromArray($this->productRepo->allReg());
                //dd($this->productRepo->allReg());
                $sqlcoord="CALL sp_reporte_company_82_premiados;";
                $stores = DB::select($sqlcoord);
                //dd($stores);
//                $payment[] = array();
//                foreach ($stores as $payment) {
//                    $payment = $payment;
//                }
//                dd($payment);
                $data = array();
                foreach ($stores as $result) {
//                    $result->filed1 = 'some modification';
//                    $result->filed2 = 'some modification2';
                    $data[] = (array)$result;
                    #or first convert it and then change its properties using
                    #an array syntax, it's up to you
                }
                 //dd($data);
//                $obj = get_object_vars($stores);
//                $obj = (array)$stores;
                $sheet->fromArray($data);



            });
        })->export('xls');
    }

    public function prueba()
    {
        Excel::create('Report2017', function($excel) {
            // Set the title
            $excel->setTitle('My awesome report 2016');
            // Chain the setters
            $excel->setCreator('Me')->setCompany('Our Code World');
            $excel->setDescription('A demonstration to change the file properties');
            $data = [12,"Hey",123,4234,5632435,"Nope",345,345,345,345];
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
            });
        })->download('xlsx');
    }

    public function alertas()
    {

        Excel::create('Alertas IBK', function($excel) {
            $excel->setTitle('Alertas IBK 2016');
            $excel->sheet('Alertas', function($sheet) {
                $sqlcoord="SELECT 
                          `alerts`.`titulo`,
                          `alerts`.`motivo`,
                          `alert_comments`.`comment`,
                          `users`.`fullname` as  `fullname_user`,
                          `companies`.`fullname`
                        FROM
                          `alert_comments`
                          LEFT OUTER JOIN `alerts` ON (`alert_comments`.`alert_id` = `alerts`.`id`)
                          INNER JOIN `users` ON (`alert_comments`.`user_id` = `users`.`id`)
                          LEFT OUTER JOIN `companies` ON (`alerts`.`company_id` = `companies`.`id`)";
                $stores = DB::select($sqlcoord);
                $data = array();
                foreach ($stores as $result) {
                    $data[] = (array)$result;
                }


                $headings = array('TITULO', 'MOTIVO', 'COMENTARIO', 'USUARIO', 'CAMPAÑA');
                $sheet->prependRow(4, $headings);
                //$sheet->fromArray($data);
                //fromArray($source, $nullValue, $startCell, $strictNullComparison, $headingGeneration)
                $sheet->fromArray($data,null,'A5',false,false);
                $sheet->row(4, function($row) { $row->setFontColor('#fefffe'); $row->setBackground('#009b3a'); $row->setFontWeight('bold');  $row->setFontSize(12);});

                //$sheet->setAutoFilter('A4:E10');
//                $sheet->getCell('A7')
//                    ->getHyperlink()
//                    ->setUrl('http://examle.com/uploads/cv/' . $cellValue)
//                    ->setTooltip('Click here to access file');

                $sheet->getCell('A7')
                    ->getHyperlink()
                    ->setUrl('http://examle.com/uploads/cv/' )
                    ->setTooltip('Click here to access file');
            });
        })->export('xls');
    }



}
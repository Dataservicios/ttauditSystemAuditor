<?php

use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\AuditRepo;
use Auditor\Repositories\AuditRoadStoreRepo;
use Auditor\Repositories\CompanyStoreRepo;
use Auditor\Repositories\RoadDetailRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\MediaRepo;

class ReportController extends BaseController{

    protected $CompanyRepo;
    protected $UserCompanyRepo;
    protected $PollRepo;
    protected $CompanyAuditRepo;
    protected $PollDetailRepo;
    protected $PollOptionRepo;
    protected $PollOptionDetailRepo;
    protected $AuditRepo;
    protected $AuditRoadStoreRepo;
    protected $RoadDetailRepo;
    protected $storeRepo;
    protected $MediaRepo;

    public $RutasPorEmpresa;
    public $Empresas;
    public $CantidadTiendasPorEmpresa;
    public $CantidadTiendasAuditadas;
    public $NroReportes;


    public function __construct(MediaRepo $MediaRepo,StoreRepo $storeRepo, RoadDetailRepo $RoadDetailRepo,CompanyStoreRepo $CompanyStoreRepo,AuditRoadStoreRepo $AuditRoadStoreRepo,AuditRepo $AuditRepo,CompanyRepo $CompanyRepo, UserCompanyRepo $userCompanyRepo, PollRepo $PollRepo, CompanyAuditRepo $CompanyAuditRepo, PollDetailRepo $PollDetailRepo,PollOptionRepo $pollOptionRepo, PollOptionDetailRepo $PollOptionDetailRepo)
    {
        $this->RoadDetailRepo = $RoadDetailRepo;
        $this->CompanyStoreRepo = $CompanyStoreRepo;
        $this->AuditRoadStoreRepo = $AuditRoadStoreRepo;
        $this->AuditRepo = $AuditRepo;
        $this->CompanyRepo = $CompanyRepo;
        $this->UserCompanyRepo = $userCompanyRepo;
        $this->PollRepo = $PollRepo;
        $this->CompanyAuditRepo = $CompanyAuditRepo;
        $this->PollDetailRepo = $PollDetailRepo;
        $this->PollOptionRepo = $pollOptionRepo;
        $this->PollOptionDetailRepo = $PollOptionDetailRepo;
        $this->storeRepo = $storeRepo;
        $this->MediaRepo = $MediaRepo;
    }

    public function quantityStoresAudits($ciudad="0",$distrito = "0",$ejecutivo="0",$rubro="0")
    {

        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $roadsForCompany = $this->AuditRoadStoreRepo->getRoadsForCompany($company[0]->id);//dd(count($roadsForCompany));
        if (count($roadsForCompany)<>0){

            $CantidadStoresAudits = $this->RoadDetailRepo->getQuantityStoresAudits($roadsForCompany, 1,$ciudad,$distrito,$ejecutivo,$rubro);
            /*if ($CantidadStoresAudits==0){
                $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id);
            }else{
                $cantidadStoresForCompany = $this->RoadDetailRepo->getQuantityStoresAudits($roadsForCompany, 0, $ciudad,$distrito,$ejecutivo,$rubro);
            }*/
            $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id);
        }else{
            $cantidadStoresForCompany = $this->CompanyStoreRepo->getQuantityStoresForCompany($company[0]->id);
            $CantidadStoresAudits = 0;
        }
        if ($company[0]->id==8){
            $cantidadStoresForCompany = $cantidadStoresForCompany;
        }

        $arrayGrafico[] = array('tipo' => 'Auditadas', 'cantidad' => $CantidadStoresAudits, 'color' => '#009B3A');
        $arrayGrafico[] = array('tipo' => 'No auditadas', 'cantidad' => $cantidadStoresForCompany - $CantidadStoresAudits, 'color' => '#0A246');
        //dd($arrayGrafico);
        $jsonCantidadStoresAudits = json_encode($arrayGrafico);
        $valorOutput[] = array('cantidadStoresForCompany' => $cantidadStoresForCompany, 'CantidadStoresAudits' => $CantidadStoresAudits, 'jsonCantidadStoresAudits' =>$jsonCantidadStoresAudits );
        return $valorOutput;
    }

    public function quantityPollsStore($store_id)
    {

    }

    public function reportExcel()
    {
        $userType = Auth::user()->type;
        $QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
        //dd($cantidadStoresForCompany);

        $valorNroReportes = $this->getNumberReports($cantidadStoresForCompany);
        //dd($valorNroReportes);
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        //dd($AuditsCompany );
        $audit_id ='excel';
        $company_id = 1;
        $nroItems = $CantidadStoresAudits/50;
        $entItems = intval($nroItems);//dd($nroItems);
        $decItems = $nroItems - $entItems;
        if ($entItems>0){
            if ($decItems>0){
                $entItems = $entItems + 1;
            }
        }
        return View::make('report/interbank/reportExcel',compact('userType','AuditsCompany','audit_id','valorNroReportes', 'company_id','CantidadStoresAudits','cantidadStoresForCompany','entItems'));
    }


    public function reportHome()
    {
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        //dd($company);
        $company_id=$company[0]->id;
        $audit_id ="0";
        if ($userType){
            if (($company_id==1) or ($company_id==8)){
                $QstoresAudits = $this->quantityStoresAudits();
                //dd($QstoresAudits);
                $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
                $jsonCantidadStoresAudits = $QstoresAudits[0]['jsonCantidadStoresAudits'];
                if ($company_id==8){

                    $poll_conexito=52;
                    $sino_conexito=$this->PollDetailRepo->getTotalSiNo($poll_conexito);
                    //$valSiNo[0] = array("tipo" => 'Con Disposición', "Op. Con Exito" => $sino_conexito['si'], "Op. Sin Exito" => 0, "Ag. Cerrados" =>0,"Ag. No Aceptaron Trans."=>0);

                    $poll_cerrados=67;
                    $sino_cerrados=$this->PollDetailRepo->getTotalSiNo($poll_cerrados);

                    $poll_notrans=47;
                    $sino_notrans=$this->PollDetailRepo->getTotalSiNo($poll_notrans);

                    //$valSiNo[1] = array("tipo" => 'Sin Disposición', "Op. Con Exito" => 0, "Op. Sin Exito" => $sino_conexito['no'], "Ag. Cerrados" =>$sino_cerrados['no'],"Ag. No Aceptaron Trans."=>$sino_notrans['no']);
                    $valSiNo[] = array("tipo" => 'Op. Con Exito', "cantidad" => $sino_conexito['si'], "color" => '#009B3A');
                    $valSiNo[] = array("tipo" => 'Op. Sin Exito', "cantidad" => $sino_conexito['no'], "color" => '#FFC000');
                    $valSiNo[] = array("tipo" => 'Ag. Cerrados', "cantidad" => $sino_cerrados['no'], "color" => '#DC0451');
                    $valSiNo[] = array("tipo" => 'Ag. No Aceptaron Trans.', "cantidad" => $sino_notrans['no'], "color" => '#00ADD0');
                    $valSINOJson =json_encode($valSiNo);unset($valSiNo);

                    $poll_limit1=57;
                    $limits1=$this->PollDetailRepo->getTotalLimites($poll_limit1);
                    $valLimits[] = array("tipo" => 'Disposición', "Debajo de Estandar" => $limits1['deb'], "Estandar" => $limits1['est'], "Superior" => $limits1['sup']);

                    $poll_limit2=58;
                    $limits2=$this->PollDetailRepo->getTotalLimites($poll_limit2);
                    $valLimits[] = array("tipo" => 'Conocimiento', "Debajo de Estandar" => $limits2['deb'], "Estandar" => $limits2['est'], "Superior" => $limits2['sup']);

                    $poll_limit3=59;
                    $limits3=$this->PollDetailRepo->getTotalLimites($poll_limit3);
                    $valLimits[] = array("tipo" => 'Amabilidad', "Debajo de Estandar" => $limits3['deb'], "Estandar" => $limits3['est'], "Superior" => $limits3['sup']);

                    $valLimitsJson =json_encode($valLimits);unset($valLimits);
                }

            }

        }
        if ($company_id==1){
            return View::make('report/inicioIbk1', compact('valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }
        if ($company_id==6){
            return View::make('report/inicioMediaConcept',compact('userType'));
        }
        if ($company_id==7){
            return View::make('report/inicioColgate',compact('userType','valorNroReportes','AuditsCompany','audit_id'));
        }
        if ($company_id==8){
            return View::make('report/inicio', compact('valLimitsJson','valSINOJson','userType','valorNroReportes','AuditsCompany','audit_id','cantidadStoresForCompany','CantidadStoresAudits','jsonCantidadStoresAudits'));
        }
    }

    public function audit($id)
    {
        if ($id==7){
            return View::make('report/interbank/audit1');
        }
        if ($id==8){
            return View::make('report/interbank/audit2');
        }

        if ($id==9){
            return View::make('report/interbank/audit3');
        }

    }

    /**
     *Obtiene nro. de reportes a generar
     */
    public function getNumberReports($CantidadTiendasPorEmpresa)
    {
        $reportes = $CantidadTiendasPorEmpresa/50;

        if (strpos($reportes,'.')=== false){
            $valorNroReportes=$reportes;
        }else{
            $nroReportes = explode(".",$reportes);
            if ($nroReportes[1]>0) {
                $valorNroReportes=$nroReportes[0] + 1;
            }else{
                $valorNroReportes=$nroReportes[0];
            }
        }
        return $valorNroReportes;
    }

    public function auditReportAbstract($audit_id="0",$store_id="0")
    {
        if ($audit_id=="0"){
            $valoresPost= Input::all();
            $audit_id = $valoresPost['audit_id'];
            $city = $valoresPost['ciudad'];
            if ($city<>"0"){
                if ($valoresPost['distrito']<>"0"){
                    $arrayDistrict = explode($city.'|',$valoresPost['distrito']);
                    $district = $arrayDistrict[1];
                    if ($valoresPost['ejecutivo']<>"0"){
                        $ejecutivo = $valoresPost['ejecutivo'];
                        if ($valoresPost['rubro']<>"0"){
                            $rubro = $valoresPost['rubro'];
                        }else{
                            $rubro ="0";
                        }
                    }else{
                        $ejecutivo ="0";
                        if ($valoresPost['rubro']<>"0"){
                            $rubro = $valoresPost['rubro'];
                        }else{
                            $rubro ="0";
                        }
                    }
                }else{
                    $district ="0";
                    if ($valoresPost['ejecutivo']<>"0"){
                        $ejecutivo =$valoresPost['ejecutivo'];
                    }else{
                        $ejecutivo ="0";
                    }
                    if ($valoresPost['rubro']<>"0"){
                        $rubro = $valoresPost['rubro'];
                    }else{
                        $rubro ="0";
                    }
                }
            }else{
                $district ="0";
                if ($valoresPost['ejecutivo']<>"0"){
                    $ejecutivo =$valoresPost['ejecutivo'];
                }else{
                    $ejecutivo ="0";
                }
                if ($valoresPost['rubro']<>"0"){
                    $rubro = $valoresPost['rubro'];
                }else{
                    $rubro ="0";
                }
            }

        }else{
            $city = "0";
            $district ="0";
            $ejecutivo ="0";
            $rubro ="0";
        }
        $valores = $city.'-'.$district.'-'.$ejecutivo.'-'.$rubro;
        $letras = array(0 => 'a', 1 => 'b', 2 =>'c', 3 =>'d', 4 =>'e', 5 => 'f', 6 => 'g', 7 => 'h', 8 => 'i', 9 => 'j');

        $audit = $this->AuditRepo->find($audit_id);

        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            if (($company_id==1) or ($company_id==8)){
                $QstoresAudits = $this->quantityStoresAudits($city,$district,$ejecutivo,$rubro);
                $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
                $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];
            }
            if ($company_id==6) {
                $CantidadStoresAudits = $this->PollDetailRepo->getTotalPollsStore($store_id);

            }

            $AuditsCompany = $this->getAuditForCompany($company_id);
            //dd($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company[0]->id));//obtiene el id del registro de la auditoria contratada
            $polls = $this->PollRepo->getPollsForAuditForCompany($this->CompanyAuditRepo->getIdForAuditForCompany($audit_id,$company_id));
            //dd($polls);//obtiene preguntas de la auditoria con id= $audit_id
            if (count($polls) > 0){  //dd(count($polls));
                foreach ($polls as $poll){

                    $indicators=$this->PollDetailRepo->getIndicatorForIdPoll($poll->id);
                    //dd($indicators); //visualiza que indicadores tiene activo la pregunta con id = $poll->id
                    if (count($indicators)>0){
                        if ($indicators->sino == 1){
                            $sino=$this->PollDetailRepo->getTotalSiNo($poll->id,$city,$district,$ejecutivo,$rubro,$store_id);

                            if ($poll->id==38){
                                $total = $sino['Afiches'] + $sino['Afiche_plastico'] + $sino['Letreros'];
                                if ($total>0){
                                    $porc2 = ($sino['Afiches']/$total)*100;
                                    $porc3 = ($sino['Afiche_plastico']/$total)*100;
                                    $porc4 = ($sino['Letreros']/$total)*100;
                                }else{
                                    $porcSI = 0;
                                    $porcNO = 0;
                                }
                            }else{
                                $total = $sino['si'] + $sino['no'];
                                if ($total>0){
                                    $porcSI = ($sino['si']/$total)*100;
                                    $porcNO = ($sino['no']/$total)*100;
                                }else{
                                    $porcSI = 0;
                                    $porcNO = 0;
                                }
                            }
                            if ($poll->id==38){
                                $valSiNo[0] = array("respuesta" => 'Afiches', "cantidad" => $sino['Afiches'], "porcentaje" => round($porc2,0));
                                $valSiNo[1] = array("respuesta" => 'Afiche Plástico', "cantidad" => $sino['Afiche_plastico'], "porcentaje" => round($porc3,0));
                                $valSiNo[2] = array("respuesta" => 'Letreros', "cantidad" => $sino['Letreros'], "porcentaje" => round($porc4,0));
                            }else{
                                $valSiNo[0] = array("respuesta" => 'SI', "cantidad" => $sino['si'], "porcentaje" => round($porcSI,0));
                                $valSiNo[1] = array("respuesta" => 'NO', "cantidad" => $sino['no'], "porcentaje" => round($porcNO,0));
                            }

                            //dd($valSiNo);
                            $valSINOJson =json_encode($valSiNo);unset($valSiNo);
                        }else{
                            $sino = array('si' => 0,'no'=>0);
                            $valSINOJson = array("respuesta" => '', "cantidad" => 0, "porcentaje" => 0);
                        }

                        if ($indicators->limits == 1){
                            //dd($poll->id);
                            $limits=$this->PollDetailRepo->getTotalLimites($poll->id,$city,$district,$ejecutivo,$rubro);

                           // dd($limits);
                            //array('Muy_Lento' => $total3,'Lento'=>$total4,'Normal'=>$total2,'Rapida'=>$total1,'Muy_rapido'=>$total5);
                            if (($poll->id==13) or ($poll->id==53)){
                                $total = $limits['Rapida'] + $limits['Normal'] + $limits['Muy_Lento'] + $limits['Lento'] + $limits['Muy_rapido'];
                                if ($total>0){
                                    $porc1 = ($limits['Rapida']/$total)*100;
                                    $porc2 = ($limits['Normal']/$total)*100;
                                    $porc3 = ($limits['Muy_Lento']/$total)*100;
                                    $porc4 = ($limits['Lento']/$total)*100;
                                    $porc5 = ($limits['Muy_rapido']/$total)*100;
                                }else{
                                    $porc1 = 0;
                                    $porc2 = 0;
                                    $porc3 = 0;
                                    $porc4 =0;
                                    $porc5 =0;
                                }

                                $valLimits[0] = array("respuesta" => 'Rápida', "cantidad" => $limits['Rapida'], "porcentaje" => round($porc1,0));
                                $valLimits[1] = array("respuesta" => 'Normal', "cantidad" => $limits['Normal'], "porcentaje" => round($porc2,0));
                                $valLimits[2] = array("respuesta" => 'Muy Lento', "cantidad" => $limits['Muy_Lento'], "porcentaje" => round($porc3,0));
                                $valLimits[3] = array("respuesta" => 'Lento', "cantidad" => $limits['Lento'], "porcentaje" => round($porc4,0));
                                $valLimits[4] = array("respuesta" => 'Muy Rápido', "cantidad" => $limits['Muy_rapido'], "porcentaje" => round($porc5,0));
                            }else{
                                $total = $limits['deb'] + $limits['est'] + $limits['sup'];
                                if ($total>0){
                                    $porc1 = ($limits['deb']/$total)*100;
                                    $porc2 = ($limits['est']/$total)*100;
                                    $porc3 = ($limits['sup']/$total)*100;
                                }else{
                                    $porc1 = 0;
                                    $porc2 = 0;
                                    $porc3 = 0;
                                }

                                $valLimits[0] = array("respuesta" => 'Debajo del estándar', "cantidad" => $limits['deb'], "porcentaje" => round($porc1,0));
                                $valLimits[1] = array("respuesta" => 'Estándar', "cantidad" => $limits['est'], "porcentaje" => round($porc2,0));
                                $valLimits[2] = array("respuesta" => 'Superior', "cantidad" => $limits['sup'], "porcentaje" => round($porc3,0));
                            }

                            //dd($valSiNo);
                            $valLimitsJson =json_encode($valLimits);unset($valLimits);
                        }else{
                            $limits = array('deb' => 0,'est'=>0, 'sup'=>0);
                            $valLimitsJson = array("respuesta" => '', "cantidad" => 0, "porcentaje" => 0);
                        }

                        if ($indicators->options == 1){
                            $options= $this->PollOptionRepo->getOptions($poll->id);$letra =0;$cantidadTotal=0;
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro,$store_id);

                                $cantidadTotal = $cantidadTotal +$cantidadOption;
                            }
                            foreach ($options as $option){
                                $cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id,$city, $district,$ejecutivo,$rubro,$store_id);
                                if ($cantidadTotal<>0){
                                    $porcOpcion = ($cantidadOption/$cantidadTotal)*100;
                                }else{
                                    $porcOpcion = 0;
                                }

                                //$LeyendaOptions[] = array('respuesta' => $letras[$letra], 'option' => $option->options);
                                $ValRespuesta= trim($option->options_abreviado);

                                //echo $ValRespuesta."<br>";
                                $totalOptions[] = array( 'respuesta'=>$ValRespuesta,'cantidad' => $cantidadOption, "porcentaje" => round($porcOpcion,0));

                                $letra=$letra+1;

                                if (($poll->id == 26) and ($option->id == 58)){
                                    $optionsDetails = $this->PollOptionDetailRepo->getOptionsOther($option->id );
                                    //dd($optionsDetails);
                                    $cantidadOptionDetailTotal=0;
                                    foreach ($optionsDetails as $optionsDetail){
                                        $cantidadOptionDetail = $this->PollOptionDetailRepo->getTotalOptionOther($option->id,$optionsDetail->otro,$city, $district,$ejecutivo,$rubro);
                                        $cantidadOptionDetailTotal = $cantidadOptionDetailTotal + $cantidadOptionDetail;
                                    }
                                    foreach ($optionsDetails as $optionsDetail){
                                        $cantidadOptionDetail = $this->PollOptionDetailRepo->getTotalOptionOther($option->id,$optionsDetail->otro,$city, $district,$ejecutivo,$rubro);
                                        if ($cantidadOptionDetailTotal<>0){
                                            $porcOpcionDetail = ($cantidadOptionDetail/$cantidadOptionDetailTotal)*100;
                                        }else{
                                            $porcOpcionDetail = 0;
                                        }
                                        $totalOptionsOther[] = array( 'respuesta'=>$optionsDetail->otro,'cantidad' => $cantidadOptionDetail, "porcentaje" => round($porcOpcionDetail,0));
                                    }
                                    $totalOptionsOtherJSON = json_encode($totalOptionsOther);unset($totalOptionsOther);
                                }else{
                                    $totalOptionsOtherJSON = array('respuesta' => "No Existe", 'cantidad' => 0, "porcentaje" => 0);
                                }
                            }
                            //var_dump($totalOptions);
                            //dd($totalOptions);
                            //dd(json_encode($valFormateadosOptions));
                            $totalOptionsJSON = json_encode($totalOptions);unset($totalOptions);
                        }else{
                            //$LeyendaOptions = array('respuesta' => 0, 'option' => 0);
                            $totalOptionsJSON = array('option' => "No Existe", 'total' => 0);
                            $totalOptionsOtherJSON = array('respuesta' => "No Existe", 'cantidad' => 0, "porcentaje" => 0);
                        }
                        //dd($totalOptionsJSON);
                        $resumenes[] = array('succes' => 1,'poll_id' => $poll->id, 'question' => $poll->question, 'sino' => $indicators->sino, 'result' => $sino, 'JSONSiNo' => $valSINOJson,'option' => $indicators->options, 'JSONOpciones' =>$totalOptionsJSON, 'JSONOpcionesOther' =>$totalOptionsOtherJSON,'limits' => $indicators->limits, 'JSONLimits' =>$valLimitsJson, 'audit_id' =>$audit_id);
                    }else{
                        $sino = array('si' => 0,'no'=>0);
                        $LeyendaOptions = array('respuesta' => 0, 'option' => 0);
                        $totalOptionsJSON = array('option' => "No Existe", 'total' => 0);

                        $resumenes[] = array('succes' => 0,'poll_id' => $poll->id, 'question' => $poll->question, 'sino' => 0, 'result' => 0, 'JSONSiNo' => 0,'option' => 0, 'JSONOpciones' =>0, 'JSONOpcionesOther' =>0,'limits' => 0, 'JSONLimits' =>0, 'audit_id' =>$audit_id);
                    }

                }
            }else{
                $resumenes[] = array('succes' => 0,'poll_id' => 0, 'question' => "", 'sino' => 0, 'result' => 0, 'JSONSiNo' => 0,'option' => 0, 'JSONOpciones' =>0, 'JSONOpcionesOther' =>0,'limits' => 0, 'JSONLimits' =>0, 'audit_id' =>$audit_id);
            }
        }
        //dd($resumenes);
        //dd($audit);


        if ($city==1){
            $city="Todo Lima";
        }
        if ($city==2){
            $city="Todo Arequipa";
        }
        if ($city==3){
            $city="Todo Ica";
        }
        if ($city==4){
            $city="Todo Trujillo";
        }
        if (($company_id==1) or ($company_id==8)){
            return View::make('report/interbank/audit',compact('valores','city','district','ejecutivo','rubro','cantidadStoresForCompany','CantidadStoresAudits','userType','audit','AuditsCompany','audit_id','resumenes'));
        }
        if ($company_id==6){
            return View::make('report/MediaConcept/audit',compact('store_id','CantidadStoresAudits','userType','audit','audit_id','resumenes'));
        }

    }

    public function operationsGroup()
    {
        $fp = fopen ( 'media/archivos/stores_data_interbank.csv' , "r" );$c=0;
        while ($data = fgetcsv ($fp, 1000, ",")){
            if ($c<>0){
                $valores[] = array('Codigo'=>$data[0],'Ejecutivo'=>$data[6],'Rubro'=>$data[7]);
                $store = $this->storeRepo->find($data[0]);
                $store->ejecutivo = $data[6];
                $store->rubro = $data[7];
                $store->save();

            }
            $c=$c+1;
        }
        return View::make('report/interbank/audit1', compact('valores'));
    }

    public function reportAudios()
    {
        $contador=0;
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        $audit_id ='audios';
        $directorio = opendir("/home/ttaudit/public_html/media/audio/"); //ruta actual
        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (!is_dir($archivo)) {
                $contador=$contador+1;
                $trozos = explode(".", $archivo);
                $store = $this->storeRepo->getStoreForCod($trozos[0]);
                //dd($store);
                foreach ($store as $storeObj){
                    $valAudios[]= array('contador' => $contador,'agente' => $storeObj->fullname,'codclient' => $storeObj->codclient,'direccion' => $storeObj->address,'ubigeo' => $storeObj->ubigeo,'archivo' => $archivo);
                }
            }
        }
        //dd($valAudios);
        return View::make('report/interbank/audios', compact('userType','valorNroReportes','AuditsCompany','audit_id','valAudios'));
    }

    public function getDetailResultQuestion($poll_id,$values,$poll_option_id="0")
    {
        //$valores = $city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0
        $valorNroReportes = 0;
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $AuditsCompany = $this->getAuditForCompany($company[0]->id);
        $audit_id ='DetailPollSiNo';

        $urlBase = \App::make('url')->to('/');
        $urlImages = '/media/fotos/';
        $valores = explode('-',$values);
        $city = $valores[0];
        $district = $valores[1];
        $ejecutivo = $valores[2];
        $rubro = $valores[3];

        if ($poll_option_id == 0) {
            $stores = $this->PollDetailRepo->getDetailSiNo($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[4]);
        }
        if ($poll_option_id <> 0) {
            $stores = $this->PollOptionDetailRepo->getDetailOption($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[4]);
        }


        //dd($stores);
        if(! empty($stores)){
            foreach ($stores as $store){
                $photos = $this->MediaRepo->photosPollStore($poll_id, $store->id);
                if(! empty($photos)){
                    //dd(\App::make('url')->to('/'));
                    foreach ($photos as $photo){
                        $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $urlBase.$urlImages.$photo->archivo);
                    }
                }else{
                    $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                }
                if ($poll_option_id <> 0) {
                    $datosStores[] = array('store_id' => $store->id, 'codclient' => $store->codclient,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->options, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
                }else{
                    $datosStores[] = array('store_id' => $store->id, 'codclient' => $store->codclient,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->comentario, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
                }

                unset($datosFoto);
            }
            //dd($datosStores);
        }else{
            $datosStores[] = array('store_id' => '0', 'codclient' => '', 'departamento' => '', 'Provincia' => '', 'distrito' => '', 'arrayFoto' => '');
        }

        if ($city==1){
            $city="Todo Lima";
        }
        if ($city==2){
            $city="Todo Arequipa";
        }
        if ($city==3){
            $city="Todo Ica";
        }
        if ($city==4){
            $city="Todo Trujillo";
        }
        $question = $this->PollRepo->find($poll_id);
        $QstoresAudits = $this->quantityStoresAudits();
        $cantidadStoresForCompany = $QstoresAudits[0]['cantidadStoresForCompany'];
        $CantidadStoresAudits = $QstoresAudits[0]['CantidadStoresAudits'];

        return View::make('report/interbank/detailPollSiNo', compact('cantidadStoresForCompany','CantidadStoresAudits','question','city','district','ejecutivo','rubro','userType','valorNroReportes','AuditsCompany','audit_id','datosStores'));
    }
} 
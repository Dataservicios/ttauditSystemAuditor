<?php
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CompanyAuditRepo;
use Auditor\Repositories\AuditRepo;

class BaseController extends Controller {

	public $valoresCampaigne;
	public $questionSendEmail;
	public $groupsEmail;
	public $categoryProductCampaigne;

	public function getQuestionsSendEmail()
	{
		$this->questionSendEmail[] = array('company_id' => 37,'poll_id' => 504,'send' =>0,'result' =>0, 'poll_option_id' => 1591,'mask' =>'ttauditRaul|alicorpVT|sistemas');
		$this->questionSendEmail[] = array('company_id' => 48,'poll_id' => 637,'send' =>0,'result' =>0, 'poll_option_id' => 2047,'mask' =>'ttauditRaul|alicorpVT|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 615,'send' =>0,'result' =>0, 'poll_option_id' => 2001,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 615,'send' =>0,'result' =>0, 'poll_option_id' => 2002,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 615,'send' =>0,'result' =>0, 'poll_option_id' => 2003,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 616,'send' =>0,'result' =>0, 'poll_option_id' => 2004,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 616,'send' =>0,'result' =>0, 'poll_option_id' => 2005,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 616,'send' =>0,'result' =>0, 'poll_option_id' => 2006,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 616,'send' =>0,'result' =>0, 'poll_option_id' => 2007,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 42,'poll_id' => 614,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 50,'poll_id' => 712,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 50,'poll_id' => 708,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 52,'poll_id' => 751,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 52,'poll_id' => 747,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 58,'poll_id' => 832,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 58,'poll_id' => 828,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 59,'poll_id' => 838,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 59,'poll_id' => 839,'send' =>0,'result' =>0, 'poll_option_id' => 2500,'mask' =>'ttauditRaul');
		$this->questionSendEmail[] = array('company_id' => 59,'poll_id' => 839,'send' =>0,'result' =>0, 'poll_option_id' => 2502,'mask' =>'ttauditRaul');

		$this->questionSendEmail[] = array('company_id' => 75,'poll_id' => 1235,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 75,'poll_id' => 1236,'send' =>0,'result' =>0, 'poll_option_id' => 3380,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 75,'poll_id' => 1236,'send' =>0,'result' =>0, 'poll_option_id' => 3382,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 79,'poll_id' => 1371,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 79,'poll_id' => 1443,'send' =>0,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul|sistemas');
		$this->questionSendEmail[] = array('company_id' => 'change_address','poll_id' => 0,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttauditRaul|sistemas');
		//$this->questionSendEmail[] = array('company_id' => 37,'poll_id' => 499,'send' =>1,'result' =>0, 'poll_option_id' => 0,'mask' =>'ttaudit|sistemas');
		return $this->questionSendEmail;
	}
	

	public function getGroupsEmails()
	{
		$this->groupsEmail['ttaudit'] = array('email' => 'aguerra@ttaudit.com:Augusto|rpulido@ttaudit.com:Raul|dolaguibel@ttaudit.com:Daniela');
		$this->groupsEmail['ttauditRaul'] = array('email' => 'rpulido@ttaudit.com:Raul|dolaguibel@ttaudit.com:Daniela');
		//$this->groupsEmail['ttaudit'] = array('email' => 'vaguirrev@atentoperu.com.pe:Aguirre|rpulido@ttaudit.com:Raul|aguerra@ttaudit.com:Augusto');
		$this->groupsEmail['alicorpVT'] = array('email' => 'vaguirrev@atentoperu.com.pe:Aguirre|MFernandezD@alicorp.com.pe:Fernandez|csanjinez@atentoperu.com.pe:Sanjinez|vaguirrev@atentoperu.com.pe:Aguirre');
		$this->groupsEmail['alicorpMAY'] = array('email' => 'ASarangoU@alicorp.com.pe:Aguirre|gguzman@lucky.com.pe:Fernandez');
		$this->groupsEmail['sistemas'] = array('email' => 'franbrsj@gmail.com:Franco|jcdiaz356@gmail.com:Jaime');
		return $this->groupsEmail;
	}
	
	public function sendEmails($store_id,$textoContent,$motivo,$auditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails,$fono="0")
	{
		if ($fono=="0"){
			$datai = ['origen' => $store_id,
				'tipo'  =>  'LocalCerrado',
				'titulo'=> $textoContent,
				'motivo' => $motivo,
				'auditor' => $auditor,
				'comentario' => $comentario,
				'cadena' => $cliente,
				'tipoLocal' => $tipo_bodega,
				'agente'   =>  $agente,
				'dir' => $dir,
				'direccion' => $address,
				'distrito' => $district,
				'foto' => $foto,
				'fecha' => $fechaHoraEnvio
			];
		}else{
			$datai = ['origen' => $store_id,
				'tipo'  =>  'LocalCerrado',
				'titulo'=> $textoContent,
				'motivo' => $motivo,
				'auditor' => $auditor,
				'comentario' => $comentario,
				'cadena' => $cliente,
				'tipoLocal' => $tipo_bodega,
				'agente'   =>  $agente,
				'dir' => $dir,
				'direccion' => $address,
				'distrito' => $district,
				'foto' => $foto,
				'fono' => $fono,
				'fecha' => $fechaHoraEnvio
			];
		}
		//dd($emails);
		$valEmails = explode("|",$emails['email']);//dd(count($valEmails));
		for($i=0;$i<count($valEmails);$i++) {
			$valores = explode(":", $valEmails[$i]);
			$envio = ['responsable' => $valores[1],'email' =>$valores[0], 'subject' =>$textoContent];
			if ($fono=="0") {
				$viewEmail = 'emails.localCerrado';
			}else{
				$viewEmail = 'emails.formatoEmail';
			}
			\Mail::send($viewEmail, $datai, function($message) use ($envio){
				$message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
			});
		}
		return true;

	}
	
	public function getValores()
	{
		//General
		$this->valoresCampaigne[0] = array('urlBase' => \App::make('url')->to('/'), 'urlImagesFotos' => '/media/fotos/', 'urlImageBase' => '/media/images/');

		//alicorp
		$this->valoresCampaigne[3] = array('ventanaW' => 193);
		$this->valoresCampaigne[18] = array('ventanaW' => 204);
		$this->valoresCampaigne[21] = array('ventanaW' => 250);
		$this->valoresCampaigne[15] = array('ventanaW' => 0);
		$this->valoresCampaigne[22] = array('ventanaW' => 255,'abierto' => 252,'permitio' =>254,'existeVent' => 256, 'visibleVent' =>257, 'comoEstaVent'=>258,'encontroExhi'=>0);
		$this->valoresCampaigne[29] = array('ventanaW' => 388,'abierto' => 385,'permitio' =>387,'existeVent' => 389, 'visibleVent' =>390, 'comoEstaVent'=>391,'encontroExhi'=>0);
		$this->valoresCampaigne[36] = array('ventanaW' => 491,'abierto' => 489,'permitio' =>490,'existeVent' => 492, 'visibleVent' =>493, 'comoEstaVent'=>494,'encontroExhi'=>495);
		$this->valoresCampaigne[38] = array('ventanaW' => 510,'abierto' => 508,'permitio' =>509,'existeVent' => 511, 'visibleVent' =>512, 'comoEstaVent'=>513,'encontroExhi'=>514);
		$this->valoresCampaigne[43] = array('ventanaW' => 565,'abierto' => 563,'permitio' =>564,'existeVent' => 566, 'visibleVent' =>567, 'comoEstaVent'=>568,'encontroExhi'=>569);
		$this->valoresCampaigne[46] = array('ventanaW' => 619,'abierto' => 617,'permitio' =>618,'existeVent' => 620, 'visibleVent' =>621, 'comoEstaVent'=>622,'encontroExhi'=>623);
		$this->valoresCampaigne[53] = array('ventanaW' => 758,'abierto' => 756,'permitio' =>757,'existeVent' => 759, 'visibleVent' =>760, 'comoEstaVent'=>761,'encontroExhi'=>762);
		$this->valoresCampaigne[59] = array('ventanaW' => 840,'abierto' => 838,'permitio' =>839,'existeVent' => 841, 'visibleVent' =>842, 'comoEstaVent'=>843,'encontroExhi'=>844);
		$this->valoresCampaigne[68] = array('ventanaW' => 975,'abierto' => 973,'permitio' =>974,'existeVent' => 976, 'visibleVent' =>977, 'comoEstaVent'=>978,'encontroExhi'=>979);
		$this->valoresCampaigne[71] = array('ventanaW' => 1138,'abierto' => 1136,'permitio' =>1137,'existeVent' => 1139, 'visibleVent' =>1140, 'comoEstaVent'=>1141,'encontroExhi'=>1142);
		$this->valoresCampaigne[75] = array('ventanaW' => 1237,'abierto' => 1235,'permitio' =>1236,'existeVent' => 1238, 'visibleVent' =>1239, 'comoEstaVent'=>1240,'encontroExhi'=>1241);
		$this->valoresCampaigne[81] = array('ventanaW' => 1381,'abierto' => 1379,'permitio' =>1380,'existeVent' => 1382, 'visibleVent' =>1383, 'comoEstaVent'=>1384,'encontroExhi'=>1385);
		return $this->valoresCampaigne;
	}

	public function getCategoryProductCampaigne()
	{
		$this->categoryProductCampaigne = array(59,60,61,62);
		return $this->categoryProductCampaigne;
	}

	public function generateMenusBayer($company_id,$audit_id, $cat="0")
	{
		$AuditsCompany = $this->getAuditForCompany($company_id);
		$campaigne = $this->companyRepo->find($company_id);//dd($campaigne);

		$submenu1 = [];
		if (($audit_id == 0) and ($cat=="0"))
		{
			if ($campaigne->active==1){
				$menus[] = array('nombre' => 'Resumen Período', 'url' => route('reportBayer'), 'active' => 1,'icon' => 'inicio', 'submenu1' => $submenu1);
			}else{
				$menus[] = array('nombre' => 'Resumen Período', 'url' => route('reportBayer',$company_id), 'active' => 1,'icon' => 'inicio', 'submenu1' => $submenu1);
			}

		}else{
			if ($campaigne->active==1){
				$menus[] = array('nombre' => 'Resumen Período', 'url' => route('reportBayer'), 'active' => 0,'icon' => 'inicio', 'submenu1' => $submenu1);
			}else{
				$menus[] = array('nombre' => 'Resumen Período', 'url' => route('reportBayer',$company_id), 'active' => 0,'icon' => 'inicio', 'submenu1' => $submenu1);
			}

		}
		foreach ($AuditsCompany as $audit)
		{
			if ($audit_id == $audit->id)
			{

				if (($audit->id == 14) and ($cat=="4")){
					$submenu1[0] = array('nombre' => "Marcas Moderno", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Moderno')), 'active' => 1,'icon' => 'ok');
				}else{
					$submenu1[0] = array('nombre' => "Marcas Moderno", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Moderno')), 'active' => 0,'icon' => 'ok');
				}
				if (($audit->id == 14) and ($cat=="5")){
					$submenu1[1] = array('nombre' => "Marcas Tradicional", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Tradicional')), 'active' => 1,'icon' => 'ok');
				}else{
					$submenu1[1] = array('nombre' => "Marcas Tradicional", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Tradicional')), 'active' => 0,'icon' => 'ok');
				}
				$menus[] = array('nombre' => $audit->fullname, 'url' => '', 'active' => 1,'icon' => 'menos', 'submenu1' => $submenu1);
			}else{
				if ($cat=='6'){
					$submenu1[0] = array('nombre' => "Marcas Moderno", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Moderno')), 'active' => 0,'icon' => 'ok');
					$submenu1[1] = array('nombre' => "Marcas Tradicional", 'url' => route('auditReportBayer', array($audit->id, $company_id,'Tradicional')), 'active' => 0,'icon' => 'ok');
					$menus[] = array('nombre' => $audit->fullname, 'url' => '', 'active' => 1,'icon' => 'menos', 'submenu1' => $submenu1);
				}else{
					$menus[] = array('nombre' => $audit->fullname, 'url' => route('reportBayer', array($company_id,'0/6')), 'active' => 0,'icon' => 'mas', 'submenu1' => $submenu1);
				}
			}
			unset($submenu1);
			$submenu1=[];
		}

		/*if (($audit_id == 0) and ($cat=="2"))
		{
			$menus[] = array('nombre' => "Rep. de Ventas", 'url' => route('getSellersCampaigne', array( $company_id,534)), 'active' => 1,'icon' => 'audit', 'submenu1' => $submenu1);
		}else{
			$menus[] = array('nombre' => "Rep. de Ventas", 'url' => route('getSellersCampaigne', array( $company_id,534)), 'active' => 0,'icon' => 'audit', 'submenu1' => $submenu1);
		}*/
		if (($audit_id == 0) and ($cat=="3"))
		{
			$menus[] = array('nombre' => "Histórico por Ejecutivo", 'url' => route('traderMarkReport', array( $company_id,0)), 'active' => 1,'icon' => 'audit', 'submenu1' => $submenu1);
		}else{
			$menus[] = array('nombre' => "Histórico por Ejecutivo", 'url' => route('traderMarkReport', array( $company_id,0)), 'active' => 0,'icon' => 'audit', 'submenu1' => $submenu1);
		}

		if ($company_id==73)
		{
			$menus[] = array('nombre' => 'Reporte Excel', 'url' => 'http://ttaudit.com/reportes_excel/reporte_bayer_73.php', 'active' => 0,'icon' => 'materiales');
		}
//dd($menus);

		if (($audit_id == 0) and ($cat=="1"))
        {
            $menus[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForBayer', array( $company_id)), 'active' => 1,'icon' => 'audit', 'submenu1' => $submenu1);
        }else{
            $menus[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForBayer', array( $company_id)), 'active' => 0,'icon' => 'audit', 'submenu1' => $submenu1);
        }
		//dd($menus[1]);
		return $menus;
	}

	public function generateMenusInterbank($company_id,$audit_id, $cat="0")
	{
		$AuditsCompany = $this->getAuditForCompany($company_id);

		if (($audit_id == 0) and ($cat=="0"))
		{
			$menus[] = array('nombre' => 'Home', 'url' => route('report'), 'active' => 1,'icon' => 'inicio');
		}else{
			$menus[] = array('nombre' => 'Home', 'url' => route('report'), 'active' => 0,'icon' => 'inicio');
		}
		if ($company_id==84){
			$menus[] = array('nombre' => 'Reporte Excel', 'url' => 'http://ttaudit.com/reportes_excel/reporte_company_84.php', 'active' => 0,'icon' => 'materiales');
		}



		foreach ($AuditsCompany as $audit)
		{
			if ($audit_id == $audit->id)
			{
				$menus[] = array('nombre' => $audit->fullname, 'url' => route('auditReport', array($audit->id)), 'active' => 1,'icon' => 'audit');
			}else{
				$menus[] = array('nombre' => $audit->fullname, 'url' => route('auditReport', array($audit->id)), 'active' => 0,'icon' => 'audit');
			}
		}//dd($menus);
		if (Auth::user()->type<>'executive'){
			if (($audit_id == 0) and ($cat=="1"))
			{
				$menus[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForIbk', array( $company_id)), 'active' => 1,'icon' => 'audit');
			}else{
				$menus[] = array('nombre' => "Rutas asignadas", 'url' => route('getRoadForIbk', array( $company_id)), 'active' => 0,'icon' => 'audit');
			}
		}
		if (($audit_id == 0) and ($cat=="2"))
		{
			$menus[] = array('nombre' => "Listar Notificaciones", 'url' => route('listAlerts', array( 1)), 'active' => 1,'icon' => 'audit');
		}else{
			$menus[] = array('nombre' => "Listar Notificaciones", 'url' => route('listAlerts', array( 1)), 'active' => 0,'icon' => 'audit');
		}

		return $menus;
	}

	public function getResponsePolls($store_id,$company_id,$publicity_id,$poll_id,$type,$product_id="0")
	{
		if ($type == 'YesNo')
		{
			if ($publicity_id==0){
				if ($product_id =="0")
				{
					$storeOpen = $this->PollDetailRepo->getRegForStoreCompanyPoll($store_id,$company_id,$poll_id);
				}else{
					$storeOpen = $this->PollDetailRepo->getRegForStoreCompanyPoll($store_id,$company_id,$poll_id,$product_id);
				}

			}else{
				$storeOpen = $this->PollDetailRepo->getResultForStore($company_id,$store_id,$poll_id,$publicity_id);
			}

			$cantReg = count($storeOpen);//dd($storeOpen[0]);
			/*if ($publicity_id==403){
				dd($company_id);
			}*/
			if ($cantReg>0)
			{
				if ($storeOpen[0]->result==1){
					$texto = "Sí (".$storeOpen[0]->created_at.")";
				}else{
					$texto = "No (".$storeOpen[0]->created_at.")";
				}
				$responses = array('texto' => $texto,'objeto' => $storeOpen);
			}else{
				$responses = array('texto' => "No hay ingreso",'objeto' => 0);
			}
		}
		if ($type == 'Option')
		{
			$storeComoEsta = $this->PollDetailRepo->getResultForStore($company_id,$store_id,$poll_id,$publicity_id);//dd($storeComoEsta);
			$cantReg = count($storeComoEsta);
			if ($cantReg>0)
			{
				$responseOption = $this->PollOptionDetailRepo->getResponseOptionPublicity($store_id,$poll_id,$publicity_id,$company_id);//dd($responseOption);
				$cantReg = count($responseOption);
				if ($cantReg>0)
				{
					$texto = "Opciones seleccionadas"."<br>";
					$texto .= "<ul>";
					foreach ($responseOption as $option)
					{
						$texto .= "<li>".$option->options."(".$option->id.") - ".$option->created_at."</li>";
						$id = $option->id;
						$poll_option_details_id = $option->poll_option_details_id;
					}
					$texto .= "</ul>";
				}else{
					$texto = "No Hay Opciones ingresadas ";$id=0;$poll_option_details_id=0;
				}
				$responses = array('texto' => $texto,'objeto' => $storeComoEsta,'options' => $responseOption, 'id' =>$id ,'poll_option_details_id' => $poll_option_details_id);
			}else{
				$responses = array('texto' => 'No hay registros','objeto' => 0,'options' => 0, 'id' => 0 );
			}
		}
		return $responses;
	}

	public function getResponsesForPoll($store_id,$company_id,$publicity_id,$poll_id,$product_id="0")
	{
		$objPoll_details = $this->PollDetailRepo->getResultForStore($company_id,$store_id,$poll_id,$publicity_id,$product_id);//dd(count($poll_details));
		if (count($objPoll_details)>0)
		{
			$poll_options=$this->PollOptionRepo->getOptions($poll_id);
			foreach ($objPoll_details as $poll_detail) {
				if (count($poll_options)>0)
				{
					$nohayOpciones=0;
					foreach ($poll_options as $poll_option) {
						$poll_option_detail = $this->PollOptionDetailRepo->getPollOptionDetail($poll_detail->store_id,$poll_option->id,$poll_detail->company_id,$poll_detail->product_id,$poll_detail->publicity_id);
						if (count($poll_option_detail)>0)
						{
							$pollOptionDetails[] = $poll_option_detail;
						}else{
							$nohayOpciones ++;
						}
						if ($nohayOpciones==count($poll_options)){
							$pollOptionDetails = [];
						}
					}
				}else{
					$pollOptionDetails = [];
				}
				$pollDetails[] = array('poll_detail' => $poll_detail, 'poll_option_details' => $pollOptionDetails);unset($pollOptionDetails);
			}
			$responses = array('poll_details' => $pollDetails, 'options' => $poll_options);//dd($pollDetails);
		}else{
			$responses = [];
		}
		return $responses;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	public function getVisitorForUsers($company_id)
	{
		$users = $this->UserCompanyRepo->getUsersForCompany($company_id);$sumOptions=0;
		foreach ($users as $user) {
			$countVisities = $this->visitorRepo->getCountVisitForUser($user->user_id);
			$sumOptions = $sumOptions + $countVisities;
		}
		foreach ($users as $user_company) {
			$countVisities = $this->visitorRepo->getCountVisitForUser($user_company->user_id);
			$porUser = ($countVisities / $sumOptions) * 100;
			$ValRespuesta = trim($user_company->user->fullname);
			$totalOptions[] = array('cantidad' => $countVisities,'respuesta' => $ValRespuesta,  "porcentaje" => round($porUser, 0));
		}
		arsort($totalOptions);//dd($totalOptions);
		foreach ($totalOptions as $totalOptions1) {
			$totalOrdenado[] = array('respuesta' => $totalOptions1['respuesta'], 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
		}
		return $totalOrdenado;
	}
	
	public function getTotalOptionForPollId($poll_id,$total,$product_id="0",$ejecutivo="0",$ubigeoext="0",$cadena="0",$nuevoTotal="0",$horizontal="0")
	{
		$options= $this->PollOptionRepo->getOptions($poll_id);$sumOptions=0;//dd($options[0]);
		if ($nuevoTotal <> "0")
		{
			foreach ($options as $option) {
				if ($product_id<>"0")
				{
					if (($option->product_id == $product_id) or ($option->product_id==0))
					{
						$cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product_id,$ubigeoext,$cadena,$horizontal);
						$sumOptions = $sumOptions + $cantidadOption;
					}
				}

			}
		}

		foreach ($options as $option) {
			if ($product_id<>"0")
			{
				if (($option->product_id == $product_id) or ($option->product_id==0))
				{
					$cantidadOption = $this->PollOptionDetailRepo->getTotalOption($option->id, "0","0",$ejecutivo,"0","0",$product_id,$ubigeoext,$cadena,$horizontal);
					if ($total <> 0) {
						$porcOpcion = ($cantidadOption / $total) * 100;
					} else {
						if (($nuevoTotal <> "0") and ($sumOptions>0))
						{
							$porcOpcion = ($cantidadOption / $sumOptions) * 100;
						}else{
							$porcOpcion = 0;
						}
					}
					if ($cantidadOption>0){
						$ValRespuesta = trim($option->options);
						$totalOptions[] = array('cantidad' => $cantidadOption,'respuesta' => $ValRespuesta,  "porcentaje" => round($porcOpcion, 0));
					}

				}
			}

		}
		arsort($totalOptions);//dd($totalOptions);
		foreach ($totalOptions as $totalOptions1) {
			$totalOrdenado[] = array('respuesta' => ucwords(strtolower($totalOptions1['respuesta'])), 'cantidad' => $totalOptions1['cantidad'], "porcentaje" => $totalOptions1['porcentaje']);
		}
		return $totalOrdenado;
	}

	public function getTotalPriorityForPollId($poll_id,$company_id,$product_id="0",$ejecutivo="0",$ubigeoext="0",$cadena="0",$horizontal="0")
	{
		$options= $this->PollOptionRepo->getOptions($poll_id);
		$cantidadOption=0;
		foreach ($options as $option) {
			if (($option->product_id == $product_id) or ($option->product_id==0))
			{
				$totalopciones =0;
				for ($i = 1; $i <= 10; $i++)
				{
					$cantidadOption = $this->PollOptionDetailRepo->getTotalPriority($company_id,$i,$option->codigo, "0","0",$ejecutivo,"0","0",$product_id,$ubigeoext,$cadena,$horizontal);
					if ($i==1){
						$valor1 = $cantidadOption;$totalopciones = $totalopciones +$valor1;
					}
					if ($i==2){
						$valor2 = $cantidadOption;$totalopciones = $totalopciones +$valor2;
					}
					if ($i==3){
						$valor3 = $cantidadOption;$totalopciones = $totalopciones +$valor3;
					}
				}$sumaopciones = $valor1 + $valor2 + $valor3;
				$ValRespuesta = trim($option->options);
				if ($sumaopciones>0){
					$totalOptions[] = array("total" => $sumaopciones,"tipo" => $ValRespuesta."[".$totalopciones."]", "Prioridad 1" => $valor1, "Prioridad 2" => $valor2, "Prioridad 3" => $valor3);
				}
			}
		}
		arsort($totalOptions);//dd($totalOptions);
		foreach ($totalOptions as $totalOptions1) {
			$totalOrdenado[] = array("tipo" => ucwords(strtolower($totalOptions1['tipo'])), "Prioridad 1" => $totalOptions1['Prioridad 1'], "Prioridad 2" => $totalOptions1['Prioridad 2'], "Prioridad 3" => $totalOptions1['Prioridad 3']);
		}//dd($totalOrdenado);
		return $totalOrdenado;
	}

	public function getStoresDetailSiNo($poll_id,$poll_option_id,$urlBase,$urlImages,$valores,$product_id="0",$company_id="0",$publicity_id="0",$soloPhotos="0")
	{
		//getDetailSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0,$product_id="0",$ubigeo="0",$cadena="0")
		//getDetailSiNo($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[6],$product_id,$valores[4],$valores[5]);
		/*$city = $valores[0];
		$district = $valores[1];
		$ejecutivo = $valores[2];
		$rubro = $valores[3];
		$ubigeo = $valores[4];
		$cadena = $valores[5];
		$pregSino = $valores[6];
		$dex = $valores[7];
		$tipoBodega = $valores[8];
		$horizontal = $valores[9];*/
		if ($poll_option_id == "0") {
			if (count($valores)>5){
				if ($publicity_id=="0"){
					if ($valores[4]<>"0"){
						$ubigeo= explode("|",$valores[4]);
					}else{
						$ubigeo= "0";
					}
					if ($valores[5]<>"0"){
						$cadena= explode("|",$valores[5]);
					}else{
						$cadena= "0";
					}
					if ($valores[9]<>"0"){
						$horizontal= explode("|",$valores[9]);
					}else{
						$horizontal= "0";
					}
					$stores = $this->PollDetailRepo->getDetailSiNo($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[6],$product_id,$ubigeo,$cadena,$valores[7],$valores[8],"0",$horizontal);
					                               //getDetailSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$result=0,$product_id="0",$ubigeo="0",$cadena="0",$dex="0",$tipoBodega="0",$soloPhotos="0")
				}else{
					//getDetailSiNoPublicity($poll_id,$publicity_id,$result=0,$city="0",$dex="0")
					$stores = $this->PollDetailRepo->getDetailSiNoPublicity($poll_id,$publicity_id,$valores[6],$valores[0],$valores[7],$valores[8]);
				}

				//bayer: $valCiudad = "0-0-0-0-".$ubigeoext.'-'.$cadena  route('getDetailQuestionBayer', "106/".$valores."-0"."/".$company_id."/0"
			}else{
				$stores = $this->PollDetailRepo->getDetailSiNo($poll_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[4],$product_id,"0","0","0","0",$soloPhotos);//IBK
			}
		}
		if ($poll_option_id <> "0") {
			if (count($valores)>5){
				if ($publicity_id=="0"){
					if ($valores[4]<>"0"){
						$ubigeo= explode("|",$valores[4]);
					}else{
						$ubigeo= "0";
					}
					if ($valores[5]<>"0"){
						$cadena= explode("|",$valores[5]);
					}else{
						$cadena= "0";
					}
					if ($valores[9]<>"0"){
						$horizontal= explode("|",$valores[9]);
					}else{
						$horizontal= "0";
					}
					$stores = $this->PollOptionDetailRepo->getDetailOption($poll_option_id,$valores[0],$valores[1],$valores[2],$valores[3],$ubigeo,$product_id,$cadena,$valores[6],$horizontal);
				}else{
					//getDetailOptionPublicity($poll_option_id,$publicity_id,$city="0",$dex="0",$tipoBodega="0")
					$stores = $this->PollOptionDetailRepo->getDetailOptionPublicity($poll_option_id,$publicity_id,$valores[0],$valores[7],$valores[8]);
				}
				
			}else{
				$stores = $this->PollOptionDetailRepo->getDetailOption($poll_option_id,$valores[0],$valores[1],$valores[2],$valores[3],$valores[4]);
			}
			//getTotalSiNo($poll_id,$city="0",$district="0",$ejecutivo="0",$rubro="0",$store_id="0",$product_id="0",$ubigeo="0",$cadena="0")
		}


		if(! empty($stores)){
			foreach ($stores as $store){
				$datosFoto[] = null;
				$photos = $this->MediaRepo->photosProductPollStore($poll_id, $store->id,$company_id,$product_id,$publicity_id);

				if(! empty($photos)){
					//dd($photos);
					//dd(\App::make('url')->to('/'));
					foreach ($photos as $photo){
						$datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $urlBase.$urlImages.$photo->archivo);
					}

				}else{
					$datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
				}
				if ($soloPhotos ==1)
				{
					$campaigne = $this->companyRepo->find($company_id);
					$customer_id=$campaigne->customer_id;
					if ($customer_id==1)
					{
						$id_company=0;
					}else{
						$id_company=$company_id;
					}
					$objPollRepo = $this->pollRepo->find($poll_id);
					if ($objPollRepo->sino ==1){
						$responseSiNo = $this->getResponsePolls($store->id,$id_company,$publicity_id,$poll_id,'YesNo');
					}else{
						$responseSiNo=[];
					}
					if ($objPollRepo->options ==1){
						$reponseOption = $this->getResponsePolls($store->id,$id_company,$publicity_id,$poll_id,'Option');
					}else{
						$reponseOption=[];
					}
				}


				$otherComents = $this->PollDetailRepo->getCommentQuestion(1018,$store->id);//8->63,10->95,12->134
				//dd($otherComents);
				if ($soloPhotos <>1)
				{
					if ($poll_option_id <> 0) {
						$datosStores[] = array('store_id' => $store->id, 'cadenaRuc' => $store->cadenaRuc,'type' =>$store->type,'codclient' => $store->codclient,'tipo_bodega' => $store->tipo_bodega,'distributor' => $store->distributor,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->comentario, 'otroComentario' => $otherComents, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
					}else{
						$datosStores[] = array('store_id' => $store->id, 'cadenaRuc' => $store->cadenaRuc,'type' =>$store->type,'codclient' => $store->codclient,'tipo_bodega' => $store->tipo_bodega,'distributor' => $store->distributor,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->comentario, 'otroComentario' => $otherComents, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
					}
				}else{
					if ($poll_option_id <> 0) {
						$datosStores[] = array('reponseOption'=>$reponseOption,'responseSiNo'=>$responseSiNo,'store_id' => $store->id, 'cadenaRuc' => $store->cadenaRuc,'type' =>$store->type,'codclient' => $store->codclient,'tipo_bodega' => $store->tipo_bodega,'distributor' => $store->distributor,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->comentario, 'otroComentario' => $otherComents, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
					}else{
						$datosStores[] = array('reponseOption'=>$reponseOption,'responseSiNo'=>$responseSiNo,'store_id' => $store->id, 'cadenaRuc' => $store->cadenaRuc,'type' =>$store->type,'codclient' => $store->codclient,'tipo_bodega' => $store->tipo_bodega,'distributor' => $store->distributor,'fullname' =>$store->fullname, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district, 'comentario' => $store->comentario, 'otroComentario' => $otherComents, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
					}
				}

				//dd($datosStores);
				unset($datosFoto);
			}
			//dd($datosStores);

		}else{
			$datosStores[] = array('store_id' => '0', 'codclient' => '', 'departamento' => '', 'Provincia' => '', 'distrito' => '', 'arrayFoto' => '');
		}
		return $datosStores;
	}


	public function getDeatailWinnersBayer($poll_id,$urlBase,$urlImages,$valores,$company_id)
	{
		$stores = $this->ScoreRepo->getDetailWinners($company_id,"0",$valores[4],$valores[5],$valores[2]);//dd($stores);
		if(count($stores)>0){//dd("uno");
			foreach ($stores as $store){
				$photos = $this->MediaRepo->photosProductPollStore($poll_id, $store->id,$company_id,0);

				if(! empty($photos)){
					//dd($photos);
					//dd(\App::make('url')->to('/'));
					foreach ($photos as $photo){
						$datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $urlBase.$urlImages.$photo->archivo);
					}

				}else{
					$datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
				}

				$datosStores[] = array('store_id' => $store->id, 'tipo' => $store->type,'cadenaRuc' =>$store->cadenaRuc, 'fullname' => $store->fullname, 'direccion' => $store->address, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district,'auditor_id' => $store->user_id,'auditor' => $store->auditor, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
				//dd($datosStores);
				unset($datosFoto);
			}
			//dd($datosStores);
		}else{
			$datosStores[] = array('store_id' => '0', 'codclient' => '', 'departamento' => '', 'Provincia' => '', 'distrito' => '', 'arrayFoto' => '');
		}//dd($datosStores);
		return $datosStores;
	}

	public function getDetailPublicitiesAlicorp($publicity_id,$contaminated,$urlBase,$urlImages,$valores,$company_id)
	{
		$stores = $this->PublicitiesDetailRepo->getDetailPublicity($publicity_id,$company_id,$contaminated,$valores[0],$valores[7]);//dd($stores);
		//getDetailPublicity($publicity_id,$company_id,$contaminado,$city="0",$dex="0",$type_store="0")
		if(count($stores)>0){
			foreach ($stores as $store){
				$photos = $this->MediaRepo->photosPublicityStore($publicity_id, $store->id,$company_id);

				if(! empty($photos)){
					//dd($photos);
					//dd(\App::make('url')->to('/'));
					foreach ($photos as $photo){
						$datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $urlBase.$urlImages.$photo->archivo);
					}

				}else{
					$datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
				}

				$datosStores[] = array('store_id' => $store->id, 'tipo' => $store->type, 'tipo_bodega' => $store->tipo_bodega,'cadenaRuc' =>$store->cadenaRuc, 'fullname' => $store->fullname, 'direccion' => $store->address, 'departamento' => $store->ubigeo, 'Provincia' => $store->region, 'distrito' => $store->district,'dex' => $store->distributor, 'arrayFoto' => $datosFoto, 'fecha' => $store->created_at);
				//dd($datosStores);
				unset($datosFoto);
			}
			//dd($datosStores);
		}else{
			$datosStores[] = array('store_id' => '0', 'codclient' => '', 'departamento' => '', 'Provincia' => '', 'distrito' => '', 'arrayFoto' => '');
		}//dd($datosStores);
		return $datosStores;
	}

    public function getCompanies()
    {
        $companies= New CompanyRepo;
        return $companies->allReg()->lists('fullname', 'id');
    }

	public function getAuditForCompany($company_id)
	{
		$CompanyAuditRepo = New CompanyAuditRepo;
		$auditsForCompany = $CompanyAuditRepo->getAuditsForCompany($company_id);//dd($auditsForCompany);
		if (count($auditsForCompany)>0){
			foreach ($auditsForCompany as $auditForCompany){
				$AuditRepo = new AuditRepo;
				$AuditsCompany[]=$AuditRepo->find($auditForCompany->audit_id);
			}
			//dd($AuditsCompany);
		}
		return $AuditsCompany;
	}

	public function generateMenusAudits($audit_id, $company_id,$tipo="0")
	{
		$AuditsCompany = $this->getAuditForCompany($company_id);

		if (($audit_id == 0) and ($tipo=="0"))
		{
			$menus[] = array('nombre' => 'Home', 'url' => route('auditsForCampaign', array($company_id)), 'active' => 1);
		}else{
			$menus[] = array('nombre' => 'Home', 'url' => route('auditsForCampaign', array($company_id)), 'active' => 0);
		}


		foreach ($AuditsCompany as $audit)
		{
			if ($audit_id == $audit->id)
			{
				$menus[] = array('nombre' => $audit->fullname, 'url' => route('auditListStoresForAudit', array($audit->id, $company_id)), 'active' => 1);
			}else{
				$menus[] = array('nombre' => $audit->fullname, 'url' => route('auditListStoresForAudit', array($audit->id, $company_id)), 'active' => 0);
			}
		}
		if (($audit_id == 0) and ($tipo == 1))
		{
			$menus[] = array('nombre' => 'Reporte en Excel', 'url' => route('excelCompanies', array($company_id,0)), 'active' => 1,'icon' => 'inicio');
		}else{
			$menus[] = array('nombre' => 'Reporte en Excel', 'url' => route('excelCompanies', array($company_id,0)), 'active' => 0);
		}
		if (($audit_id == 0) and ($tipo == 2))
		{
			$menus[] = array('nombre' => 'Fotos de Preguntas', 'url' => route('getDetailsPhotosForQuestion', array($company_id)), 'active' => 1,'icon' => 'inicio');
		}else{
			$menus[] = array('nombre' => 'Fotos de Preguntas', 'url' => route('getDetailsPhotosForQuestion', array($company_id)), 'active' => 0);
		}
		return $menus;
	}

	public function getPhotos($poll_id,$store_id,$company_id,$product_id="0",$publicity_id="0",$category_product_id="0")
	{
		$photos = $this->MediaRepo->photosProductPollStore($poll_id,$store_id,$company_id,$product_id,$publicity_id,$category_product_id);
		$valores = $this->getValores();
		$url_ruta = $valores[0]['urlBase'].$valores[0]['urlImagesFotos'];
		if(! empty($photos)){
			//dd($photos);
			//dd(\App::make('url')->to('/'));
			foreach ($photos as $photo){
				$datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $url_ruta.$photo->archivo);
			}
		}else{
			$datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
		}
		return $photos;
	}

	public function saveSessions()
	{
		$tiempo_transcurrido = time();

		$wo_direccion_ip = $_SERVER['REMOTE_ADDR'];
		$wo_url_actual = \App::make('url')->to('/')."/".Request::path();
		$wo_navegador=$_SERVER['HTTP_USER_AGENT'];
		$xx_mins_ago = ($tiempo_transcurrido - 360);

		$wo_sesion_id = Session::getId();
		$mytime = Carbon\Carbon::now();
		if (Auth::check()){
			$wo_idcliente = Auth::user()->id;
			$countSession = $this->visitorRepo->getCountSession(addslashes($wo_sesion_id));
			if ($countSession>0){
				$visitor = $this->visitorRepo->getVisitorForSession(addslashes($wo_sesion_id));
				$visitorObj = $visitor[0];//dd($visitorObj);
				$visitorObj->user_id = $wo_idcliente;
				$visitorObj->nombre_completo = Auth::user()->fullname;
				$visitorObj->ip = $wo_direccion_ip;
				$visitorObj->tiempo_accion_click = addslashes($tiempo_transcurrido);
				$visitorObj->url_actual = addslashes($wo_url_actual);
				$visitorObj->navegador = addslashes($wo_navegador);
				$visitorObj->hora_salida = $mytime->format('h:i:s');
				$visitorObj->save();
			}else{
				$visitorObj = $this->visitorRepo->getModel();
				$visitorObj->user_id = $wo_idcliente;
				$visitorObj->nombre_completo = Auth::user()->fullname;
				$visitorObj->session_id= $wo_sesion_id;
				$visitorObj->ip = $wo_direccion_ip;
				$visitorObj->tiempo_entrada = addslashes($tiempo_transcurrido);
				$visitorObj->tiempo_accion_click = addslashes($tiempo_transcurrido);
				$visitorObj->url_actual = $wo_url_actual;
				$visitorObj->navegador = $wo_navegador;
				$visitorObj->fecha_ingreso = $mytime->format('Y-m-d');
				$visitorObj->hora_ingreso = $mytime->format('h:i:s');
				$visitorObj->hora_salida = $mytime->format('h:i:s');
				$visitorObj->save();
			}

		}else{
			$wo_full_nombre = 'invitado';
			$this->visitorRepo->deleteForTime($xx_mins_ago);
			$countSession = $this->visitorRepo->getCountSession(addslashes($wo_sesion_id));

			if ($countSession > 0) {
				//Actualiza los clientes en linea
				$visitor = $this->visitorRepo->getVisitorForSession(addslashes($wo_sesion_id));
				$visitorObj = $visitor[0];
				$visitorObj->nombre_completo = $wo_full_nombre;
				$visitorObj->ip = $wo_direccion_ip;
				$visitorObj->tiempo_accion_click = addslashes($tiempo_transcurrido);
				$visitorObj->url_actual = addslashes($wo_url_actual);
				$visitorObj->navegador = addslashes($wo_navegador);
				$visitorObj->hora_salida = $mytime->format('h:i:s');
				$visitorObj->save();
			} else {
				//Inserta nuevo usuario en linea
				$visitorObj = $this->visitorRepo->getModel();
				$visitorObj->nombre_completo = $wo_full_nombre;
				$visitorObj->session_id= $wo_sesion_id;
				$visitorObj->ip = $wo_direccion_ip;
				$visitorObj->tiempo_entrada = addslashes($tiempo_transcurrido);
				$visitorObj->tiempo_accion_click = addslashes($tiempo_transcurrido);
				$visitorObj->url_actual = $wo_url_actual;
				$visitorObj->navegador = $wo_navegador;
				$visitorObj->fecha_ingreso = $mytime->format('Y-m-d');
				$visitorObj->hora_ingreso = $mytime->format('h:i:s');
				$visitorObj->hora_salida = $mytime->format('h:i:s');
				$visitorObj->save();
			}
		}

	}
}

<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auditor\Repositories\PollDetailRepo;
use Auditor\Repositories\PollOptionRepo;
use Auditor\Repositories\PollOptionDetailRepo;
use Auditor\Repositories\PollRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\PublicityRepo;

class PollDetailController extends BaseController {
	protected $PollDetailRepo;
	protected $PollOptionRepo;
	protected $PollOptionDetailRepo;
	protected $PollRepo;
	protected $UserRepo;
	protected $campaigneRepo;
	protected $customerRepo;
	protected $StoreRepo;
	protected $publicityRepo;

	public function __construct(PublicityRepo $publicityRepo,StoreRepo $StoreRepo, CustomerRepo $customerRepo, CompanyRepo $campaigneRepo,UserRepo $UserRepo,PollRepo $PollRepo,PollOptionDetailRepo $PollOptionDetailRepo,PollOptionRepo $PollOptionRepo,PollDetailRepo $PollDetailRepo)
	{
		$this->PollDetailRepo = $PollDetailRepo;
		$this->PollOptionRepo = $PollOptionRepo;
		$this->PollOptionDetailRepo = $PollOptionDetailRepo;
		$this->PollRepo = $PollRepo;
		$this->UserRepo = $UserRepo;
		$this->campaigneRepo = $campaigneRepo;
		$this->customerRepo = $customerRepo;
		$this->StoreRepo = $StoreRepo;
		$this->publicityRepo = $publicityRepo;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$objPollDetail = $this->PollDetailRepo->getModel();
		//$objPollDetail->poll_id = 34;
		$valoresPost= Input::all();//dd($valoresPost);
		$poll_id = $valoresPost['poll_id'];
		$store_id= $valoresPost['store_id'];
		$sino= $valoresPost['sino'];
		$options= $valoresPost['options'];
		$limits= $valoresPost['limits'];
		$media= $valoresPost['media'];
		$coment= $valoresPost['coment'];
		$result= $valoresPost['result'];
		$limite= $valoresPost['limite'];
		$comentario= $valoresPost['comentario'];
		$auditor= $valoresPost['auditor'];
		$product_id= $valoresPost['product_id'];
		$publicity_id= $valoresPost['publicity_id'];
		$company_id = $valoresPost['company_id'];
		$selectedOptions = $valoresPost['selectedOptions'];
		$selectedOptionsComment = $valoresPost['selectedOptionsComment'];
		$priority = $valoresPost['priority'];
		$mytime = Carbon::now();
		$horaSistema = $mytime->toDateTimeString();

		$objPollDetail->poll_id = $poll_id;//dd($objPollDetail->poll_id);
		$objPollDetail->store_id = $store_id;
		$objPollDetail->product_id = $product_id;
		$objPollDetail->publicity_id = $publicity_id;
		$objPollDetail->company_id = $company_id;
		$valor = $this->PollDetailRepo->searchPollDetail($objPollDetail);//dd($objPollDetail);
		$objPoll=$this->PollRepo->find($poll_id);
		$objAuditor = $this->UserRepo->find($auditor);
		$datoAuditor = $objAuditor->fullname."(".$auditor.")";
		$campaigneDetail = $this->campaigneRepo->find($company_id);//dd($campaigneDetail);
		$customer =$this->customerRepo->find($campaigneDetail->customer_id);
		$cliente = $customer->corto;
		$textoContent = $campaigneDetail->fullname."".$objPoll->question." - Id= ".$store_id;
		$objStore = $this->StoreRepo->find($store_id);
		$tipo_bodega = $objStore->tipo_bodega;
		$agente = $objStore->fullname;
		$dir = $objStore->codclient;
		$address = $objStore->address;
		$district = $objStore->district." - ".$objStore->region." - ".$objStore->ubigeo;
		$foto = "";
		$fono = $objStore->telephone."/".$objStore->cell;
		$fechaHoraEnvio = $horaSistema;

		if ($cliente=='interbank'){
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - DIR: ".$dir." StoreId: ".$store_id;
		}

		if ($cliente=='alicorp'){
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - StoreId: ".$store_id;
		}

		if ($cliente=='bayer'){
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - CADENA: ".$objStore->cadenaRuc." StoreId: ".$store_id;
		}

		if (count($valor)==0){
			$objPollDetail->sino = $sino;
			$objPollDetail->options = $options;
			$objPollDetail->limits = $limits;
			$objPollDetail->media = $media;
			$objPollDetail->coment = $coment;
			$objPollDetail->result = $result;
			$objPollDetail->limite = $limite;
			$objPollDetail->comentario = $comentario;
			$objPollDetail->auditor = $auditor;
			$objPollDetail->save();
			$idPollDetail = $objPollDetail->id;

			//send emails
			if ($result == 0){
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp. NO('.$idPollDetail.')';
			}else{
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp SI('.$idPollDetail.')';
			}
			$questions = $this->getQuestionsSendEmail();
			foreach ($questions as $question)
			{
				if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['send']==1))
				{
					if ($result == $question['result'])
					{
						$gruposEmails = $this->getGroupsEmails();
						$mascaras = explode('|',$question['mask']);
						for($i=0;$i<count($mascaras);$i++) {
							$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
							$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
						}
						//sendEmails($store_id,$textoContent,$motivo,$auditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails)
					}

				}
			}
			//end send emails
		}else{
			$valor->sino = $sino;
			$valor->options = $options;
			$valor->limits = $limits;
			$valor->media = $media;
			$valor->coment = $coment;
			$valor->result = $result;
			$valor->limite = $limite;
			$valor->comentario = $comentario;
			$valor->auditor = $auditor;
			$valor->update();
			$idPollDetail = $valor->id;
		}
		$objPollDetailSearch = $this->PollDetailRepo->getModel();
		$ObjSearchPollDetail = $objPollDetailSearch::find($idPollDetail);//dd($selectedOptions);
		if ($ObjSearchPollDetail->options==1)
		{
			$opciones = explode('|',$selectedOptions);$c=0;
			$comentOpcion = explode('|',$selectedOptionsComment);//dd($comentOpcion);
			if ($opciones[0]<>'')
			{
				foreach ($opciones as $valor) {
					if ($valor<>''){
						$consulta1 = $this->PollOptionRepo->getOptionsForPollCodigo($ObjSearchPollDetail->poll_id,$valor);//dd($consulta1);
						if (count($consulta1)>0){
							$objPollOptionDetail = $this->PollOptionDetailRepo->getModel();
							$objPollOptionDetail->poll_option_id=$consulta1[0]->id;
							$objPollOptionDetail->store_id=$store_id;
							$objPollOptionDetail->product_id=$product_id;
							$objPollOptionDetail->company_id=$company_id;
							$objPollOptionDetail->publicity_id=$publicity_id;
							$valorOption = $this->PollOptionDetailRepo->searchPollOptionDetail($objPollOptionDetail);
							if (count($valorOption)==0){
								$objPollOptionDetail->result=1;
								if (count($comentOpcion)>1){
									$objPollOptionDetail->otro=$comentOpcion[$c];
								}else{
									$objPollOptionDetail->otro=$comentOpcion[0];
								}

								$objPollOptionDetail->auditor=$auditor;
								$objPollOptionDetail->priority=$priority;
								$objPollOptionDetail->save();
								$idPollOptionDetail = $objPollOptionDetail->id;
								//send emails
								$motivo = $objPoll->question." opcion: ".$consulta1[0]->options.' ('.$idPollOptionDetail.')';
								$questions = $this->getQuestionsSendEmail();
								foreach ($questions as $question)
								{
									if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['poll_option_id']==$consulta1[0]->id))
									{
										$gruposEmails = $this->getGroupsEmails();
										$mascaras = explode('|',$question['mask']);
										for($i=0;$i<count($mascaras);$i++) {
											$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
											$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails,$fono);
										}
									}
								}
								//end send emails
							}else{
								$valorOption->result=1;
								$valorOption->otro=$comentOpcion[$c];
								$valorOption->auditor=$auditor;
								$valorOption->priority=$priority;
								$valorOption->update();
								$idPollOptionDetail = $valorOption->id;
							}
						}
						$c=$c+1;
					}
				}
			}else{
				$idPollOptionDetail=0;
			}

		}

		return Response::json([ 'success'=> 1, 'last_poll_detail_id' => $idPollDetail]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function saveRegisters()
	{
		$objPollDetail = $this->PollDetailRepo->getModel();
		//$objPollDetail->poll_id = 34;
		$valoresPost= Input::all();//dd($valoresPost);
		$poll_id = $valoresPost['poll_id'];
		$store_id= $valoresPost['store_id'];
		$sino= $valoresPost['sino'];
		$options= $valoresPost['options'];
		$limits= $valoresPost['limits'];
		$media= $valoresPost['media'];
		$coment= $valoresPost['coment'];
		$result= $valoresPost['result'];
		$limite= $valoresPost['limite'];
		$comentario= $valoresPost['comentario'];
		$auditor= $valoresPost['auditor'];
		$product_id= $valoresPost['product_id'];
		$publicity_id= $valoresPost['publicity_id'];
		$company_id = $valoresPost['company_id'];
		$category_product_id = $valoresPost['category_product_id'];
		$selectedOptions = $valoresPost['selectedOptions'];
		$selectedOptionsComment = $valoresPost['selectedOptionsComment'];
		$priority = $valoresPost['priority'];
		$mytime = Carbon::now();
		$horaSistema = $mytime->toDateTimeString();

		$objPollDetail->poll_id = $poll_id;//dd($objPollDetail->poll_id);
		$objPollDetail->store_id = $store_id;
		$objPollDetail->product_id = $product_id;
		$objPollDetail->publicity_id = $publicity_id;
		$objPollDetail->company_id = $company_id;
		$objPollDetail->category_product_id = $category_product_id;
		$valor = $this->PollDetailRepo->searchPollDetail($objPollDetail,1);//dd(count($valor));
		$objPoll=$this->PollRepo->find($poll_id);
		$objAuditor = $this->UserRepo->find($auditor);
		$datoAuditor = $objAuditor->fullname."(".$auditor.")";
		$campaigneDetail = $this->campaigneRepo->find($company_id);//dd($campaigneDetail);
		$customer =$this->customerRepo->find($campaigneDetail->customer_id);
		$cliente = $customer->corto;
		$textoContent = $campaigneDetail->fullname."".$objPoll->question." - Id= ".$store_id;
		$objStore = $this->StoreRepo->find($store_id);
		$tipo_bodega = $objStore->tipo_bodega;
		$agente = $objStore->fullname;
		$dir = $objStore->codclient;
		$address = $objStore->address;
		$fono = $objStore->telephone."/".$objStore->cell;
		$district = $objStore->district." - ".$objStore->region." - ".$objStore->ubigeo;
		$foto = "";$nomPublicity="";
		$fechaHoraEnvio = $horaSistema;

		if ($cliente=='interbank'){
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - DIR: ".$dir." StoreId: ".$store_id;
		}

		if ($cliente=='alicorp'){
			if ($publicity_id<>"0")
			{
				$objPublicity = $this->publicityRepo->find($publicity_id);
				$nomPublicity = $objPublicity->fullname;
			}
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - StoreId: ".$store_id;
		}

		if ($cliente=='bayer'){
			$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - CADENA: ".$objStore->cadenaRuc." StoreId: ".$store_id;
		}

		if (count($valor)==0){
			$objPollDetail->sino = $sino;
			$objPollDetail->options = $options;
			$objPollDetail->limits = $limits;
			$objPollDetail->media = $media;
			$objPollDetail->coment = $coment;
			$objPollDetail->result = $result;
			$objPollDetail->limite = $limite;
			$objPollDetail->comentario = $comentario;
			$objPollDetail->auditor = $auditor;
			$objPollDetail->save();
			$idPollDetail = $objPollDetail->id;

			//send emails
			if ($result == 0){
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp. NO('.$idPollDetail.')';
			}else{
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp SI('.$idPollDetail.')';
			}
			if ($nomPublicity<>""){
				$motivo .=" Publicidad: ".$nomPublicity;
			}
			$questions = $this->getQuestionsSendEmail();
			foreach ($questions as $question)
			{
				if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['send']==1))
				{
					if ($result == $question['result'])
					{
						$gruposEmails = $this->getGroupsEmails();
						$mascaras = explode('|',$question['mask']);
						for($i=0;$i<count($mascaras);$i++) {
							$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
							$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
						}
						//sendEmails($store_id,$textoContent,$motivo,$auditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails)
					}

				}
			}
			//end send emails
		}else{
			$valor->sino = $sino;
			$valor->options = $options;
			$valor->limits = $limits;
			$valor->media = $media;
			$valor->coment = $coment;
			$valor->result = $result;
			$valor->limite = $limite;
			$valor->comentario = $comentario;
			$valor->auditor = $auditor;
			$valor->update();
			$idPollDetail = $valor->id;
		}
		$objPollDetailSearch = $this->PollDetailRepo->getModel();
		$ObjSearchPollDetail = $objPollDetailSearch::find($idPollDetail);//dd($selectedOptions);
		if ($ObjSearchPollDetail->options==1)
		{
			$opciones = explode('|',$selectedOptions);$c=0;
			$comentOpcion = explode('|',$selectedOptionsComment);//dd($opciones);
			if ($opciones[0]<>'')
			{
				foreach ($opciones as $valor) {
					if ($valor<>''){
						$consulta1 = $this->PollOptionRepo->getOptionsForPollCodigo($ObjSearchPollDetail->poll_id,$valor);//dd($consulta1[0]);
						if (count($consulta1)>0){
							$objPollOptionDetail = $this->PollOptionDetailRepo->getModel();
							$objPollOptionDetail->poll_option_id=$consulta1[0]->id;
							$objPollOptionDetail->store_id=$store_id;
							$objPollOptionDetail->product_id=$product_id;
							$objPollOptionDetail->company_id=$company_id;
							$objPollOptionDetail->publicity_id=$publicity_id;
							$valorOption = $this->PollOptionDetailRepo->searchPollOptionDetail($objPollOptionDetail);
							if (count($valorOption)==0){
								$objPollOptionDetail->result=1;
								if (count($comentOpcion)>1){
									$objPollOptionDetail->otro=$comentOpcion[$c];
								}else{
									$objPollOptionDetail->otro=$comentOpcion[0];
								}

								$objPollOptionDetail->auditor=$auditor;
								$objPollOptionDetail->priority=$priority;
								$objPollOptionDetail->save();
								$idPollOptionDetail = $objPollOptionDetail->id;
								//send emails
								$motivo = $objPoll->question." (Id question: ".$objPoll->id.")"." (IdResp.: ".$idPollDetail.") opcion: ".$consulta1[0]->options.' ('.$idPollOptionDetail.')';
								$questions = $this->getQuestionsSendEmail();
								foreach ($questions as $question)
								{
									if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['poll_option_id']==$consulta1[0]->id))
									{
										$gruposEmails = $this->getGroupsEmails();
										$mascaras = explode('|',$question['mask']);
										for($i=0;$i<count($mascaras);$i++) {
											$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
											$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails,$fono);
										}
									}
								}
								//end send emails
							}else{
								$valorOption->result=1;
								$valorOption->otro=$comentOpcion[$c];
								$valorOption->auditor=$auditor;
								$valorOption->priority=$priority;
								$valorOption->update();
								$idPollOptionDetail = $valorOption->id;
							}
						}
						$c=$c+1;
					}
				}
			}else{
				$idPollOptionDetail=0;
			}

		}

		return Response::json([ 'success'=> 1, 'last_poll_detail_id' => $idPollDetail]);
	}


	public function saveExhibidorBodegaAlicorp(){
			$company_id = Input::only('company_id');
			$audit_id = Input::only('audit_id');
			$road_id = Input::only('rout_id');
			$store_id = Input::only('store_id');
			$user_id = Input::only('user_id');
			$publicity_id = Input::only('publicity_id');
			$found = Input::only('found');
			$visible = Input::only('visible');
			$contaminated = Input::only('contaminated');
			$status = Input::only('status');
			$comment = Input::only('comment');
			$mytime = Carbon::now();
			$horaSistema = $mytime->toDateTimeString();

			$sql1 = "SELECT id FROM publicity_details p 
					  where 
					  publicity_id='" . $publicity_id['publicity_id']  . "' and 
					  store_id='".$store_id['store_id']."' and 
					  user_id='".$user_id['user_id']."' and 
					  result='".$found['found']."' and 
					  visible='".$visible['visible']."' and 
					  comment='".$comment['comment']."' and 
					  contaminated='".$contaminated['contaminated']."' and 
					  company_id='".$company_id['company_id']."'";
			$consulta11 = DB::select($sql1);
			if (count($consulta11)==0){
				$result=DB::insert("INSERT INTO publicity_details (publicity_id,store_id,user_id,result,visible,comment,contaminated,company_id, created_at,updated_at) 
							VALUES(?,?,?,?,?,?,?,?,?,?)" ,
							array(
								$publicity_id['publicity_id'],
								$store_id['store_id'],
								$user_id['user_id'],
								$found['found'],
								$visible['visible'],
								$comment['comment'],
								$contaminated['contaminated'],
								$company_id['company_id'],
								$horaSistema,$horaSistema));

				if($result > 0) {
					return \Response::json([ 'success'=> 1]);
				}else{
					return \Response::json([ 'success'=> 0]);
				}
			}else{
				$result=DB::update("UPDATE  publicity_details set publicity_id=?,store_id=?,user_id=?,result=?,visible=?,comment=?,contaminated=?,company_id=?, created_at=?,updated_at=? 
							where publicity_id='" . $publicity_id['publicity_id']  . "' 
								and store_id='".$store_id['store_id']."' 
								and user_id='".$user_id['user_id']."' 
								and result='".$found['found']."' 
								and visible='".$visible['visible']."' 
								and comment='".$comment['comment']."' 
								and contaminated='".$contaminated['contaminated']."' 
								and company_id='".$company_id['company_id']."'" ,
							array(
								$publicity_id['publicity_id'],
								$store_id['store_id'],
								$user_id['user_id'],
								$found['found'],
								$visible['visible'],
								$comment['comment'],
								$contaminated['contaminated'],
								$company_id['company_id'],
								$horaSistema,$horaSistema));

				if($result > 0) {
					return \Response::json([ 'success'=> 1]);
				}else{
					return \Response::json([ 'success'=> 0]);
				}
			}




//		return [
//			'success' => true ,
//			'note' => 'hola',
//		];
}

	public function insertImagesPublicitiesAlicorp() {
		if(Input::hasFile('fotoUp')) {
			$archivo=Input::file('fotoUp');
			$archivo->move('media/fotos/',$archivo->getClientOriginalName());
		}
		$publicities_id = Input::only('publicities_id');
		$store_id = Input::only('store_id');
		$tipo = Input::only('tipo');
		$archivo = Input::only('archivo');
		$company_id =Input::only('company_id');
		$mytime =  Carbon::now();
		$horaSistema = $mytime->toDateTimeString();

		DB::insert("INSERT INTO medias (store_id,publicities_id, tipo,archivo, company_id, created_at,updated_at) VALUES(?,?,?,?,?,?,?)" , array($store_id['store_id'],$publicities_id['publicities_id'], $tipo['tipo'], $archivo['archivo'],$company_id['company_id'],$horaSistema,$horaSistema));

		return \Response::json([ 'success'=> 1]);

	}

	public function insertImagesProductPollAlicorp() {
		if(Input::hasFile('fotoUp')) {
			$archivo=Input::file('fotoUp');
			$archivo->move('media/fotos/',$archivo->getClientOriginalName());
		}
		$product_id = Input::only('product_id');
		$poll_id = Input::only('poll_id');
		$store_id = Input::only('store_id');
		$tipo = Input::only('tipo');
		$archivo = Input::only('archivo');
		$company_id = Input::only('company_id');
		$mytime = Carbon::now();
		$horaSistema = $mytime->toDateTimeString();

		DB::insert("INSERT INTO medias (store_id,poll_id,product_id, tipo,archivo,company_id, created_at,updated_at) 
					VALUES(?,?,?,?,?,?,?,?)" ,
					array(
						$store_id['store_id'],
						$poll_id['poll_id'],
						$product_id['product_id'],
						$tipo['tipo'],
						$archivo['archivo'],
						$company_id['company_id'],
						$horaSistema,$horaSistema
					)
		);

		return \Response::json([ 'success'=> 1]);
	}

	public function insertImages() {
		if(Input::hasFile('fotoUp')) {
			$archivo=Input::file('fotoUp');
			$archivo->move('media/fotos/',$archivo->getClientOriginalName());
		}
		$product_id = Input::only('product_id');
		$poll_id = Input::only('poll_id');
		$store_id = Input::only('store_id');
		$publicities_id = Input::only('publicities_id');
		$tipo = Input::only('tipo');
		$archivo = Input::only('archivo');
		$company_id = Input::only('company_id');
		$category_product_id = Input::only('category_product_id');
		$mytime = Carbon::now();
		$horaSistemaUpdate = $mytime->toDateTimeString();
		$horaSistema = Input::only('created_at');

		DB::insert("INSERT INTO medias (store_id,poll_id,publicities_id,product_id, tipo,archivo,company_id,category_product_id, created_at,updated_at) 
					VALUES(?,?,?,?,?,?,?,?,?,?)" ,
			array(
				$store_id['store_id'],
				$poll_id['poll_id'],
				$publicities_id['publicities_id'],
				$product_id['product_id'],
				$tipo['tipo'],
				$archivo['archivo'],
				$company_id['company_id'],
				$category_product_id['category_product_id'],
				$horaSistema['created_at'],
				$horaSistemaUpdate
			)
		);

		return \Response::json([ 'success'=> 1]);
	}

	public function insertImagesMayorista() {
		if(Input::hasFile('fotoUp')) {
			$archivo=Input::file('fotoUp');
			$archivo->move('media/fotos/',$archivo->getClientOriginalName());
		}
		$product_id = Input::only('product_id');
		$poll_id = Input::only('poll_id');
		$store_id = Input::only('store_id');
		$publicities_id = Input::only('publicities_id');
		$tipo = Input::only('tipo');
		$archivo = Input::only('archivo');
		$company_id = Input::only('company_id');
		$monto = Input::only('monto');
		$razon_social = Input::only('razon_social');
		$category_product_id = Input::only('category_product_id');
		$mytime = Carbon::now();
		$horaSistemaUpdate = $mytime->toDateTimeString();
		$horaSistema = Input::only('created_at');

		DB::insert("INSERT INTO medias (store_id,poll_id,publicities_id,product_id, tipo,archivo,company_id,category_product_id,monto,razon_social, created_at,updated_at) 
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?)" ,
			array(
				$store_id['store_id'],
				$poll_id['poll_id'],
				$publicities_id['publicities_id'],
				$product_id['product_id'],
				$tipo['tipo'],
				$archivo['archivo'],
				$company_id['company_id'],
				$category_product_id['category_product_id'],
				$monto['monto'],
				$razon_social['razon_social'],
				$horaSistema['created_at'],
				$horaSistemaUpdate
			)
		);

		return \Response::json([ 'success'=> 1]);
	}


	public function closeAudit() {

		$company_id = Input::only('company_id');
		$audit_id = Input::only('audit_id');
		$road_id = Input::only('rout_id');
		$store_id = Input::only('store_id');
		$mytime = Carbon::now();
		$horaSistema = $mytime->toDateTimeString();


		$result = DB::update("UPDATE  audit_road_stores set audit= 1, updated_at=? where store_id = ? and  road_id = ? and company_id=? and audit_id=? " ,
			array(
				$horaSistema,
				$store_id['store_id'],
				$road_id['rout_id'],
				$company_id['company_id'],
				$audit_id['audit_id'])
		);
		if($result > 0) {
			return \Response::json([ 'success'=> 1]);
		}else{
			return \Response::json([ 'success'=> 0]);
		}

	}

	public function saveRegistersBayerMercaderismo()
	{
		$objPollDetail = $this->PollDetailRepo->getModel();
		//$objPollDetail->poll_id = 34;
		$valoresPost= Input::all();//dd($valoresPost);
		$poll_id = $valoresPost['poll_id'];
		$store_id= $valoresPost['store_id'];
		$sino= $valoresPost['sino'];
		$options= $valoresPost['options'];
		$limits= $valoresPost['limits'];
		$media= $valoresPost['media'];
		$coment= $valoresPost['coment'];
		$result= $valoresPost['result'];
		$limite= $valoresPost['limite'];
		$comentario= $valoresPost['comentario'];
		$auditor= $valoresPost['auditor'];
		$product_id= $valoresPost['product_id'];
		$publicity_id= $valoresPost['publicity_id'];
		$company_id = $valoresPost['company_id'];
		$category_product_id = $valoresPost['category_product_id'];
		$selectedOptions = $valoresPost['selectedOptions'];
		$selectedOptionsComment = $valoresPost['selectedOptionsComment'];
		$priority = $valoresPost['priority'];
		$stock_product_pop_id =$valoresPost['stock_product_pop_id'];
		$visit_id = $valoresPost['visit_id'];
		$mytime = Carbon::now();
		$horaSistema = $mytime->toDateTimeString();

		$objPollDetail->poll_id = $poll_id;//dd($objPollDetail->poll_id);
		$objPollDetail->store_id = $store_id;
		$objPollDetail->product_id = $product_id;
		$objPollDetail->publicity_id = $publicity_id;
		$objPollDetail->company_id = $company_id;
		$objPollDetail->category_product_id = $category_product_id;
		$objPollDetail->stock_product_pop_id = $stock_product_pop_id;
		$objPollDetail->visit_id = $visit_id;
		$valor = $this->PollDetailRepo->searchPollDetail($objPollDetail,1);//dd(count($valor));
		$objPoll=$this->PollRepo->find($poll_id);
		$objAuditor = $this->UserRepo->find($auditor);
		$datoAuditor = $objAuditor->fullname."(".$auditor.")";
		$campaigneDetail = $this->campaigneRepo->find($company_id);//dd($campaigneDetail);
		$customer =$this->customerRepo->find($campaigneDetail->customer_id);
		$cliente = $customer->corto;
		$textoContent = $campaigneDetail->fullname."".$objPoll->question." - Id= ".$store_id;
		$objStore = $this->StoreRepo->find($store_id);
		$tipo_bodega = $objStore->tipo_bodega;
		$agente = $objStore->fullname;
		$dir = $objStore->codclient;
		$address = $objStore->address;
		$fono = $objStore->telephone."/".$objStore->cell;
		$district = $objStore->district." - ".$objStore->region." - ".$objStore->ubigeo;
		$foto = "";$nomPublicity="";
		$fechaHoraEnvio = $horaSistema;

		$textoContent = $campaigneDetail->fullname." ".substr($objPoll->question,0,10)."... - CADENA: ".$objStore->cadenaRuc." StoreId: ".$store_id;

		if (count($valor)==0){
			$objPollDetail->sino = $sino;
			$objPollDetail->options = $options;
			$objPollDetail->limits = $limits;
			$objPollDetail->media = $media;
			$objPollDetail->coment = $coment;
			$objPollDetail->result = $result;
			$objPollDetail->limite = $limite;
			$objPollDetail->comentario = $comentario;
			$objPollDetail->auditor = $auditor;
			$objPollDetail->save();
			$idPollDetail = $objPollDetail->id;

			//send emails
			if ($result == 0){
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp. NO('.$idPollDetail.')';
			}else{
				$motivo = $objPoll->question."(Id question: ".$objPoll->id.")".' Resp SI('.$idPollDetail.')';
			}
			if ($nomPublicity<>""){
				$motivo .=" Publicidad: ".$nomPublicity;
			}
			$questions = $this->getQuestionsSendEmail();
			foreach ($questions as $question)
			{
				if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['send']==1))
				{
					if ($result == $question['result'])
					{
						$gruposEmails = $this->getGroupsEmails();
						$mascaras = explode('|',$question['mask']);
						for($i=0;$i<count($mascaras);$i++) {
							$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
							$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails);
						}
						//sendEmails($store_id,$textoContent,$motivo,$auditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails)
					}

				}
			}
			//end send emails
		}else{
			$valor->sino = $sino;
			$valor->options = $options;
			$valor->limits = $limits;
			$valor->media = $media;
			$valor->coment = $coment;
			$valor->result = $result;
			$valor->limite = $limite;
			$valor->comentario = $comentario;
			$valor->auditor = $auditor;
			$valor->update();
			$idPollDetail = $valor->id;
		}
		$objPollDetailSearch = $this->PollDetailRepo->getModel();
		$ObjSearchPollDetail = $objPollDetailSearch::find($idPollDetail);//dd($selectedOptions);
		if ($ObjSearchPollDetail->options==1)
		{
			$opciones = explode('|',$selectedOptions);$c=0;
			$comentOpcion = explode('|',$selectedOptionsComment);//dd($opciones);
			if ($opciones[0]<>'')
			{
				foreach ($opciones as $valor) {
					if ($valor<>''){
						$consulta1 = $this->PollOptionRepo->getOptionsForPollCodigo($ObjSearchPollDetail->poll_id,$valor);//dd($consulta1[0]);
						if (count($consulta1)>0){
							$objPollOptionDetail = $this->PollOptionDetailRepo->getModel();
							$objPollOptionDetail->poll_option_id=$consulta1[0]->id;
							$objPollOptionDetail->store_id=$store_id;
							$objPollOptionDetail->product_id=$product_id;
							$objPollOptionDetail->company_id=$company_id;
							$objPollOptionDetail->publicity_id=$publicity_id;
							$objPollOptionDetail->visit_id = $visit_id;
							$valorOption = $this->PollOptionDetailRepo->searchPollOptionDetail($objPollOptionDetail);
							if (count($valorOption)==0){
								$objPollOptionDetail->result=1;
								if (count($comentOpcion)>1){
									$objPollOptionDetail->otro=$comentOpcion[$c];
								}else{
									$objPollOptionDetail->otro=$comentOpcion[0];
								}

								$objPollOptionDetail->auditor=$auditor;
								$objPollOptionDetail->priority=$priority;
								$objPollOptionDetail->save();
								$idPollOptionDetail = $objPollOptionDetail->id;
								//send emails
								$motivo = $objPoll->question." (Id question: ".$objPoll->id.")"." (IdResp.: ".$idPollDetail.") opcion: ".$consulta1[0]->options.' ('.$idPollOptionDetail.')';
								$questions = $this->getQuestionsSendEmail();
								foreach ($questions as $question)
								{
									if (($question['company_id']==$company_id) and ($question['poll_id']==$poll_id) and ($question['poll_option_id']==$consulta1[0]->id))
									{
										$gruposEmails = $this->getGroupsEmails();
										$mascaras = explode('|',$question['mask']);
										for($i=0;$i<count($mascaras);$i++) {
											$emails = $gruposEmails[$mascaras[$i]];//dd($emails);
											$this->sendEmails($store_id,$textoContent,$motivo,$datoAuditor,$comentario,$cliente,$tipo_bodega,$agente,$dir,$address,$district,$foto,$fechaHoraEnvio,$emails,$fono);
										}
									}
								}
								//end send emails
							}else{
								$valorOption->result=1;
								$valorOption->otro=$comentOpcion[$c];
								$valorOption->auditor=$auditor;
								$valorOption->priority=$priority;
								$valorOption->update();
								$idPollOptionDetail = $valorOption->id;
							}
						}
						$c=$c+1;
					}
				}
			}else{
				$idPollOptionDetail=0;
			}

		}
		header('Access-Control-Allow-Origin: *');
		header('Content-type: application/json');
		return Response::json([ 'success'=> 1, 'last_poll_detail_id' => $idPollDetail]);
	}

}

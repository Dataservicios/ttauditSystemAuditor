<?php namespace Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AlicorpController extends \BaseController {

	public function __construct()
	{
		
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return [
			'success' => true ,
			'note' => 'hola',
		];
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

	public function insertImagesAlicorp() {
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
		$mytime = Carbon::now();
		$horaSistemaUpdate = $mytime->toDateTimeString();
		$horaSistema = Input::only('created_at');

		DB::insert("INSERT INTO medias (store_id,poll_id,publicities_id,product_id, tipo,archivo,company_id, created_at,updated_at) 
					VALUES(?,?,?,?,?,?,?,?,?)" ,
			array(
				$store_id['store_id'],
				$poll_id['poll_id'],
				$publicities_id['publicities_id'],
				$product_id['product_id'],
				$tipo['tipo'],
				$archivo['archivo'],
				$company_id['company_id'],
				$horaSistema['created_at'],
				$horaSistemaUpdate
			)
		);

		return \Response::json([ 'success'=> 1]);
	}

//	public function insertImagesAlicorp() {
//
//		if(Input::hasFile('fotoUp')) {
//			$archivo=Input::file('fotoUp');
//			$archivo->move('media/fotos/',$archivo->getClientOriginalName());
//		}
//
//		$product_id = Input::only('product_id');
//		$poll_id = Input::only('poll_id');
//		$store_id = Input::only('store_id');
//		$tipo = Input::only('tipo');
//		$archivo = Input::only('archivo');
//		$company_id = Input::only('company_id');
//		$mytime = Carbon::now();
//		$horaSistema = $mytime->toDateTimeString();
//
//		DB::insert("INSERT INTO medias (store_id,poll_id,product_id, tipo,archivo,company_id, created_at,updated_at) VALUES(?,?,?,?,?,?,?,?)" , array($store_id['store_id'],$poll_id['poll_id'],$product_id['product_id'], $tipo['tipo'], $archivo['archivo'], $company_id['company_id'],$horaSistema,$horaSistema));
//
//		return \Response::json([ 'success'=> 1]);
//	}


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

}

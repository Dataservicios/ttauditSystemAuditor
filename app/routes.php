<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});*/
//Route::when('*', 'csrf', ['post']);

Route::get('/', ['as' => 'login', 'uses' => 'HomeController@login']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

Route::group(['before'=>'auth'], function(){
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    Route::get('report', ['as' => 'report', 'uses' => 'ReportController@reportHome']);
    Route::get('report/audit/{id}', ['as' => 'reportAudit', 'uses' => 'ReportController@audit']);//temporal
    Route::get('report/excel', ['as' => 'reportExcel', 'uses' => 'ReportController@reportExcel']);
    Route::get('report/auditReportPresencia/{id}/{store_id?}', ['as' => 'auditReportPresencia', 'uses' => 'ReportColgateController@getCountForPresenceDetail']);
    Route::get('report/auditReportVisibilidad/{id}/{store_id?}', ['as' => 'auditReportVisibilidad', 'uses' => 'ReportColgateController@getCountForPublicitiesDetail']);
    Route::get('report/detailPresencia/{id}/{audit_id}', ['as' => 'DetailPresencia', 'uses' => 'ReportColgateController@detailPresenceDetailForPresence']);
    Route::get('report/detailPublicidad/{id}/{audit_id}', ['as' => 'DetailPublicidad', 'uses' => 'ReportColgateController@detailPublicityDetailForPublicity']);
    Route::get('report/auditReport/{id}/{store_id?}', ['as' => 'auditReport', 'uses' => 'ReportController@auditReportAbstract']);
    Route::post('report/auditReportFilter', ['as' => 'auditReportFilter', 'uses' => 'ReportController@auditReportAbstract']);
    Route::get('report/reportAudios', ['as' => 'reportAudios', 'uses' => 'ReportController@reportAudios']);
    Route::get('report/getDetailResultQuestion/{poll_id}/{values}/{poll_option_id?}', ['as' => 'getDetailResultQuestion', 'uses' => 'ReportController@getDetailResultQuestion']);

    Route::get('auditor/{opcion?}', ['as' => 'auditor', 'uses' => 'AuditorsController@auditorHome']);
    Route::get('auditor/client/{id}/{opcion?}', ['as' => 'auditorClient', 'uses' => 'AuditorsController@auditorHome']);
    Route::post('auditor/insertPhotos', ['as' => 'auditorInsertPhotos', 'uses' => 'AuditorsController@insertPhotos']);
    Route::get('auditor/detailPollPhoto/{id}/{company_id}/{opcion?}', ['as' => 'detailPollPhoto', 'uses' => 'AuditorsController@detailPollPhoto']);
    Route::get('auditor/getPhotoPollStore/{store_id}/{poll_id}/{opcion?}', ['as' => 'getPhotoPollStore', 'uses' => 'AuditorsController@getPhotoPollStore']);
    Route::get('auditor/responsePoll/{company_id}/{audit_id}/{store_id}/{opcion?}', ['as' => 'responsePoll', 'uses' => 'PollController@responsePoll']);
    Route::post('auditor/insertResponsePoll', ['as' => 'insertResponsePoll', 'uses' => 'PollController@insertResponsePoll']);

    Route::get('admin/panel', ['as' => 'admin', 'uses' => 'UserController@listUsers']);
    Route::get('admin/routes', ['as' => 'newRoute', 'uses' => 'StoreController@newRoute']);
    Route::get('admin/operationsGroup', ['as' => 'operationsGroup', 'uses' => 'ReportController@operationsGroup']);//temporal actualiza BD
    Route::get('admin/categoryProduct/{id}', ['as' => 'category', 'uses' => 'CategoryProductController@category']);
    Route::get('admin/product/{id}', ['as' => 'product', 'uses' => 'ProductController@show']);
    Route::get('admin/companyProduct/{id}', ['as' => 'company', 'uses' => 'CompanyController@products']);
    Route::get('admin/latestProducts', ['as' => 'latestProducts', 'uses' => 'ProductController@last']);
    Route::get('admin/sign-up', ['as' => 'sign_up', 'uses' => 'UserController@signUp']);
    Route::post('admin/sign-up', ['as' => 'register', 'uses' => 'UserController@register']);
    Route::get('admin/account', ['as' => 'account', 'uses' => 'UserController@account']);
    Route::put('admin/account', ['as' => 'update_account', 'uses' => 'UserController@updateAccount']);
    Route::get('admin/profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
    Route::put('admin/profile', ['as' => 'update_profile', 'uses' => 'UserController@updateProfile']);
    Route::get('admin/userEdit/{id}', ['as' => 'userEdit', 'uses' => 'UserController@user']);
    Route::put('admin/userEdit/{id}', ['as' => 'update_user', 'uses' => 'UserController@updateUser']);
    Route::delete('admin/user/{id}', ['as' => 'admin.users.destroy', 'uses' => 'UserController@destroy']);
    Route::get('admin/companies', ['as' => 'listCompanies', 'uses' => 'CompanyController@listCompanies']);
    Route::get('admin/newCompany', ['as' => 'newCompany', 'uses' => 'CompanyController@newCompany']);
    Route::post('admin/newCompany', ['as' => 'registerCompany', 'uses' => 'CompanyController@register']);
    Route::get('admin/stores', ['as' => 'listStores', 'uses' => 'StoreController@listStores']);
    Route::get('admin/store/{id}', ['as' => 'storeDetail', 'uses' => 'StoreController@show']);
    Route::get('admin/storeEdit/{id}', ['as' => 'storeEdit', 'uses' => 'StoreController@store']);
    Route::put('admin/storeUpdate/{id}', ['as' => 'storeUpdate', 'uses' => 'StoreController@updateStore']);
    Route::get('admin/newStore', ['as' => 'newStore', 'uses' => 'StoreController@newStore']);
    Route::post('admin/newStore', ['as' => 'registerStore', 'uses' => 'StoreController@registerStore']);
    Route::get('admin/importStore', ['as' => 'importStore', 'uses' => 'StoreController@importStore']);
    Route::get('admin/insertSpace', ['as' => 'insertSpace', 'uses' => 'SpaceController@insertSpace']);
    Route::post('admin/insertSpace', ['as' => 'insertSpace', 'uses' => 'SpaceController@registerSpace']);
    Route::get('admin/auditSpaces', ['as' => 'auditSpaces', 'uses' => 'SpaceController@listSpacesTotal']);
    Route::post('admin/listSpaceForCompany', ['as' => 'listSpaceForCompany', 'uses' => 'SpaceController@listSpacesForCompany']);
    Route::get('admin/spaceDetail/{id}', ['as' => 'spaceDetail', 'uses' => 'SpaceDetailController@resultSpaceAuditor']);
    Route::get('admin/insertPoll', ['as' => 'insertPoll', 'uses' => 'PollController@insertPoll']);
    Route::post('admin/insertPoll', ['as' => 'insertPoll', 'uses' => 'PollController@registerPoll']);
});

    Route::get('getCategoryForCompany', ['as' => 'getCategoryForCompany', 'uses' => 'CompanyController@getCategoryForCompany']);


    Route::get('storeMap', ['as' =>'storeMap', function(){
    $id = Input::get('id');
    $stores = Auditor\Entities\Store::where('id', '=',  $id)->take(20)->get();
    //dd($stores);
    return Response::json($stores);
}]);
Route::post('loginUser', ['as' =>'loginUser', function(){

    $data = Input::only('username', 'password');

    $credentials = ['email' => $data['username'], 'password' => $data['password']];

    if (Auth::attempt($credentials))
    {
        return '{"success":1,"message":"Login ok!","id":'.Auth::id().'}';
    }else{
        return '{"success":0,"message":"Login error!"}';
    }

}]);

Route::post('JsonRoadsTotal', ['as' =>'JsonRoadsTotal', function(){

    $id = Input::only('id');
    //var_dump($id) ;
    //dd($id) ;

    $sql ="SELECT roads.fullname, roads.id, COUNT(road_details.id) AS pdvs, sum(road_details.audit) as auditados FROM roads INNER JOIN road_details ON (roads.id = road_details.road_id) where roads.user_id='" . $id['id']  . "' GROUP BY roads.id";
    $consulta=DB::select($sql);

    return \Response::json([ 'success'=> 1, "roads" => $consulta]);


}]);

Route::post('JsonRoadsDetail', ['as' =>'JsonRoadsDetail', function(){

    $id = Input::only('id');
    //var_dump($id) ;
    //dd($id) ;
    $sql="SELECT COUNT(road_details.store_id) AS pdvs, sum(road_details.audit) as auditados FROM roads INNER JOIN road_details ON (roads.id = road_details.road_id) where roads.id='" . $id['id']  . "' GROUP BY  roads.id";
    $consulta1 = DB::select($sql);
    //dd($consulta1);
    $sql = "SELECT s.id, s.fullname,s.address, s.district, r.audit as status FROM road_details r,stores s where r.road_id='" . $id['id']  . "' and s.id=r.store_id";
    return \Response::json([ 'success'=> 1,"pdvs" => $consulta1[0]->pdvs,"auditados" => $consulta1[0]->auditados, "roadsDetail" => DB::select($sql)]);


}]);

Route::post('JsonRoadDetail', ['as' =>'JsonRoadsDetail', function(){

    $id = Input::only('id');
    //var_dump($id) ;
    //dd($id) ;

    $sql = "SELECT s.fullname,s.address, s.district, s.latitude, s.longitude FROM stores s where s.id='" . $id['id']  . "'";
    return \Response::json([ 'success'=> 1, "roadsDetail" => DB::select($sql)]);


}]);


Route::post('JsonRoadsMap', ['as' =>'JsonRoadsMap', function(){

    $id = Input::only('id');
    //var_dump($id) ;
    //dd($id) ;

    $sql = "SELECT s.fullname,s.latitude, s.longitude FROM road_details r,stores s where r.road_id='" . $id['id']  . "' and s.id=r.store_id and r.audit=0";
    return \Response::json([ 'success'=> 1, "storeMaps" => DB::select($sql)]);


}]);

Route::post('JsonAuditsForStore', ['as' =>'JsonAuditsForStore', function(){

    $id = Input::only('id');
    $idRoute = Input::only('idRoute');
    //var_dump($id) ;
    //dd($id) ;

    $sql = "SELECT company_id FROM company_stores c where store_id='" . $id['id']  . "'";
    $consulta=DB::select($sql);
    $t="";
    if (count($consulta)>0){
        $sql1="SELECT a.id, a.fullname FROM company_audits c,audits a where c.company_id='" . $consulta[0]->company_id . "' and c.audit=1 and c.audit_id=a.id ORDER BY orden ASC";
        /*foreach ($consulta as $v) {
            $sql1="SELECT a.id, a.fullname FROM company_audits c,audits a where c.company_id='" . $v->company_id . "' and c.audit=1 and c.audit_id=a.id";
            $t = array("company_id" => $v->company_id, "audits" => DB::select($sql1));
        }*/
        $consulta1 = DB::select($sql1);
       //dd($consulta1);
        foreach ($consulta1 as $v) {
            $sql2 = "SELECT audit FROM audit_road_stores a where company_id='". $consulta[0]->company_id ."' and road_id='". $idRoute['idRoute'] ."' and store_id='". $id['id']  ."' and audit_id='". $v->id ."'";
            $consulta2 = DB::select($sql2);
            if (count($consulta2)>0){
                $audits[] = array("id" => $v->id, "fullname" => $v->fullname, "state" => $consulta2[0]->audit);
            }
            //dd($sql2);

        }
        $var = array("success" => 1, "company" => $consulta[0]->company_id , "audits" => $audits);
    }else{
        $var = array("success" => 0, "error" => "No presenta auditorias");
    }

    //return $t;
    return \Response::json($var);


}]);

Route::post('JsonPollsCompany', ['as' =>'JsonPollsCompany', function(){

    $id = Input::only('id');
    //var_dump($id) ;
    //dd($id) ;

    $sql = "SELECT s.id, s.question FROM polls s where s.company_id='" . $id['id']  . "'";
    return \Response::json([ 'success'=> 1, "questionsPoll" => DB::select($sql)]);


}]);

Route::post('JsonUpdatePollsCompany', ['as' =>'JsonUpdatePollsCompany', function(){

    $question = Input::only('question');
    $idstrore = Input::only('id');
    $idcompany = Input::only('idCompany');
    $idroute  = Input::only('idRuta');
    $idaudit = Input::only('idAuditoria');
    $c=0;
    //dd($question);
    $valores0 = explode("|",$question['question']);
    //dd($valores0);
    for($i=0;$i<count($valores0);$i++) {
        $valores = explode(":", $valores0[$i]);
        //dd($valores);
        //if ($valores[1]==0) $valores[1]=false; else $valores[1]=true;
        DB::insert("INSERT INTO poll_details (result,store_id,poll_id,created_at,updated_at) VALUES(?,?,?,now(), now())" , array($valores[1], $idstrore['id'] , $valores[0]));

    }
    DB::update("UPDATE  audit_road_stores set audit= 1 where company_id = ? and  road_id = ? and audit_id = ? and store_id = ?" , array($idcompany['idCompany'], $idroute['idRuta'], $idaudit['idAuditoria'], $idstrore['id'] ));


    return \Response::json([ 'success'=> 1]);


}]);

Route::post('updatePositionStore', ['as' =>'updatePositionStore', function(){

    $id = Input::only('id');
    $latitud = Input::only('latitud');
    $longitud = Input::only('longitud');
    //var_dump($id) ;
    //dd($id) ;
    DB::update("UPDATE  stores set latitude = ? , longitude = ? where id= ? " , array($latitud['latitud'], $longitud['longitud'], $id['id'] ));
    return \Response::json([ 'success'=> 1]);
}]);

Route::post('JsonGetQuestions', ['as' =>'JsonGetQuestions', function(){

    $audit_id = Input::only('idAuditoria');
    $company_id = Input::only('idCompany');
    //var_dump($id) ;
    //dd($id) ;

    $sql = "SELECT id FROM company_audits c where audit_id='" . $audit_id['idAuditoria']  . "' and company_id='". $company_id['idCompany'] ."' and audit =1 order by created_at desc limit 1";
    $consulta=DB::select($sql);
    $t="";
    if (count($consulta)>0){
        $sql1="SELECT id, question FROM polls where company_audit_id='" . $consulta[0]->id . "' order by orden ASC";

        $consulta1 = DB::select($sql1);
        if (count($consulta1)>0){
            foreach ($consulta1 as $v) {
                $questions[] = array("id" => $v->id, "question" => $v->question);
            }
            $var = array("success" => 1, "questions" => $questions);
        }else{
            $var = array("success" => 0, "error" => "No presenta preguntas esta auditoria");
        }

    }else{
        $var = array("success" => 0, "error" => "No presenta auditorias");
    }

    //return $t;
    return \Response::json($var);


}]);

/*sino=0;options=0;limits=1;media=0;coment=0;result=0;opcion=0;limite=1.2|total:Muy Rapida*/

Route::post('JsonInsertAuditPolls', ['as' =>'JsonInsertAuditPolls', function(){

    $poll_id = Input::only('poll_id');
    $store_id = Input::only('store_id');
    $sino = Input::only('sino');
    $options = Input::only('options');
    $limits = Input::only('limits');
    $media = Input::only('media');
    $coment = Input::only('coment');
    $comentario = Input::only('comentario');
    $opcion = Input::only('opcion');
    $limite = Input::only('limite');
    $result = Input::only('result');
    $coment_options = Input::only('coment_options');// 0 o 1
    $comentario_options = Input::only('comentario_options');//comentario options

    $idcompany = Input::only('idCompany');
    $idroute  = Input::only('idRuta');
    $idaudit = Input::only('idAuditoria');
    $status = Input::only('status');

    $idPollDetail=0;
    $sqlnum="SELECT count(id) as numero FROM poll_details where poll_id='" . $poll_id['poll_id'] . "' and store_id='".$store_id['store_id']."'";
    $consultaNum = DB::select($sqlnum);

    if ($consultaNum[0]->numero==0){
        $sql=0;
        if (($sino['sino']==1) and ($options['options']<>1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino, coment,result, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$coment['coment'],$result['result']));
            $idPollDetail = DB::getPdo()->lastInsertId();
        }

        if (($sino['sino']==1) and ($options['options']<>1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']==1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino, coment,result,comentario, created_at,updated_at) VALUES(?,?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$coment['coment'],$result['result'],$comentario['comentario']));
            $idPollDetail = DB::getPdo()->lastInsertId();
        }

        if (($sino['sino']<>1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']==1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, options, coment,comentario, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$options['options'],$coment['coment'],$comentario['comentario']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $sql1="SELECT id,options FROM poll_options where codigo='" . $opcion['opcion'] . "'";
            $consulta1 = DB::select($sql1);

            if (count($consulta1)>0){
                if ($coment_options['coment_options'] == 1){
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                }else{
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                }
            }

        }

        if (($sino['sino']<>1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']==1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, options, comentOptions, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$options['options'],$coment_options['coment_options']));
            $idPollDetail = DB::getPdo()->lastInsertId();

            $sql1="SELECT id,options FROM poll_options where codigo='" . $opcion['opcion'] . "'";
            $consulta1 = DB::select($sql1);

            if (count($consulta1)>0){
                if ($coment_options['coment_options'] == 1){
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                }else{
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                }
            }
        }

        if (($sino['sino']<>1) and ($options['options']<>1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']==1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, coment,comentario, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$coment['coment'],$comentario['comentario']));
            $idPollDetail = DB::getPdo()->lastInsertId();
        }

        if (($sino['sino']<>1) and ($options['options']==1) and ($limits['limits']==1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']==1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, options, comentOptions, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$options['options'],$coment_options['coment_options']));
            $idPollDetail = DB::getPdo()->lastInsertId();

            $sql1="SELECT id,options FROM poll_options where codigo='" . $opcion['opcion'] . "'";
            $consulta1 = DB::select($sql1);

            if (count($consulta1)>0){
                if ($coment_options['coment_options'] == 1){
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                }else{
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                }
            }
        }

        if (($sino['sino']<>1) and ($options['options']==1) and ($limits['limits']==1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, options, limits,limite, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$options['options'],$limits['limits'],$limite['limite']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $valores = explode('|',$opcion['opcion']);
            if (count($valores)<>0){
                foreach ($valores as $v) {
                    if (!empty($v)){
                        $sql1="SELECT id,options FROM poll_options where codigo='" . $v . "'";
                        $consulta1 = DB::select($sql1);

                        if (count($consulta1)>0){
                            if ($coment_options['coment_options'] == 1){
                                DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                            }else{
                                DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                            }
                        }
                    }
                }
            }

        }

        if (($sino['sino']<>1) and ($options['options']<>1) and ($limits['limits']==1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, limits,limite, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$limits['limits'],$limite['limite']));
            $idPollDetail = DB::getPdo()->lastInsertId();
        }

        if (($sino['sino']==1) and ($options['options']<>1) and ($limits['limits']<>1) and ($media['media']==1) and ($coment['coment']<>1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino, media,result, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$media['media'],$result['result']));
            $idPollDetail = DB::getPdo()->lastInsertId();

        }

        if (($sino['sino']==1) and ($options['options']<>1) and ($limits['limits']<>1) and ($media['media']==1) and ($coment['coment']==1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino, coment,media,result,comentario, created_at,updated_at) VALUES(?,?,?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$coment['coment'],$media['media'],$result['result'],$comentario['comentario']));
            $idPollDetail = DB::getPdo()->lastInsertId();

        }

        if (($sino['sino']<>1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']<>1)and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, options, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$options['options']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $sql1="SELECT id,options FROM poll_options where codigo='" . $opcion['opcion'] . "'";
            $consulta1 = DB::select($sql1);

            if (count($consulta1)>0){
                if ($coment_options['coment_options'] == 1){
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                }else{
                    DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                }
            }
        }

        if (($sino['sino']==1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']==1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino,options,result,coment,comentario, created_at,updated_at) VALUES(?,?,?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$options['options'],$result['result'],$coment['coment'],$comentario['comentario']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $opciones = explode('|',$opcion['opcion']);
            foreach ($opciones as $valor) {
                if ($valor<>''){
                    $sql1="SELECT id,options FROM poll_options where codigo='" . $valor . "'";
                    $consulta1 = DB::select($sql1);

                    if (count($consulta1)>0){
                        if ($coment_options['coment_options'] == 1){
                            DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                        }else{
                            DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                        }
                    }
                }
            }

        }

        if (($sino['sino']==1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']==1) and ($coment['coment']<>1) and ($coment_options['coment_options']<>1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino,media,options,result, created_at,updated_at) VALUES(?,?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$media['media'],$options['options'],$result['result']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $sqlFecha="SELECT created_at FROM poll_details where id='" . $idPollDetail . "'";
            $consultaFecha = DB::select($sqlFecha);

            $opciones = explode('|',$opcion['opcion']);
            foreach ($opciones as $valor) {
                if ($valor<>''){
                    $sql1="SELECT id,options FROM poll_options where codigo='" . $valor . "'";
                    $consulta1 = DB::select($sql1);

                    if (count($consulta1)>0){
                        DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));

                        //empieza envio de email
                        if (($poll_id['poll_id']==67) and ($result['result']==0))
                        {
                            $sqlcoord="SELECT  b.email,a.coordinador,a.fullname, a.codclient,a.address,a.district FROM stores a, users b WHERE a.id = '".$store_id['store_id']."' AND b.fullname = a.coordinador";
                            $consulEmail = DB::select($sqlcoord);
                            $textoEmail = "Agente Cerrado DIR: ".$consulEmail[0]->codclient;
                            $textoContent = $textoEmail;
                            $nombreEnvio = $consulEmail[0]->coordinador;
                            $motivo = $consulta1[0]->options;

                            $sqlmedia = "SELECT archivo,created_at FROM medias m where store_id='".$store_id['store_id']."' and poll_id='".$poll_id['poll_id']."' and tipo=1;";
                            $consulMedia = DB::select($sqlmedia);
                            $urlBase = \App::make('url')->to('/');
                            $urlImages = '/media/fotos/';
                            if (count($consulMedia)>0){
                                $foto = $urlBase.$urlImages.$consulMedia[0]->archivo;
                            }else{
                                $foto = "";
                            }


                            $envio = ['responsable' => $nombreEnvio,'email' =>$consulEmail[0]->email, 'subject' =>$textoEmail];
                            $dt = new DateTime();
                            $fechaHoraEnvio = $consultaFecha[0]->created_at;

                            $datai = ['origen' => $store_id['store_id'],
                                'tipo'  =>  'LocalCerrado',
                                'titulo'=> $textoContent,
                                'motivo' => $motivo,
                                'agente'   =>  $consulEmail[0]->fullname,
                                'dir' => $consulEmail[0]->codclient,
                                'direccion' => $consulEmail[0]->address,
                                'distrito' => $consulEmail[0]->district,
                                'foto' => $foto,
                                'fecha' => $fechaHoraEnvio
                            ];
                            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
                            });
                            $sqlejec1="SELECT  b.email,a.ejecutivo FROM stores a, users b WHERE a.id = '".$store_id['store_id']."' AND b.fullname = a.ejecutivo";
                            $consulEmail1 = DB::select($sqlejec1);
                            $nombreEnvio = $consulEmail1[0]->ejecutivo;
                            $envio = ['responsable' => $nombreEnvio,'email' =>$consulEmail1[0]->email, 'subject' =>$textoEmail];
                            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
                            });
                            $envio = ['responsable' => 'Ricardo Gallo','email' =>'ricardogalloa@yahoo.com', 'subject' =>$textoEmail];
                            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
                            });
                            $envio = ['responsable' => 'Franco Ramirez','email' =>'franbrsj@gmail.com', 'subject' =>$textoEmail];
                            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
                            });
                        }

                        //finaliza envio de email
                    }
                }
            }

        }

        if (($sino['sino']==1) and ($options['options']==1) and ($limits['limits']<>1) and ($media['media']<>1) and ($coment['coment']<>1) and ($coment_options['coment_options']==1)){
            DB::insert("INSERT INTO poll_details (poll_id, store_id, sino,result,options,comentOptions, created_at,updated_at) VALUES(?,?,?,?,?,?,now(),now())" , array($poll_id['poll_id'],$store_id['store_id'],$sino['sino'],$result['result'],$options['options'],$coment_options['coment_options']));
            $idPollDetail = DB::getPdo()->lastInsertId();
            $opciones = explode('|',$opcion['opcion']);
            foreach ($opciones as $valor) {
                if ($valor<>''){
                    $sql1="SELECT id,options FROM poll_options where codigo='" . $valor . "' and poll_id='".$poll_id['poll_id']."'";
                    $consulta1 = DB::select($sql1);

                    if (count($consulta1)>0){
                        if ($consulta1[0]->options == 'Otros'){
                            DB::insert("INSERT INTO poll_option_details (poll_option_id, otro, store_id created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,$comentario_options['comentario_options'],$store_id['store_id']));
                        }else{
                            DB::insert("INSERT INTO poll_option_details (poll_option_id, result,store_id, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($consulta1[0]->id,1,$store_id['store_id']));
                        }
                    }
                }
            }

        }

        if ($idPollDetail >0){
            if ($status['status']==1){
                DB::update("UPDATE  audit_road_stores set audit= 1,updated_at=now() where company_id = ? and  road_id = ? and audit_id = ? and store_id = ?" , array($idcompany['idCompany'], $idroute['idRuta'], $idaudit['idAuditoria'], $store_id['store_id'] ));
            }

            return \Response::json([ 'success'=> 1]);
        }else{
            return \Response::json([ 'success'=> 0]);
        }
    }else{
        return \Response::json([ 'success'=> 1]);
    }



}]);

Route::post('insertImagesPoll', ['as' =>'insertImagesPoll', function(){
    $poll_id = Input::only('poll_id');
    $store_id = Input::only('store_id');
    $tipo = Input::only('tipo');
    $archivo = Input::only('archivo');

    DB::insert("INSERT INTO medias (store_id,poll_id, tipo,archivo, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($store_id['store_id'],$poll_id['poll_id'], $tipo['tipo'], $archivo['archivo']));

    return \Response::json([ 'success'=> 1]);
}]);
Route::post('insertImagesPublicities', ['as' =>'insertImagesPublicities', function(){

    $publicities_id = Input::only('publicities_id');
    $store_id = Input::only('store_id');
    $tipo = Input::only('tipo');
    $archivo = Input::only('archivo');

    DB::insert("INSERT INTO medias (store_id,publicities_id, tipo,archivo, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($store_id['store_id'],$publicities_id['publicities_id'], $tipo['tipo'], $archivo['archivo']));

    return \Response::json([ 'success'=> 1]);
}]);
Route::post('insertImagesInvoices', ['as' =>'insertImagesInvoices', function(){

    $invoices_id = Input::only('invoices_id');
    $store_id = Input::only('store_id');
    $tipo = Input::only('tipo');
    $archivo = Input::only('archivo');

    DB::insert("INSERT INTO medias (store_id,invoices_id, tipo,archivo, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($store_id['store_id'],$invoices_id['invoices_id'], $tipo['tipo'], $archivo['archivo']));

    return \Response::json([ 'success'=> 1]);
}]);

Route::post('uploadImagesAudit', ['as' =>'uploadImagesAudit', function(){
    if(Input::hasFile('fotoUp')) {
        $archivo=Input::file('fotoUp');
        $archivo->move('media/fotos/',$archivo->getClientOriginalName());
    }

    return \Response::json([ 'success'=> 1]);
}]);

Route::post('insertaTiempo', ['as' =>'insertaTiempo', function(){

    $latitud_close= Input::only('latitud_close');
    $longitud_close = Input::only('longitud_close');
    $latitud_open = Input::only('latitud_open');
    $longitud_open = Input::only('longitud_open');
    $tiempo_inicio  = Input::only('tiempo_inicio');
    $tiempo_fin = Input::only('tiempo_fin');
    $tduser = Input::only('tduser');
    $storeid = Input::only('id');
    $idruta = Input::only('idruta');

    DB::update("UPDATE  road_details set audit= 1, updated_at=now() where store_id = ? and  road_id = ? " , array($storeid ['id'], $idruta['idruta']));
    DB::insert("INSERT INTO control_time (closes,user_id, store_id,lat_close,long_close, lat_open,long_open,time_open,time_close, created_at,updated_at) VALUES('store',?,?,?,?,?,?,?,?,now(),now())" , array($tduser['tduser'],$storeid['id'], $latitud_close['latitud_close'], $longitud_close['longitud_close'],$latitud_open['latitud_open'],$longitud_open['longitud_open'],$tiempo_inicio['tiempo_inicio'],$tiempo_fin['tiempo_fin']));
    $idPollDetail = DB::getPdo()->lastInsertId();
    if ($idPollDetail >0){
        return \Response::json([ 'success'=> 1]);
    }else{
        return \Response::json([ 'success'=> 0]);
    }


}]);

Route::post('saveRoute', ['as' =>'saveRoute', function(){
    $company_id = Input::only('company_id');
    $user_id = Input::only('user_id');
    $id_store = Input::only('id_store');
    $nombreRuta = Input::only('nombreRuta');

    DB::insert("INSERT INTO roads (fullname,user_id, created_at,updated_at) VALUES(?,?,now(),now())" , array($nombreRuta['nombreRuta'],$user_id['user_id']));
    $idPollDetail = DB::getPdo()->lastInsertId();
    if ($idPollDetail >0){
        for($i = 0; $i < count($id_store['id_store']); ++$i) {
            DB::insert("INSERT INTO road_details (store_id,audit,road_id, created_at,updated_at) VALUES(?,0,?,now(),now())" , array($id_store['id_store'][$i],$idPollDetail));
            $sql1="SELECT audit_id FROM company_audits c where company_id='".$company_id['company_id']."' and audit=1";
            $consulta1 = DB::select($sql1);
            if (count($consulta1)>0){
                foreach ($consulta1 as $v) {
                    DB::insert("INSERT INTO audit_road_stores (company_id,road_id,audit_id,store_id, created_at,updated_at) VALUES(?,?,?,?,now(),now())" , array($company_id['company_id'],$idPollDetail,$v->audit_id,$id_store['id_store'][$i]));
                }
                DB::update("UPDATE  stores set ruteado= 1, updated_at=now() where id = ? " , array($id_store['id_store'][$i]));
            }
        }
    }

    return \Response::json([ 'success'=> 1]);


}]);
//valor temp
Route::post('insertaAuditRoadStores', ['as' =>'insertaAuditRoadStores', function(){

    $sql1="SELECT store_id,road_id FROM road_details where id>1050";
    $consulta1 = DB::select($sql1);
    foreach ($consulta1 as $valor) {
        for ($i = 7; $i <= 11; $i++) {
            DB::insert("INSERT INTO audit_road_stores (company_id,road_id, audit_id,store_id,audit, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array(1,$valor->road_id, $i,$valor->store_id,0));
        }
    }
    return \Response::json([ 'success'=> 1]);


}]);



//valor temp
Route::post('insertaCompanyStores', ['as' =>'insertaCompanyStores', function(){

    $sql1="SELECT id FROM stores where id>1250";
    $consulta1 = DB::select($sql1);
    foreach ($consulta1 as $valor) {
        DB::insert("INSERT INTO company_stores (company_id,store_id, created_at,updated_at) VALUES(?,?,now(),now())" , array(8,$valor->id));
    }
    return \Response::json([ 'success'=> 1]);


}]);
Route::get('getPointStores', ['as' =>'getPointStores', function(){

    $sql1="SELECT id,fullname,address, urbanization as referencia,district,region as provincia,ubigeo as departamento,codclient, latitude as latitud,longitude as longitud  FROM stores s where ruteado=0 and latitude<>0";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getPointStoresForCompany', ['as' =>'getPointStoresForCompany', function(){
    $company_id= Input::only('company_id');

    $sql1="SELECT
  stores.id,stores.fullname,stores.address, stores.urbanization as referencia,stores.district,
  stores.region as provincia,
  stores.ubigeo as departamento,
  stores.codclient,
  stores.latitude as latitud,
  stores.longitude as longitud
FROM
  company_stores
  INNER JOIN stores ON (company_stores.store_id = stores.id)
WHERE
  company_stores.company_id = '".$company_id['company_id']."' AND
  stores.ruteado = 0";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getAuditores', ['as' =>'getAuditores', function(){

    $sql1="SELECT users.id,users.fullname AS Auditor FROM users WHERE users.type ='auditor'";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);
Route::post('getRutasxUser', ['as' =>'getRutasxUser', function(){
    $user_id = Input::only('user_id');
    $sql1="SELECT roads.id, roads.fullname, roads.created_at FROM roads WHERE roads.user_id = '".$user_id['user_id']."' ORDER BY  roads.created_at DESC";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);
Route::post('getStoresxRoad', ['as' =>'getStoresxRoad', function(){
    $road_id = Input::only('road_id');
    $sql1="SELECT stores.id, stores.fullname,stores.address, stores.urbanization as referencia, stores.district, stores.region as provincia, stores.ubigeo as departamento,stores.codclient, stores.latitude, stores.longitude as longitud FROM  stores INNER JOIN road_details ON (stores.id = road_details.store_id) WHERE road_details.road_id = '".$road_id['road_id']."' ORDER BY road_details.updated_at DESC";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getDistrictxRegion', ['as' =>'getDistrictxRegion', function(){
    $region = Input::only('region');
    $sql1="SELECT district as id, district as fullname,region FROM stores s where s.region = '".$region['region']."' group by s.district";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getEjecutivoxRegionxDistric', ['as' =>'getEjecutivoxRegionxDistric', function(){
    $arrayDistrict = Input::only('district');
    $valDistrict = explode('|',$arrayDistrict['district']);
    $region = $valDistrict[0];
    $district = $valDistrict[1];
    $sql1 = "SELECT ejecutivo as id, ejecutivo as fullname,region,district FROM stores s where s.region = '".$region."' and s.district='".$district."' and s.ejecutivo<>'' group by s.ejecutivo";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getRubroxEjecxRegionxDistric', ['as' =>'getRubroxEjecxRegionxDistric', function(){
    $arrayEjecutivo = Input::only('ejecutivo');
    $valEjecutivo = explode('|',$arrayEjecutivo['ejecutivo']);
    $region = $valEjecutivo[0];
    $district = $valEjecutivo[1];
    $ejecutivo = $valEjecutivo[2];
    $sql1 = "SELECT id,rubro as id, rubro as fullname,region,district,ejecutivo FROM stores s where s.region = '".$region."' and s.district='".$district."' and s.ejecutivo='".$ejecutivo."' group by s.rubro";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('getEjecutivos', ['as' =>'getEjecutivos', function(){

    $sql1 = "SELECT ejecutivo as id, ejecutivo as fullname FROM stores s where ejecutivo<>'' group by ejecutivo";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);
Route::post('getRubros', ['as' =>'getRubros', function(){

    $sql1 = "SELECT rubro as id, rubro as fullname FROM stores s where rubro<>'' group by rubro";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::get('getCompanies', ['as' =>'getCompanies', function(){

    $sql1 = "SELECT id,fullname FROM companies c";
    header('Access-Control-Allow-Origin: *');

    return \Response::json( DB::select($sql1));
}]);

Route::post('JsonListProducts', ['as' =>'JsonListProducts', function(){
    $company_id = Input::only('company_id');
    if ($company_id==''){
        $sql = "SELECT products.id, products.fullname, products.eam, products.precio, products.company_id,category_products.id AS category_id, category_products.fullname AS categoria, products.imagen
            FROM products INNER JOIN category_products ON (products.category_product_id = category_products.id)";
    }else{
        $sql = "SELECT products.id, products.fullname, products.eam, products.precio, products.company_id,category_products.id AS category_id, category_products.fullname AS categoria, products.imagen
            FROM products INNER JOIN category_products ON (products.category_product_id = category_products.id) where products.company_id='" . $company_id['company_id']  . "'";
    }

    return \Response::json([ 'success'=> 1, "products" => DB::select($sql)]);


}]);

Route::post('JsonListPublicities', ['as' =>'JsonListProducts', function(){
    $company_id = Input::only('company_id');
    if ($company_id==''){
        $sql = "SELECT publicities.id, publicities.fullname, publicities.company_id,category_products.id AS category_id, category_products.fullname AS categoria, publicities.imagen
            FROM publicities INNER JOIN category_products ON (publicities.category_product_id = category_products.id)";
    }else{
        $sql = "SELECT publicities.id, publicities.fullname, publicities.company_id,category_products.id AS category_id, category_products.fullname AS categoria, publicities.imagen
            FROM publicities INNER JOIN category_products ON (publicities.category_product_id = category_products.id) where publicities.company_id='" . $company_id['company_id']  . "'";
    }

    return \Response::json([ 'success'=> 1, "publicities" => DB::select($sql)]);


}]);

Route::post('saveAuditPresencia', ['as' =>'saveAuditPresencia', function(){
    $products = Input::only('products');
    $score = Input::only('score');
    $store_id = Input::only('store_id');
    $user_id = Input::only('user_id');
    $road_id = Input::only('rout_id');
    $audit_id = Input::only('audit_');
    $company_id = Input::only('company_id');

    for($i = 0; $i < count($products['products']); ++$i) {
        $valproduct = json_decode($products['products'][$i],true);
        $sql = "SELECT id FROM presences p where product_id='" . $valproduct['product_id']  . "'";
        $consulta1 = DB::select($sql);
        if (count($consulta1)>0){
            foreach ($consulta1 as $valor) {
                $presence_id= $valor->id;
            }
            DB::insert("INSERT INTO presence_details (presence_id,store_id,user_id,result_product,result_price, created_at,updated_at) VALUES(?,?,?,1,0,now(),now())" , array($presence_id,$store_id['store_id'],$user_id['user_id']));
        }
    }
    DB::insert("INSERT INTO scores (score,audit_id,store_id,company_id,user_id, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($score['score'],$audit_id['audit_'],$store_id['store_id'],$company_id['company_id'],$user_id['user_id']));
    DB::update("UPDATE  audit_road_stores set audit= 1, updated_at=now() where store_id = ? and  road_id = ? and company_id=? and audit_id=? " , array($store_id['store_id'], $road_id['rout_id'], $company_id['company_id'], $audit_id['audit_']));
    return \Response::json([ 'success'=> 1]);
}]);


Route::get('SearchResults', function (){
    $dir = Input::get('dir');
    $stores = Auditor\Entities\Store::where('codclient', 'LIKE', '%' . $dir. '%')->take(5)->get();
    header('Access-Control-Allow-Origin: *');
    return \Response::json($stores);
});

Route::post('saveAuditVisibility', ['as' =>'saveAuditVisibility', function(){
    $company_id = Input::only('company_id');
    $audit_id = Input::only('audit_');
    $road_id = Input::only('rout_id');
    $score = Input::only('score');
    $store_id = Input::only('store_id');
    $user_id = Input::only('user_id');
    $publicity = Input::only('publicity');
    $scores_details = Input::only('scores_details');

    for($i = 0; $i < count($publicity['publicity']); ++$i) {
        $valpublicity = json_decode($publicity['publicity'][$i],true);
        DB::insert("INSERT INTO publicity_details (publicity_id,store_id,user_id,result,layout,visible, created_at,updated_at) VALUES(?,?,?,?,?,?,now(),now())" , array($valpublicity['publicity_id'],$store_id['store_id'],$user_id['user_id'],$valpublicity['found'],$valpublicity['layout_correct'],$valpublicity['visible']));
    }
    DB::insert("INSERT INTO scores (score,audit_id,store_id,company_id,user_id, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($score['score'],$audit_id['audit_'],$store_id['store_id'],$company_id['company_id'],$user_id['user_id']));
    $idScore = DB::getPdo()->lastInsertId();
    for($i = 0; $i < count($scores_details['scores_details']); ++$i) {
        $valscores = json_decode($scores_details['scores_details'][$i],true);
        DB::insert("INSERT INTO score_details (score_id,category_product_id,score, created_at,updated_at) VALUES(?,?,?,now(),now())" , array($idScore,$valscores['category_id'],$valscores['score']));
    }

    DB::update("UPDATE  audit_road_stores set audit= 1, updated_at=now() where store_id = ? and  road_id = ? and company_id=? and audit_id=? " , array($store_id['store_id'], $road_id['rout_id'], $company_id['company_id'], $audit_id['audit_']));

    return \Response::json([ 'success'=> 1]);
}]);

Route::post('saveAuditFacturacion', ['as' =>'saveAuditFacturacion', function(){
    $invoices_id = Input::only('invoices_id');
    $company_id = Input::only('company_id');
    $audit_id = Input::only('audit_');
    $road_id = Input::only('rout_id');
    $score = Input::only('score');
    $store_id = Input::only('store_id');
    $user_id = Input::only('user_id');

    DB::insert("INSERT INTO auditinvoices_details (auditinvoices_id,store_id,user_id,result, created_at,updated_at) VALUES(?,?,?,1,now(),now())" , array($invoices_id['invoices_id'],$store_id['store_id'],$user_id['user_id']));
    DB::insert("INSERT INTO scores (score,audit_id,store_id,company_id,user_id, created_at,updated_at) VALUES(?,?,?,?,?,now(),now())" , array($score['score'],$audit_id['audit_'],$store_id['store_id'],$company_id['company_id'],$user_id['user_id']));
    DB::update("UPDATE  audit_road_stores set audit= 1, updated_at=now() where store_id = ? and  road_id = ? and company_id=? and audit_id=? " , array($store_id['store_id'], $road_id['rout_id'], $company_id['company_id'], $audit_id['audit_']));


    return \Response::json([ 'success'=> 1]);
}]);

Route::post('sendEmail', ['as' => 'sendEmail', function(){
    $store_id = Input::only('store_id');
    $poll_id = Input::only('poll_id');
    /*$envio = ['responsable' => 'Franco Bill','email' =>'franbrsj@gmail.com', 'subject' =>"Practica de envios de email"];
    $data = ['name'  =>  'Franco Bill',
        'titulo'=> 'Pruebas',
        'msg'   =>  'Mailing con Laravel'];

    \Mail::send('emails.mensaje', $data, function($message) use ($envio){
        $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
    });*/
    $sql1="SELECT id,options FROM poll_options where codigo='67a'";
    $consulta1 = DB::select($sql1);

    $sqlcoord="SELECT  b.email,a.coordinador,a.fullname, a.codclient,a.address FROM stores a, users b WHERE a.id = '".$store_id['store_id']."' AND b.fullname = a.coordinador";
    $consulEmail = DB::select($sqlcoord);
    $textoEmail = "Agente Cerrado DIR: ".$consulEmail[0]->codclient;
    $textoContent = $textoEmail;
    $nombreEnvio = $consulEmail[0]->coordinador;
    $motivo = $consulta1[0]->options;

    $sqlmedia = "SELECT archivo FROM medias m where store_id='".$store_id['store_id']."' and poll_id='".$poll_id['poll_id']."' and tipo=1;";
    $consulMedia = DB::select($sqlmedia);
    $urlBase = \App::make('url')->to('/');
    $urlImages = '/media/fotos/';
    if (count($consulMedia)>0){
        $foto = $urlBase.$urlImages.$consulMedia[0]->archivo;
    }else{
        $foto = "";
    }


    $envio = ['responsable' => $nombreEnvio,'email' =>$consulEmail[0]->email, 'subject' =>$textoEmail];
    $dt = new DateTime();
    $fechaHoraEnvio = $dt->format('d-m-Y H:i:s');

    $datai = ['origen' => $store_id['store_id'],
        'tipo'  =>  'LocalCerrado',
        'titulo'=> $textoContent,
        'motivo' => $motivo,
        'agente'   =>  $consulEmail[0]->fullname,
        'dir' => $consulEmail[0]->codclient,
        'direccion' => $consulEmail[0]->address,
        'foto' => $foto,
        'fecha' => $fechaHoraEnvio
    ];
    \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
        $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
    });
    $sqlejec1="SELECT  b.email,a.ejecutivo FROM stores a, users b WHERE a.id = '".$store_id['store_id']."' AND b.fullname = a.ejecutivo";
    $consulEmail1 = DB::select($sqlejec1);
    $nombreEnvio = $consulEmail1[0]->ejecutivo;
    $envio = ['responsable' => $nombreEnvio,'email' =>$consulEmail1[0]->email, 'subject' =>$textoEmail];
    \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
        $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
    });
    return \Response::json([ 'success'=> 1]);
}]);
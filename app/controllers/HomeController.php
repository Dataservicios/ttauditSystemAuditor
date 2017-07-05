<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/*public function showWelcome()
	{
		return View::make('hello');
	}*/
    public function login()
    {
		/*$mytime = Carbon\Carbon::now();
		dd($mytime->toDateTimeString());*/
        return View::make('home');
    }

    public function testManagement($type="0")
    {
        if ($type=='Sessions'){//dd(Auth::user());
            if (Auth::user()==null){
                $type='anonimo';
            }else{
                $type= Auth::user()->type;
            }
            Session::reflash();
            $tiempo_transcurrido = time();

            $wo_direccion_ip = $_SERVER['REMOTE_ADDR'];
            $wo_url_actual = $_SERVER['REQUEST_URI'];
            $wo_navegador=$_SERVER['HTTP_USER_AGENT'];
            $xx_mins_ago = ($tiempo_transcurrido - 360);
            $url_base=\App::make('url')->to('/')."/".Request::path();dd($url_base);
            $mytime = Carbon\Carbon::now();
            $horaSalida= $mytime->format('h:i:s');dd($horaSalida);

            $session_id = Session::getId();
            if (Auth::check()){
                $texto= Auth::user()->fullname;dd($texto);
            }else{
                dd('invitado');
            }

            dd($xx_mins_ago);

            if (Session::has('type')) {
                Session::put('type', 'prueba');
            }else{
                Session::put('type', $type);
            }
            $data = Session::all();
            dd($data);

            return View::make('audits/sessionTests',compact('data'));
        }

        if ($type=='emails'){
            $mytime = \Carbon\Carbon::now();
            $horaSistema = $mytime->toDateTimeString();
            $datai = ['origen' => '342',
                'tipo'  =>  'LocalCerrado',
                'titulo'=> 'Pruebas de envio al Brito',
                'auditor' => 'Juan',
                'motivo' => 'Pruebas motivo',
                'comentario' => 'Mas preubas comentario',
                'cadena' => '',
                'tipoLocal' => '',
                'agente'   =>  '',
                'dir' => '',
                'direccion' => 'mas   ',
                'distrito' => 'Lima',
                'foto' => '',
                'fecha' => $horaSistema
            ];
            $envio = ['responsable' => 'Diana Lorena','email' =>'franbrsj@gmail.com', 'subject' =>'pruebas envio1'];
            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
            });
            $envio = ['responsable' => 'Diana Lorena','email' =>'jcdiaz356@gmail.com', 'subject' =>'pruebas envio1'];
            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
            });
            $envio = ['responsable' => 'Diana Lorena','email' =>'jcdiaz356@hotmail.com', 'subject' =>'pruebas envio1'];
            \Mail::send('emails.localCerrado', $datai, function($message) use ($envio){
                $message->to($envio['email'], $envio['responsable'])->subject($envio['subject']);
            });
        }
    }

}

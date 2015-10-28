<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 11/12/2014
 * Time: 12:27 PM
 */

class AuthController  extends BaseController{
    public function login()
    {
        $data = Input::only('email', 'password', 'remember');

        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (Auth::attempt($credentials, $data['remember']))
        {
            //return Redirect::back();
            //return View::make('panelAdmin');
            if (Auth::user()->type=='company'){
                return Redirect::to('report');
            }
            if (Auth::user()->type=='admin'){
                return Redirect::to('admin/panel');
            }
            if (Auth::user()->type=='auditor'){
                return Redirect::to('auditor');
            }
        }

        return Redirect::back()->with('login_error',1);
        /*dd(Input::all());*/
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
} 
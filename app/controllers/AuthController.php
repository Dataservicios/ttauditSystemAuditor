<?php

use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\UserRepo;
use Auditor\Repositories\VisitorRepo;

class AuthController  extends BaseController{

    protected $userCompanyRepo;
    protected $customerRepo;
    protected $campaigneRepo;
    protected $userRepo;
    protected $visitorRepo;

    public function __construct(UserRepo $userRepo,CompanyRepo $campaigneRepo,CustomerRepo $customerRepo,UserCompanyRepo $userCompanyRepo, VisitorRepo $visitorRepo)
    {
        $this->userCompanyRepo = $userCompanyRepo;
        $this->customerRepo = $customerRepo;
        $this->campaigneRepo = $campaigneRepo;
        $this->userRepo=$userRepo;
        $this->visitorRepo= $visitorRepo;
    }
    

    public function loginMovil()
    {
        $data = Input::only('username', 'password','imei');

        $credentials = ['email' => $data['username'], 'password' => $data['password']];

        if (Auth::attempt($credentials))
        {
            $modelUser = $this->userRepo->getModel();
            $objUser = $modelUser::find(Auth::id());
            $objUser->imei = $data['imei'];

            $objUser->save();
            return \Response::json([ 'success'=> 1, 'message' => "Login ok!", 'id'=> Auth::id(), 'fullname'=> Auth::user()->fullname]);
        }else{
            return \Response::json([ 'success'=> 0, 'message' => "Login error!", 'id'=> 0, 'fullname'=> ""]);
        }

    }

    public function login()
    {
        $data = Input::only('email', 'password', 'remember');

        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (Auth::attempt($credentials, $data['remember']))
        {
            //return Redirect::back();
            //return View::make('panelAdmin');
            if (Auth::user()->type=='company'){
                //dd(Auth::user());$company_id
                $campaigne = $this->userCompanyRepo->getCompany(Auth::user()->id);
                $campaigne_id = $campaigne[0]->id;
                $campaigneDetail = $this->campaigneRepo->find($campaigne_id);//dd($campaigneDetail);
                $customer =$this->customerRepo->find($campaigneDetail->customer_id);//dd($customer);
                //dd($customer);
                if ($customer->id == 3){
                    return Redirect::to('reportColgate');
                }
                if ($customer->id == 4)
                {
                    return Redirect::to('reportAlicorp');
                }
                if ($customer->id == 5)
                {
                    $this->saveSessions();
                    return Redirect::to('reportBayer');
                }
                if ($customer->id == 1)
                {
                    return Redirect::to('report');
                }

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
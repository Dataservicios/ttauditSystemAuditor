<?php
use Auditor\Managers\PhoneDetailManager;
use Auditor\Repositories\PhoneDetailRepo;
use Auditor\Repositories\UserRepo;

class PhoneDetailController extends BaseController{

    protected $phoneDetailRepo;
    protected $userRepo;

    public function __construct(UserRepo $userRepo,PhoneDetailRepo $phoneDetailRepo)
    {
        $this->phoneDetailRepo = $phoneDetailRepo;
        $this->userRepo = $userRepo;
    }


    public function newPhone()
    {
        $phoneDetail= $this->phoneDetailRepo->getModel();
        //dd($company);
        $manager = new PhoneDetailManager($phoneDetail, Input::all());

        $manager->save();
        return Redirect::route('listCompanies');

    }

    public function enterPhoneLocation()
    {
        $objPhoneDetailRepo = $this->phoneDetailRepo->getModel();
        //$objPollDetail->poll_id = 34;
        $valoresPost= Input::all();//dd($valoresPost['user_id']);
        $user_id = $valoresPost['user_id'];
        $latitud= $valoresPost['latitud'];
        $longitud= $valoresPost['longitud'];
        $phone= $valoresPost['phone'];
        $sdk= $valoresPost['sdk'];//$objUser = $this->userRepo->getUserForPhone($phone);dd($objUser);
        header('Access-Control-Allow-Origin: *');
        if ($latitud==0){
            return Response::json([ 'success'=> 0, 'last_phone_detail_id' => 0]);
        }
        $this->phoneDetailRepo->deleteAllForPhone($phone);
        $objPhoneDetailRepo->user_id = $user_id;
        $objPhoneDetailRepo->latitud = $latitud;
        $objPhoneDetailRepo->longitud = $longitud;
        $objPhoneDetailRepo->phone = $phone;
        $objPhoneDetailRepo->sdk = $sdk;
        if ($objPhoneDetailRepo->save())
        {
            $idPhoneDetail = $objPhoneDetailRepo->id;
            /*$modelUser = $this->userRepo->getModel();
            $objUser = $modelUser::find($user_id);
            $objUser->imei = $phone;*/

            return Response::json([ 'success'=> 1, 'last_phone_detail_id' => $idPhoneDetail]);
        }else{
            return Response::json([ 'success'=> 0, 'last_phone_detail_id' => 0]);
        }
    }

    public function getPhone()
    {
        $valoresPost= Input::all();
        $phone= $valoresPost['phone'];
        $objPhoneDetailRepo = $this->phoneDetailRepo->getPhone($phone);
        header('Access-Control-Allow-Origin: *');
        if ($objPhoneDetailRepo)
        {
            return Response::json([ 'success'=> 1, 'objeto' => $objPhoneDetailRepo]);
        }else{
            return Response::json([ 'success'=> 0, 'objeto' => []]);
        }
    }

    public function getPhoneForUser()
    {
        $valoresPost= Input::all();
        $user_id= $valoresPost['user_id'];
        $objUser=$this->userRepo->find($user_id);
        $userIMEI = $objUser->imei;
        $objPhoneDetailRepo = $this->phoneDetailRepo->getDetailPhoneForImei($userIMEI);
        header('Access-Control-Allow-Origin: *');
        if ($objPhoneDetailRepo)
        {
            return Response::json([ 'success'=> 1, 'objeto' => $objPhoneDetailRepo]);
        }else{
            return Response::json([ 'success'=> 0, 'objeto' => []]);
        }
    }

} 
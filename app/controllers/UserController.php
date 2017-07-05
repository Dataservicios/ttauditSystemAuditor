<?php
use Auditor\Entities\User;
use Auditor\Managers\RegisterManager;
use Auditor\Repositories\UserRepo;
use Auditor\Managers\AccountManager;
use Auditor\Managers\UserManager;


class UserController extends BaseController{

    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function listStoreAuditPalmeraNow(){
        $id = Input::only('id');
        $company_id = Input::only('company_id');
        if ($company_id['company_id']==47){
            $poll_id=627;
        }else{
            $poll_id=879;
        }

        $sql = "SELECT 
              `f`.`company_id`,
              `a`.`store_id`,
              `b`.`type`,
              `b`.`codclient`,
              `b`.`fullname`,
              `b`.`address`,
              `b`.`district`,
              `b`.`region`,
              `b`.`ubigeo`,
              `b`.`comment`,
              `b`.`ejecutivo`,
              `b`.`coordinador`,
              `e`.`fullname` AS `auditor`,
              DATE_FORMAT(`a`.`created_at`, '%d/%m/%Y') AS `fecha`,
              MIN(DATE_FORMAT(`a`.`created_at`, '%H:%i:%s')) AS `hora`
            FROM
              `poll_details` `a`
              LEFT OUTER JOIN `stores` `b` ON (`a`.`store_id` = `b`.`id`)
              LEFT OUTER JOIN `company_stores` `f` ON (`a`.`store_id` = `f`.`store_id`)
              LEFT OUTER JOIN `users` `e` ON (`a`.`auditor` = `e`.`id`)
            WHERE
              `f`.`company_id` = '".$company_id['company_id']."'  AND 
              `a`.`auditor` = '".$id['id']."' AND
              `a`.`poll_id` = '".$poll_id."' AND
              date_format(`a`.`created_at`, '%d/%m/%Y') = date_format(now(), '%d/%m/%Y') 
            GROUP BY
              `f`.`company_id`,
              `a`.`store_id`,
              `b`.`type`,
              `b`.`codclient`,
              `b`.`fullname`,
              `b`.`address`,
              `b`.`district`,
              `b`.`region`,
              `b`.`ubigeo`,
              `b`.`comment`,
              `b`.`latitude`,
              `b`.`longitude`,
              `b`.`ejecutivo`,
              `b`.`coordinador`,
              `e`.`fullname`,
              `b`.`distributor`,
              DATE_FORMAT(`a`.`created_at`, '%d/%m/%Y')
                ";

        $consulta=DB::select($sql);
        $success =1;

        return \Response::json([ 'success'=>$success ,"roadsDetail" => $consulta]);
    }

    public function listUsers()
    {
        $users =$this->userRepo->listUser();
        /*dd($category);*/
        return View::make('panelAdmin',compact('users'));
    }


    public function signUp()
    {
        $user_types = \Lang::get('utils.type');
        //dd($user_types);
        return View::make('users/sign-up', compact('user_types'));
    }

    public function register()
    {
        /*$data = Input::only(['fullname','email','password','password_confirmation']);*/
        /*$rules = [
            'fullname' => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed',
            'password_confirmation' => 'required'
        ];*/

        /*$validation = \Validator::make($data,$rules);*/

        /*if ($validation->passes())
        {
            //User::create($data);
            $user = new User($data);
            $user->type = 'auditor';
            $user->save();
            return Redirect::route('admin');
        }*/
        $user = $this->userRepo->newUser();
        //dd($user);
        $manager = new RegisterManager($user, Input::all());
        /*if ($manager->save())
        {
            return Redirect::route('admin');
        }*/
        $manager->save();
        return Redirect::route('admin');
        //return Redirect::back()->withInput()->withErrors($validation->messages());
        //return Redirect::back()->withInput()->withErrors($manager->getErrors());
    }

    public function account()
    {
        $user = Auth::user();
        $user_types = \Lang::get('utils.type');
        return View::make('users/account', compact('user','user_types'));
    }

    public function updateAccount()
    {
        $user = Auth::user();
        $manager = new AccountManager($user, Input::all());
        /*if ($manager->save())
        {
            return Redirect::route('admin');
        }*/
        //return Redirect::back()->withInput()->withErrors($validation->messages());

        /*try{
            $manager->save();
        } catch (\Auditor\Managers\ValidationException $e){
            dd($e->getErrors());
        }*/
        $manager->save();
        return Redirect::route('admin');

        //return Redirect::back()->withInput()->withErrors($manager->getErrors());
    }

    public function user($id)
    {
        $user = $this->userRepo->find($id);
        $user_types = \Lang::get('utils.type');
        return View::make('users/user', compact('user', 'user_types'));
    }

    public function updateUser($id)
    {
        $user = $this->userRepo->find($id);
        //dd(Input::all());
        $manager = new UserManager($user, Input::all());
        $manager->save();
        return Redirect::route('admin');
    }

    public function destroy($id)
    {
        $user = $this->userRepo->find($id);

        if (is_null ($user))
        {
            App::abort(404);
        }

        $user->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Usuario ' . $user->fullname . ' eliminado',
                'id'      => $user->id
            ));
        }
        else
        {
            return Redirect::route('admin');
        }
    }

    /*public function profile()
    {
        $user = Auth::user();
        return View::make('users/profile', compact('user'));
    }

    public function profileAccount()
    {
        $user = Auth::user();
        $manager = new AccountManager($user, Input::all());

        $manager->save();
        return Redirect::route('admin');
    }*/

} 
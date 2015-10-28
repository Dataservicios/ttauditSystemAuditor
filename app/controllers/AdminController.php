<?php
use Auditor\Entities\User;

class AdminController extends BaseController{


    public function panel()
    {
        $users = User::all();
        return View::make('panelAdmin',compact('users'));
    }
} 
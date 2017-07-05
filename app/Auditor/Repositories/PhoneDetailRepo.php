<?php
namespace Auditor\Repositories;

use Auditor\Entities\PhoneDetail;


class PhoneDetailRepo extends BaseRepo{

    public function getModel()
    {
        return new PhoneDetail;
    }

    public function deleteAllForPhone($phone)
    {
        $affectedRows = PhoneDetail::where('phone', $phone)->delete();//dd($affectedRows);
        if ($affectedRows>0){
            return true;
        }else{
            return false;
        }
    }

    public function getDetailPhoneForImei($imei)
    {
        $Row = PhoneDetail::where('phone', $imei)->get();
        if (count($Row)>0){
            return $Row;
        }else{
            return false;
        }
    }

    public function getDetailPhoneForUser($user_id)
    {
        $Row = PhoneDetail::where('user_id', $user_id)->get();
        if (count($Row)>0){
            return $Row;
        }else{
            return false;
        }
    }

    public function getPhone($phone)
    {
        $Row = PhoneDetail::where('phone', $phone)->get();
        if (count($Row)>0){
            return $Row;
        }else{
            return false;
        }
    }
} 
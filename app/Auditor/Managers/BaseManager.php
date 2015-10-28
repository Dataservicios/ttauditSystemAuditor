<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 18/12/2014
 * Time: 04:01 PM
 */

namespace Auditor\Managers;


abstract class BaseManager {

    protected $entity;
    protected $data;

    public function __construct($entity, $data)
    {
        $this->entity = $entity;
        $this->data   = array_only($data, array_keys($this->getRules()));
    }

    abstract public function getRules();

    public function isValid()
    {
        $rules = $this->getRules();
        $validation = \Validator::make($this->data,$rules);

        if ($validation->fails())
        {
            throw new ValidationException('Validation Failed', $validation->messages());
        }
        /*$isValid = $validation->passes();
        $this->errors = $validation->messages();
        return $isValid;*/
    }

    public function save()
    {
        /*if ( ! $this->isValid())
        {
            return false;
        }*/
        $this->isValid();
        //dd($this->data);
        $this->entity->fill($this->data);
        //dd($this->entity);
        $this->entity->save();
        return true;
    }

    /*public function insert_users($usuario,$email,$password)
    {

        $query = DB::table($this->entity->table)->insertGetId(array(
            'usuario' => $usuario,
            'email'  => $email,
            'password' => Crypter::encrypt($password)
        ));

        return $query;

    }*/


} 
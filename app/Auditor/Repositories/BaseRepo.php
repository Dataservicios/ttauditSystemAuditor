<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 14/12/2014
 * Time: 08:31 PM
 */

namespace Auditor\Repositories;


abstract class BaseRepo {

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract public function getModel();

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function allReg()
    {
        return $this->model->all();
    }
} 
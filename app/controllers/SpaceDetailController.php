<?php
/**
 * Created by PhpStorm.
 * User: Webmaster
 * Date: 30/01/2015
 * Time: 06:29 PM
 */


use Auditor\Repositories\SpaceDetailRepo;


class SpaceDetailController extends BaseController{

    protected $spaceDetailRepo;

    public function __construct(SpaceDetailRepo $spaceDetailRepo)
    {
        $this->spaceDetailRepo = $spaceDetailRepo;
    }

    public function resultSpaceAuditor($id)
    {
        $spacesDetail =$this->spaceDetailRepo->find($id);
        dd($spacesDetail);
    }

} 
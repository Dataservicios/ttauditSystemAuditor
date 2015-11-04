<?php

use Auditor\Repositories\RoadRepo;

class RoadController extends BaseController{

    protected $roadRepo;

    public function __construct(RoadRepo $roadRepo)
    {
        $this->roadRepo = $roadRepo;
    }

    public function listRoads()
    {
        $roads =$this->roadRepo->listRoads();
        $userType = Auth::user()->type;
        return View::make('roads/list',compact('roads','userType'));

    }

} 
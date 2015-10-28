<?php

use Auditor\Repositories\StoreRepo;
use Auditor\Managers\StoreManager;

class StoreController extends BaseController{

    protected $storeRepo;

    public function __construct(StoreRepo $storeRepo)
    {
        $this->storeRepo = $storeRepo;
    }

    public function listStores()
    {
        $stores =$this->storeRepo->listStore();
        $userType = Auth::user()->type;
        $opcion='3';
        /*dd($category);*/
        return View::make('store/list',compact('stores','userType','opcion'));

    }

    public function show($id)
    {
        $store = $this->storeRepo->find($id);
        return View::make('store/show',compact('store'));
    }

    public function store($id)
    {
        $store = $this->storeRepo->find($id);
        return View::make('store/store', compact('store'));
    }

    public function updateStore($id)
    {
        $store = $this->storeRepo->find($id);
        //dd(Input::all());
        $manager = new StoreManager($store, Input::all());
        $manager->save();
        return Redirect::route('storeEdit', $id);
    }

    public function newStore()
    {
        $store_types = \Lang::get('utils.store');
        return View::make('store/new',compact('store_types'));
    }

    public function importStore()
    {
        return View::make('store/import');
    }

    public function newRoute()
    {
        return View::make('store/routes');
    }

    public function registerStore()
    {
        $store = $this->storeRepo->newStore();
        //dd($store);
        $file = Input::file("photo");
        $store->photo = $file->getClientOriginalName();
        $manager = new StoreManager($store, Input::only(['fullname','type','owner','address','urbanization','district','region','ubigeo','distributor','latitude','longitude']));

        $manager->save();
        $file->move("img/stores",$file->getClientOriginalName());
        //dd($store);
        return Redirect::route('storeDetail', [$store->id]);

    }

} 
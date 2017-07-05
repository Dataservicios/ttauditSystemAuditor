<?php

use Auditor\Repositories\PresenceRepo;
use Auditor\Repositories\PresenceDetailRepo;
use Auditor\Repositories\UserCompanyRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\PublicitiesDetailRepo;
use Auditor\Repositories\MediaRepo;
use Auditor\Repositories\CompanyRepo;
use Auditor\Repositories\CustomerRepo;
use Auditor\Repositories\CategoryProductRepo;
use Auditor\Repositories\PublicityRepo;
use Auditor\Repositories\CompanyStoreRepo;


class ReportColgateController extends BaseController{

    protected $PresenceRepo;
    protected $PresenceDetailRepo;
    protected $UserCompanyRepo;
    protected $StoreRepo;
    protected $PublicitiesDetailRepo;
    protected $MediaRepo;
    protected $companyRepo;
    protected $customerRepo;
    protected $categoryProductRepo;
    protected $publicityRepo;
    protected $companyStoreRepo;

    public $urlBase;
    public $urlImagesPublicities;


    public function __construct(CompanyStoreRepo $companyStoreRepo,PublicityRepo $publicityRepo, CategoryProductRepo $categoryProductRepo,CustomerRepo $customerRepo,CompanyRepo $companyRepo,MediaRepo $MediaRepo,PublicitiesDetailRepo $PublicitiesDetailRepo,StoreRepo $StoreRepo, UserCompanyRepo $UserCompanyRepo, PresenceDetailRepo $PresenceDetailRepo, PresenceRepo $PresenceRepo)
    {
        $this->PresenceRepo = $PresenceRepo;
        $this->PresenceDetailRepo = $PresenceDetailRepo;
        $this->UserCompanyRepo = $UserCompanyRepo;
        $this->StoreRepo = $StoreRepo;
        $this->PublicitiesDetailRepo = $PublicitiesDetailRepo;
        $this->MediaRepo = $MediaRepo;
        $this->companyRepo = $companyRepo;
        $this->customerRepo = $customerRepo;
        $this->publicityRepo = $publicityRepo;
        $this->categoryProductRepo = $categoryProductRepo;
        $this->companyStoreRepo = $companyStoreRepo;
        $this->urlBase = \App::make('url')->to('/');
        $this->urlImages = '/media/fotos/';
    }

    public function reportHome()
    {
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        $audit_id=0;

        $menus = $this->generateMenusColgate($company_id,$audit_id);
        $valTotalVisibility = $this->getTotalVisibilityForCampaigne($company_id);
        return View::make('report/inicioHtmlColgate',compact('menus','valTotalVisibility','audit_id'));
    }

    public function auditReportAbstract($audit_id="0",$company_id="0")
    {
        $presence_id = "0";
        if ($audit_id=="0")
        {
            $valoresPost= Input::all();
            $audit_id = $valoresPost['audit_id'];
            $company_id = $valoresPost['company_id'];
            $presence_id = $valoresPost['product'];
            //dd($tipo);
        }
        $menus = $this->generateMenusColgate($company_id,$audit_id);
        if ($audit_id == 2)
        {
            $num_reg = $this->companyStoreRepo->getCountPresenceForCampaigne($company_id);//$num_reg[0]->Num_Reg
            $ListPresences = $this->PresenceRepo->getProductsForCampaigne($company_id);
            $combo = array(0 => "19 Mandatorios") + $ListPresences->lists('fullname','id');
            $total = $num_reg[0]->Num_Reg;
            $totalProduct =0;
            $product_fullname="";
            $product_id ="0";
            $valVisibleJson = "";
            if ($presence_id<>"0")
            {
                foreach ($ListPresences as $presence)
                {
                    if ($presence->id == $presence_id)
                    {
                        $product_fullname = $presence->product->fullname;
                        $product_id = $presence->product->id;
                        break;
                    }
                }
                //dd($product_fullname);
                $countstores = $this->PresenceDetailRepo->getFewStoresForPresence($presence_id);
                /*dd($countstores);*/
                $totalProduct = $countstores;
                $cantEncontrado = round(($totalProduct*100)/$total,0);
                $noencontrado = 100-$cantEncontrado;
                $chardDataVisible[0] = array("tipo" => 'Si', 'cantidad' => $cantEncontrado, 'color' => "#FE0000");
                $chardDataVisible[1] = array("tipo" => 'No', 'cantidad' => $noencontrado, 'color' => "#FFFF00");
                $valVisibleJson =json_encode($chardDataVisible);unset($chardDataVisible);
            }
            //dd($combo);
            return View::make('report/colgate/auditHtmlpresence',compact('combo','menus','audit_id','company_id','presence_id','total','totalProduct','product_fullname','valVisibleJson'));
        }
        if ($audit_id == 3)
        {

            $valSINOJson = $this->getTotalVisibilityForCampaigne($company_id);
            return View::make('report/colgate/auditHtmlvisibility',compact('menus','valSINOJson','audit_id'));
        }

    }

    public function auditReportForCategory($audit_id="0",$company_id="0",$category_id="0")
    {
        $tipo = "0";
        if ($audit_id=="0")
        {
            $valoresPost= Input::all();
            $audit_id = $valoresPost['audit_id'];
            $company_id = $valoresPost['company_id'];
            $category_id = $valoresPost['category_id'];
            $tipo = $valoresPost['tipos'];
            //dd($tipo);
        }
        $menus = $this->generateMenusColgate($company_id,$audit_id,$category_id);
        $campaigne = $this->companyRepo->find($company_id);
        $publicities = $this->publicityRepo->getPublicityForCatMat($category_id,$campaigne->id);
        $combo = array(0 => " ... Seleccione ... ") + $publicities->lists('fullname','id');

        $valores = $this->getPublicityForCategory($category_id,$company_id, $tipo);//dd($tipo);
        $valVisibleJson = $valores['visible'];
        $valLayoutJson = $valores['layout'];
        $valContaminedJson = $valores['contamined'];
        $category = $valores['categoria'];
        $total= $valores['total'];
        $total_cond = $valores['total_cond'];
        $publicity_detail_fullname = $valores['publicity_fullname'];

        return View::make('report/colgate/auditHtmlvisibilityForCategory',compact('tipo','publicity_detail_fullname','combo','menus','company_id','audit_id','valVisibleJson','valLayoutJson','valContaminedJson','category_id','category','total','total_cond'));
    }

    public function getPublicityForCategory($category_id,$company_id, $publicity_id="0")
    {
        $campaigne = $this->companyRepo->find($company_id);
        $category_product = $this->categoryProductRepo->find($category_id);
        $publicities = $this->publicityRepo->getPublicityForCatMat($category_id,$campaigne->id);
        $num_reg = $this->companyStoreRepo->getCountPublicityForCampaigne($company_id);
        $totales[] = array('category' => $category_product->fullname,  'total' => $num_reg[0]->Num_Reg);
        $c=0;$contVisible =0;$contLayout =0;$contContamined=0;
        $publicity_detail_fullname = "";
        foreach ($publicities as $publicitie)
        {
            $storesForConditionVisible = $this->PublicitiesDetailRepo->getFewStoresForVisible($publicitie->id,1);
            if (($storesForConditionVisible>$contVisible) or ($publicity_id == $publicitie->id))
            {
                $contVisible =  $storesForConditionVisible;
            }

            if ($category_id <> 42){
                $storesForConditionLayout = $this->PublicitiesDetailRepo->getFewStoresForLayout($publicitie->id,1);
                if (($storesForConditionLayout>$contLayout) or ($publicity_id == $publicitie->id))
                {
                    $contLayout =  $storesForConditionLayout;
                }
            }else{
                $contLayout =0;
            }

            $storesForConditionContamined = $this->PublicitiesDetailRepo->getFewStoresForContaminated($publicitie->id,1);
            if (($storesForConditionContamined>$contContamined) or ($publicity_id == $publicitie->id))
            {
                $contContamined = $storesForConditionContamined;
            }

            $c=$c+1;
            if ((count($publicities) == $c) or ($publicity_id == $publicitie->id))
            {
                $totales_cond[] = array('category' => $category_product->fullname,  'totalVisible' => $contVisible, 'totalLayout' => $contLayout, 'totalContamined' => $contContamined);
            }
            if ($publicity_id == $publicitie->id){
                $publicity_detail_fullname = $publicitie->fullname;
                break;
            }
        }//dd($totales_cond);
        for ($i = 0; $i < count($totales); $i++) {
            $totalVisibles = $totales_cond[$i]['totalVisible'];
            $cantVisible = round(($totales_cond[$i]['totalVisible']*100)/$totales[$i]['total'],0);
            $cantNoVisible = 100-$cantVisible;
            $chardDataVisible[0] = array("tipo" => 'Si', 'cantidad' => $cantVisible, 'color' => "#FE0000");
            $chardDataVisible[1] = array("tipo" => 'No', 'cantidad' => $cantNoVisible, 'color' => "#FFFF00");

            $cantVisible = round(($totales_cond[$i]['totalLayout']*100)/$totalVisibles,0);
            $cantNoVisible = 100-$cantVisible;
            $chardDataLayout[0] = array("tipo" => 'Si', 'cantidad' => $cantVisible, 'color' => "#FE0000");
            $chardDataLayout[1] = array("tipo" => 'No', 'cantidad' => $cantNoVisible, 'color' => "#FFFF00");

            $cantVisible = round(($totales_cond[$i]['totalContamined']*100)/$totalVisibles,0);
            $cantNoVisible = 100-$cantVisible;
            $chardDataContamined[0] = array("tipo" => 'Si', 'cantidad' => $cantVisible, 'color' => "#FE0000");
            $chardDataContamined[1] = array("tipo" => 'No', 'cantidad' => $cantNoVisible, 'color' => "#FFFF00");
        }
        $valVisibleJson =json_encode($chardDataVisible);unset($chardDataVisible);
        $valLayoutJson =json_encode($chardDataLayout);unset($chardDataLayout);
        $valContaminedJson =json_encode($chardDataContamined);unset($chardDataContamined);
        $valores = array('visible' => $valVisibleJson, 'layout' => $valLayoutJson, 'contamined' => $valContaminedJson, 'categoria' => $totales[0]['category'],'total' =>$totales[0]['total'], 'total_cond' => $totales_cond, 'publicity_fullname' => $publicity_detail_fullname);
        return $valores;
    }

    public function getDetailConditionPublicity($condition,$tipo,$publicity_id,$company_id,$category_id)
    {
        if ($condition==0){
            $detCond ="Visibles";
        }
        if ($condition==1){
            $detCond ="Layout";
        }
        if ($condition==2){
            $detCond ="Contaminados";
        }
        if ($tipo==0){
            $detTipo = "NO";
        }
        if ($tipo==1){
            $detTipo = "SI";
        }
        $listPublicitiesDetail = $this->PublicitiesDetailRepo->getDetailConditionPublicity($condition,$tipo,$publicity_id);$c=0;
        $numPublicidad = count($listPublicitiesDetail);
        foreach ($listPublicitiesDetail as $publici)
        {
            $c=$c+1;
            $store = $this->StoreRepo->find($publici->store_id);
            $photos = $this->MediaRepo->photosPublicityStore($publici->publicity_id, $store->id);
            //dd($store->id);
            if(! empty($photos)){
                //dd(\App::make('url')->to('/'));
                foreach ($photos as $photo){
                    $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlImages.$photo->archivo);
                }
            }else{
                $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
            }

            $detailStores[] = array('num' =>$c,'id'=>$publici->id,'publicity_id'=>$publici->publicity->id,'comentario'=>$publici->comment,'publicidad'=>$publici->publicity->fullname,'imagen'=>$publici->publicity->imagen,'store_id'=>$store->id,'mayorista'=>$store->fullname,'store_direccion'=>$store->address, 'created_at' =>$publici->created_at, 'arrayFoto' => $datosFoto);
            //dd($detailStores);
            unset($datosFoto);
        }
        //dd($detailStores);
        $menus = $this->generateMenusColgate($company_id,3,$category_id);
        return View::make('report/colgate/publicityDetailCondition',compact('menus','detailStores','detCond','detTipo','numPublicidad'));
    }

    public function getTotalVisibilityForCampaigne($company_id)
    {
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);
        $catMaterials = $this->categoryProductRepo->getCatMaterialsForCustomer($customer->id);
        $num_reg = $this->companyStoreRepo->getCountPublicityForCampaigne($company_id);
        foreach ($catMaterials as $category)
        {
            /*$publicities = $this->publicityRepo->getPublicityForCatMat($category->id,$campaigne->id);$c=0;$cont =0;
            foreach ($publicities as $publicitie)
            {
                $storesForPublicity = $this->PublicitiesDetailRepo->getTotalStoresForPublicity($publicitie->id);
                $c=$c+1;$cont = $cont + $storesForPublicity;
                if (count($publicities) == $c)
                {

                    $totales[] = array('category' => $category->fullname,  'total' => $cont);
                }
            }*/
            $totales[] = array('category' => $category->fullname,  'total' => $num_reg[0]->Num_Reg);
        }//dd($totales);
        foreach ($catMaterials as $category)
        {
            $publicities = $this->publicityRepo->getPublicityForCatMat($category->id,$campaigne->id);$c=0;$cont =0;
            foreach ($publicities as $publicitie)
            {
                $storesForConditions = $this->PublicitiesDetailRepo->getFewStoresForConditions($publicitie->id,$category->id);
                if ($storesForConditions>$cont)
                {
                    $cont = $storesForConditions;
                }
                $c=$c+1;
                if (count($publicities) == $c)
                {
                    $totales_cond[] = array('category' => $category->fullname,  'total' => $cont);
                }
            }
        }
        //dd($totales_cond);
        for ($i = 0; $i < count($totales); $i++) {
            $porcSI = ($totales_cond[$i]['total']*100)/$totales[$i]['total'];
            $porcNO = 100-$porcSI;
            $chardData[] = array("category" => $totales[$i]['category'], 'Si' => round($porcSI,0), 'No' => round($porcNO,0), 'color' => "#ffffff");
        }
        $valSINOJson =json_encode($chardData);unset($chardData);
        return $valSINOJson;
    }

    public function generateMenusColgate($company_id,$audit_id, $cat=0)
    {
        $AuditsCompany = $this->getAuditForCompany($company_id);
        $campaigne = $this->companyRepo->find($company_id);
        $customer =$this->customerRepo->find($campaigne->customer_id);

        $submenu1[0] = array('nombre' => '', 'url' => '', 'active' => 0,'icon' => '');
        if ($audit_id == 0)
        {
            $menus[] = array('nombre' => 'Home', 'url' => route('reportColgate'), 'active' => 1,'icon' => 'inicio', 'submenu1' => $submenu1);
        }else{
            $menus[] = array('nombre' => 'Home', 'url' => route('reportColgate'), 'active' => 0,'icon' => 'inicio', 'submenu1' => $submenu1);
        }
        $menus[] = array('nombre' => 'Reporte Excel', 'url' => 'http://ttaudit.com/reporte_colgate/reporte_final.xlsx', 'active' => 0,'icon' => 'materiales', 'submenu1' => $submenu1);

        $menus[] = array('nombre' => 'Auditorias', 'url' => '', 'active' => 0,'icon' => 'listado', 'submenu1' => $submenu1);


        foreach ($AuditsCompany as $audit)
        {
            if ($audit_id == $audit->id)
            {
                if ($audit_id == 3){
                    $catMaterials = $this->categoryProductRepo->getCatMaterialsForCustomer($customer->id);
                    //unset($submenu1);
                    foreach ($catMaterials as $category)
                    {
                        if ($cat == $category->id){
                            $submenu1[] = array('nombre' => $category->fullname, 'url' => route('auditReportCategoryColgate', array($audit->id, $company_id,$category->id)), 'active' => 0,'icon' => '', 'submenu1' => $submenu1);
                        }else{
                            $submenu1[] = array('nombre' => $category->fullname, 'url' => route('auditReportCategoryColgate', array($audit->id, $company_id,$category->id)), 'active' => 1,'icon' => '', 'submenu1' => $submenu1);
                        }

                    }
                }
                $menus[] = array('nombre' => $audit->fullname, 'url' => route('auditReportColgate', array($audit->id, $company_id)), 'active' => 1,'icon' => 'audit', 'submenu1' => $submenu1);
            }else{
                $menus[] = array('nombre' => $audit->fullname, 'url' => route('auditReportColgate', array($audit->id, $company_id)), 'active' => 0,'icon' => 'audit', 'submenu1' => $submenu1);
            }
        }
        return $menus;
    }



    public function getCountForPresenceDetail($audit_id="0",$store_id="0")
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $presences = $this->PresenceDetailRepo->getCountPresenciasDetails();
            return View::make('report/colgate/presence',compact('presences','AuditsCompany','audit_id'));
        }

    }

    public function getCountForPublicitiesDetail($audit_id="0",$store_id="0")
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $publicities = $this->PublicitiesDetailRepo->getCountPublicitiesDetails();
            return View::make('report/colgate/publicity',compact('publicities','AuditsCompany','audit_id'));
        }

    }

    public function detailPresenceDetailForPresence($presence_id,$audit_id)
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $presences = $this->PresenceDetailRepo->listPresenciasDetailsForPresence($presence_id);$c=0;
            foreach ($presences as $presence)
            {
                $c=$c+1;
                $store = $this->StoreRepo->find($presence->store_id);
                $valores[] = array('num' =>$c,'id'=>$presence->id,'product_id'=>$presence->presence->product->id,'product'=>$presence->presence->product->fullname,'imagen'=>$presence->presence->product->imagen,'store_id'=>$store->id,'mayorista'=>$store->fullname, 'created_at' =>$presence->created_at);
            }
            return View::make('report/colgate/presenceDetail',compact('valores','AuditsCompany','audit_id'));
        }
    }

    public function detailPublicityDetailForPublicity($publicities_id,$audit_id)
    {
        $userType = Auth::user()->type;
        $company = $this->UserCompanyRepo->getCompany(Auth::user()->id);
        $company_id=$company[0]->id;
        if ($userType){
            $AuditsCompany = $this->getAuditForCompany($company_id);
            $publicities = $this->PublicitiesDetailRepo->listPublicitiesDetailsForPublicity($publicities_id);$c=0;
            foreach ($publicities as $publici)
            {
                $c=$c+1;
                $store = $this->StoreRepo->find($publici->store_id);
                $photos = $this->MediaRepo->photosPublicityStore($publici->publicity_id, $store->id);
                //dd($store->id);
                if(! empty($photos)){
                    //dd(\App::make('url')->to('/'));
                    foreach ($photos as $photo){
                        $datosFoto[] = array('id' => $photo->id,'archivo' => $photo->archivo, 'urlFoto' => $this->urlBase.$this->urlImages.$photo->archivo);
                    }
                }else{
                    $datosFoto[] = array('id' => '0','archivo' => '', 'urlFoto' => '');
                }

                $valores[] = array('num' =>$c,'id'=>$publici->id,'publicity_id'=>$publici->publicity->id,'publicidad'=>$publici->publicity->fullname,'imagen'=>$publici->publicity->imagen,'store_id'=>$store->id,'mayorista'=>$store->fullname,'store_direccion'=>$store->address,'mayorista'=>$store->fullname, 'created_at' =>$publici->created_at, 'arrayFoto' => $datosFoto);
                unset($datosFoto);
            }
            return View::make('report/colgate/publicityDetail',compact('valores','AuditsCompany','audit_id'));
        }
    }
} 
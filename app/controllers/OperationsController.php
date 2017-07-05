<?php

use Auditor\Repositories\ProductStoreRegionRepo;
use Auditor\Repositories\StoreRepo;
use Auditor\Repositories\MediaRepo;
use Excel;
use Auditor\Repositories\ProductDetailRepo;

class OperationsController extends BaseController{

    protected $ProductStoreRegionRepo;
    protected $storeRepo;
    protected $mediaRepo;
    protected $productDetailRepo;

    public $urlBase;
    public $urlPhotos;

    public function __construct(ProductDetailRepo $productDetailRepo,MediaRepo $mediaRepo,StoreRepo $storeRepo,ProductStoreRegionRepo $ProductStoreRegionRepo)
    {
        $this->ProductStoreRegionRepo = $ProductStoreRegionRepo;
        $this->storeRepo = $storeRepo;
        $this->mediaRepo=$mediaRepo;
        $this->productDetailRepo = $productDetailRepo;

        $this->urlBase = \App::make('url')->to('/');
        $this->urlPhotos = 'media/fotos/';
    }

    public function addProdRegStoreForCVS($archivo,$company_id)
    {
        $file_name=$archivo;
        $row = 0;$v="";
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $fp = fopen ( 'media/archivos/'.$file_name , "r" );
        $ciudades[0] = 'LIMA';
        $ciudades[1] = 'Tacna';
        $ciudades[2] = 'Huancayo';
        $ciudades[3] = 'Cusco';
        $ciudades[4] = 'Arequipa';
        $ciudades[5] = 'Chimbote';
        $ciudades[6] = 'Trujillo';
        $ciudades[7] = 'Chiclayo';
        $ciudades[8] = 'Piura';
        while ($data = fgetcsv ($fp, 1000, ",")){
            $num = count ($data);
            $row++;$c=0;$col=1;
            if ($row<>1){//'Mini Market','Bodega Clásica','Bodega Alto Tráfico'
                for ($i = 0; $i <= 8; $i++) {
                    $c++;
                    $col=$i + 1;
                    //if ($i==3){echo '$i='.$i.' $c='.$c.' $col='.$col ;dd($data);}
                    if ($data[$c] == 2){
                        $tipo_bodega ='Mini Market';
                        $addReg = $this->ProductStoreRegionRepo->getModel();
                        $addReg->product_id = $data[0];
                        $addReg->region = $ciudades[$i];
                        $addReg->tipo_bodega = $tipo_bodega;
                        $addReg->company_id = $company_id;
                        $addReg->price = $data[$col*4];
                        $addReg->created_at = $horaSistema;
                        $addReg->updated_at = $horaSistema;
                        $addReg->save();
                        //$v .='$c='.$c." ".'$col='.$col." ".$data[0]." ".$ciudades[$i]." ".$tipo_bodega." ".$company_id." ".$data[$col*4]." ".$horaSistema." ".$horaSistema. "<br>";
                    }  else{}
                    $c++;
                    if ($data[$c] == 2){
                        $tipo_bodega ='Bodega Clásica';
                        $addReg = $this->ProductStoreRegionRepo->getModel();
                        $addReg->product_id = $data[0];
                        $addReg->region = $ciudades[$i];
                        $addReg->tipo_bodega = $tipo_bodega;
                        $addReg->company_id = $company_id;
                        $addReg->price = $data[$col*4];
                        $addReg->created_at = $horaSistema;
                        $addReg->updated_at = $horaSistema;
                        $addReg->save();
                        //$v .='$c='.$c." ".'$col='.$col." ".$data[0]." ".$ciudades[$i]." ".$tipo_bodega." ".$company_id." ".$data[$col*4]." ".$horaSistema." ".$horaSistema. "<br>";
                    }  else{}
                    $c++;
                    if ($data[$c] == 2){
                        $tipo_bodega ='Bodega Alto Tráfico';
                        $addReg = $this->ProductStoreRegionRepo->getModel();
                        $addReg->product_id = $data[0];
                        $addReg->region = $ciudades[$i];
                        $addReg->tipo_bodega = $tipo_bodega;
                        $addReg->company_id = $company_id;
                        $addReg->price = $data[$col*4];
                        $addReg->created_at = $horaSistema;
                        $addReg->updated_at = $horaSistema;
                        $addReg->save();
                        //$v .='$c='.$c." ".'$col='.$col." ".$data[0]." ".$ciudades[$i]." ".$tipo_bodega." ".$company_id." ".$data[$col*4]." ".$horaSistema." ".$horaSistema. "<br>";
                    }  else{}
                    $c++;

                }//print_r($v);dd($v);
            }

        }
dd('ok');
    }

    public function updateEjecutivoStore($archivo)
    {
        $file_name=$archivo;
        $row = 0;$v="";$c=0;
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $fp = fopen ( 'media/archivos/'.$file_name , "r" );
        while ($data = fgetcsv ($fp, 1000, ",")){
            $storeAct= $this->storeRepo->updateEjcutivoForStore($data[0],$data[1]);//dd($storeAct);
            if ($storeAct=true) {$valor = "ok";}else{$valor = "NO";}
            $store = $this->storeRepo->find($data[0]);
            $datosActualizados[] = array('store' => $store,'actualizado' => $valor);
        }//dd($datosActualizados);
        return View::make('operations/actualizaEjecutivo',compact('datosActualizados'));
    }
    
    public function deleteStoreCVS($archivo)
    {
        $file_name=$archivo;
        $row = 0;$v="";$c=0;
        $mytime = Carbon\Carbon::now();
        $horaSistema = $mytime->toDateTimeString();
        $fp = fopen ( 'media/archivos/'.$file_name , "r" );
        while ($data = fgetcsv ($fp, 1000, ",")){
            $store = $this->storeRepo->find($data[0]);
            $storeAct= $this->storeRepo->deleteStore($data[0]);//dd($storeAct);
            if ($storeAct==true) {$valor = "ok";}else{$valor = "NO";}

            $datosActualizados[] = array('store' => $store,'eliminado' => $valor);
        }//dd($datosActualizados);
        return View::make('operations/eliminaStore',compact('datosActualizados'));
    }

    public function deleteFileMedia($media_id,$type="photo"){
        $objMedia = $this->mediaRepo->find($media_id);//dd($objMedia);
        $modulo='eliminaPhoto';
        if (!is_null($objMedia)){
            if ($type=='photo'){
                $nombre_fichero = $this->urlPhotos.$objMedia->archivo;
                if (file_exists($nombre_fichero))
                {
                   if (unlink($nombre_fichero)){
                       $resultado = true;
                   }else{
                       $resultado = false;
                   }
                }else{
                    $resultado = false;
                }
            }
            $objMedia->delete();
        }

        return View::make('operations/operationsFull',compact('modulo','objMedia','resultado'));
    }

    public function deletePhoto($store_id="0",$company_id="0",$ajax="0"){
        if ($store_id=="0"){
            $valoresPost= Input::all();
            $store_id = $valoresPost['store_id'];
            $company_id = $valoresPost['company_id'];
            $ajax="1";
        }
        $objMedias = $this->mediaRepo->photosForStoreCompany($store_id,$company_id);
        if ($ajax=="1")
        {
            if (count($objMedias)>0){
                foreach ($objMedias as $objMedia) {
                    $nombre_fichero = $this->urlPhotos.$objMedia->archivo;
                    if (file_exists($nombre_fichero))
                    {
                        if (unlink($nombre_fichero)){
                            $resultado = true;
                        }else{
                            $resultado = false;
                        }
                    }else{
                        $resultado = false;
                    }
                }
                if ($resultado == true)
                {
                    header('Access-Control-Allow-Origin: *');
                    header('Content-type: application/json');
                    return  Response::json([ 'success'=> 1]);
                }else{
                    header('Access-Control-Allow-Origin: *');
                    header('Content-type: application/json');
                    return  Response::json([ 'success'=> 0]);
                }

            }
        }else{
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            return  Response::json([ 'success'=> 0]);
        }

    }

} 
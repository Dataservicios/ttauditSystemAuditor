<?php
namespace Auditor\Repositories;

use Auditor\Entities\StockProductPop;


class StockProductPopRepo extends BaseRepo{

    public function getModel()
    {
        return new StockProductPop;
    }
    
    public function getStockForPublicity($cliente,$publicity_id,$company_id)
    {
        $valores = StockProductPop::where('cadenaRuc', $cliente)->where('publicity_id',$publicity_id)->where('company_id',$company_id)->where('vigente',1)->get();
        return $valores;
    }

    public function getStockForPublicityAll($company_id)
    {
        $valores = StockProductPop::where('company_id',$company_id)->where('vigente',1)->get();
        return $valores;
    }

} 
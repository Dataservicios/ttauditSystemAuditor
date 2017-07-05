<?php
namespace Auditor\Repositories;
use Auditor\Entities\CategoryProduct;

class CategoryProductRepo extends BaseRepo {

    public function getModel()
    {
        return new CategoryProduct;
    }

    public function getCatMaterialsForCustomer($customer_id,$tipo=1)
    {
        $valores = CategoryProduct::where('customer_id', $customer_id)->where('type',$tipo)->get();
        return $valores;
    }

    public function getCategoryProductForCompany($company_id){
        $sql = "SELECT 
  `category_products`.`id`,
  `category_products`.`idpadre`,
  `category_products`.`fullname`,
  `category_products`.`type`,
  `category_products`.`customer_id`,
  `category_products`.`created_at`,
  `category_products`.`updated_at`
FROM
  `product_detail`
  INNER JOIN `products` ON (`product_detail`.`product_id` = `products`.`id`)
  INNER JOIN `category_products` ON (`products`.`category_product_id` = `category_products`.`id`)
WHERE
  `product_detail`.`company_id` = '".$company_id."' AND 
  `product_detail`.`competencia` = 0
GROUP BY
  `category_products`.`id`";

        $consulta=\DB::select($sql);
        return  $consulta;
    }

} 
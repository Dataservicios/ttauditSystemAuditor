<?php
namespace Auditor\Repositories;
use Auditor\Entities\CategoryProduct;
use Auditor\Entities\Company;


class CompanyRepo extends BaseRepo{

    public function getModel()
    {
        return new Company;
    }

    public function listCompanies()
    {
        $companies = Company::paginate();
        return $companies;
    }

    public function newCompany()
    {
        $company = new Company();
        //$user->type = 'auditor';
        return $company;
    }

    public function getNameCompany($id)
    {
        $sql = "SELECT a.id,a.fullname FROM companies a where id='". $id ."'";
        return \DB::select($sql);
    }

    public function getCategoriesProductForCompany($id)
    {
        //$categories = Company::find($id)->products->groupBy('category_product_id')->first()->category_product->fullname;
        $categories = Company::find($id)->products->groupBy('category_product_id', 'DESC');
        //dd($categories);
        $var= array();
        foreach ($categories as $cat1)
        {
            //dd($cat1);
            //dd(CategoryProduct::find($categories->id));
            foreach ($cat1 as $cat)
            {
                $var[$cat->category_product->id] =$cat->category_product->fullname;
            }
        }

        //$sql="SELECT  c.fullname,c.id FROM products p,category_products c  where p.company_id=".$id." and c.id=p.category_product_id group by p.category_product_id";
        //dd($var);
        //return \DB::select($sql);
        return $var;
        //dd(\DB::select($sql));
    }

} 
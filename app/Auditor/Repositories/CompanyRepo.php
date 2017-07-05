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

    public function getCompaniesForClient($client_id,$visible="1",$estudio="")
    {
        if ($estudio<>""){
            if ($visible=="T"){
                $consulta = Company::where('customer_id', $client_id)->where('estudio',$estudio)->get();
            }else{
                $consulta = Company::where('customer_id', $client_id)->where('visible',$visible)->where('estudio',$estudio)->get();
            }
        }else{
            if ($visible=="T"){
                $consulta = Company::where('customer_id', $client_id)->get();
            }else{
                $consulta = Company::where('customer_id', $client_id)->where('visible',$visible)->get();
            }
        }


        return $consulta;
    }

    public function getCurrentCampaigns()
    {
        $consulta = Company::where('active', 1)->get();
        return $consulta;
    }

    public function getFirstCurrentCampaigns($customer_id="0",$study_id="0")
    {
        if ($customer_id=="0"){
            $consulta = Company::where('active', 1)->where('visible',1)->orderBy('id','DESC')->first();
        }else{
            if ($study_id=="0"){
                $consulta = Company::where('customer_id',$customer_id)->where('active', 1)->where('visible',1)->orderBy('id','DESC')->first();
            }else{
                $consulta = Company::where('customer_id',$customer_id)->where('active', 1)->where('visible',1)->where('study_id',$study_id)->orderBy('id','DESC')->first();
            }

        }

        return $consulta;
    }

} 
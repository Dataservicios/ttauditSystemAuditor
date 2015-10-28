<?php
use Auditor\Repositories\CategoryProductRepo;

class CategoryProductController extends BaseController{

    protected $categoryProductRepo;

    public function __construct(CategoryProductRepo $categoryProductRepo)
    {
        $this->categoryProductRepo = $categoryProductRepo;
    }

    public function category($id)
    {
        $category =$this->categoryProductRepo->find($id);
        /*dd($category);*/
        return View::make('products/category',compact('category'));
    }
} 
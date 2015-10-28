<?php
use Auditor\Repositories\ProductRepo;

class ProductController extends BaseController{

    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function show($id)
    {
        $product = $this->productRepo->find($id);
        return View::make('products/show',compact('product'));
    }

    public function last()
    {
        $latest_products = $this->productRepo->findLatest();
        return View::make('products/latest_products',compact('latest_products'));
    }

}
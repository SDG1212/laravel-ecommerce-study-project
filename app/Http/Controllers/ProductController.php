<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * The product service instance.
     *
     * @var \App\Services\ProductService
     */
    private $productService;

    /**
     * Create a new product controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * Вывод списка товаров.
     *
     * @return \App\Http\Resources\ProductCollection
     */
    public function index(Request $request)
    {
        return (new ProductCollection($this->productService->getProducts()));
    }
}

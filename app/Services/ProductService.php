<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
	private $productRepository;

	public function __construct()
	{
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Вывод списка товаров.
	 *
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public function getProducts()
	{
	    return $this->productRepository->getProducts();
	}
}

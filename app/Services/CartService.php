<?php

namespace App\Services;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CartService
{
	/**
	 * The product repository instance.
	 *
	 * @var \App\Repositories\IProductRepository
	 */
	private IProductRepository $productRepository;

	/**
	 * Create a new service.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 *
	 * @param int $id
	 * @return array
	 */
	public function addProduct($id)
	{
		$products = session('products', []);

		if (!isset($products[$id])) {
			$products[$id]['quantity'] = 1;
		} else {
			$products[$id]['quantity'] += 1;
		}

		session(['products' => $products]);

		$products = session('products');

		return $products;
	}

	/**
	 * Редактирование товара в корзине.
	 *
	 * @param int $id
	 * @param int $quantity
	 * @return array
	 */
	public function editProduct($id, $quantity)
	{
		$products = session('products', []);

		$products[$id]['quantity'] = $quantity;

		session(['products' => $products]);

		$products = session('products');

		return $products;
	}

	/**
	 * Удаление товара из корзины.
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteProduct($id)
	{
		$products = session('products', []);

		unset($products[$id]);

		session(['products' => $products]);

		$products = session('products');

		return $products;
	}
}

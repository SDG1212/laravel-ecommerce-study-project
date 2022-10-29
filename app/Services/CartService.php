<?php

namespace App\Services;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use App\Services\CartValidatorService;
use App\Services\CartProductService;
use Illuminate\Http\Request;

class CartService
{
	private IProductRepository $productRepository;

	public function __construct()
	{
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 */
	public function addProduct(Request $request)
	{
		$products = $this->getSessionProducts($request->session());

		if (!isset($products[$request->input('id')])) {
			$products[$request->input('id')]['quantity'] = 1;
		} else {
			$products[$request->input('id')]['quantity'] += 1;
		}

		$request->session()->put('products', $products);

		$products = $request->session()->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Редактирование товара в корзине.
	 */
	public function editProduct(Request $request)
	{
		$products = $this->getSessionProducts($request->session());

		$products[$request->input('id')]['quantity'] = $request->input('quantity');

		$request->session()->put('products', $products);

		$products = $request->session()->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Удаление товара из корзины.
	 */
	public function deleteProduct(Request $request)
	{
		$products = $this->getSessionProducts($request->session());

		unset($products[$request->input('id')]);

		$request->session()->put('products', $products);

		$products = $request->session()->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Вывод товаров из корзины.
	 */
	public function getProducts(Request $request)
	{
		$products = $this->getSessionProducts($request->session());

		return $this->getCartProducts($products);
	}

	/**
	 * Вывод списка товаров в корзине.
	 */
	private function getCartProducts($products)
	{
		$products_info = $this->productRepository->getTotalProductsByIds(array_keys($products));

		$products_info->transform(function ($item, $key) use ($products) {
			$item->quantity = $products[$item->id]['quantity'];
			$item->total = round($item->price * $item->quantity, 2);

			return $item;
		});

		return $products_info;
	}

	private function getSessionProducts($session)
	{
		if ($session->exists('products')) {
			$products = $session->get('products');
		} else {
			$products = [];
		}

		return $products;
	}
}

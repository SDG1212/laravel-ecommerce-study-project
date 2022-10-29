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
	private $cartProductService;

	public function __construct()
	{
		$this->cartProductService = new cartProductService();
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 */
	public function addProduct(Request $request)
	{
		$products = $this->cartProductService->addProduct($request->session(), $request->input('id'));

		return $this->getCartProducts($products);
	}

	/**
	 * Редактирование товара в корзине.
	 */
	public function editProduct(Request $request)
	{
		$products = $this->cartProductService->editProduct($request->session(), $request->input('id'), $request->input('quantity'));

		return $this->getCartProducts($products);
	}

	/**
	 * Удаление товара из корзины.
	 */
	public function deleteProduct(Request $request)
	{
		$products = $this->cartProductService->deleteProduct($request->session(), $request->input('id'));

		return $this->getCartProducts($products);
	}

	/**
	 * Вывод товаров из корзины.
	 */
	public function getProducts(Request $request)
	{
		$products = $this->cartProductService->getProducts($request->session());

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
}

<?php

namespace App\Services;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use App\Services\CartValidatorService;
use Illuminate\Http\Request;

class CartService
{
	private IProductRepository $productRepository;
	private $cartValidatorService;

	public function __construct()
	{
		$this->cartValidatorService = new CartValidatorService();
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 */
	public function addProduct(Request $request)
	{
		$this->cartValidatorService->validateAddProduct($request);

		$products = $this->addSessionProduct($request->session(), $request->input('id'));

		return $this->getCartProducts($products);
	}

	/**
	 * Редактирование товара в корзине.
	 */
	public function editProduct(Request $request)
	{
		$this->cartValidatorService->validateEditProduct($request);

		$products = $this->editSessionProduct($request->session(), $request->input('id'), $request->input('quantity'));

		return $this->getCartProducts($products);
	}

	/**
	 * Удаление товара из корзины.
	 */
	public function deleteProduct(Request $request)
	{
		$this->cartValidatorService->validateDeleteProduct($request);

		$products = $this->deleteSessionProduct($request->session(), $request->input('id'));

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
	 * Получение списка товаров в пользовательской сессии.
	 */
	private function getSessionProducts($session)
	{
		if ($session->exists('products')) {
			$products = $session->get('products');
		} else {
			$products = [];
		}

		return $products;
	}

	/**
	 * Добавление товара в пользовательскую сессию.
	 */
	private function addSessionProduct($session, $id)
	{
		$products = $this->getSessionProducts($session);

		if (!isset($products[$id])) {
			$products[$id]['quantity'] = 1;
		} else {
			$products[$id]['quantity'] += 1;
		}

		$session->put('products', $products);

		return $session->get('products');
	}

	/**
	 * Редактирование товара в пользовательской сессии.
	 */
	private function editSessionProduct($session, $id, $quantity)
	{
		$products = $this->getSessionProducts($session);

		$products[$id]['quantity'] = $quantity;

		$session->put('products', $products);

		return $session->get('products');
	}

	/**
	 * Удаление товара из пользовательской сессии.
	 */
	private function deleteSessionProduct($session, $id)
	{
		$products = $this->getSessionProducts($session);

		unset($products[$id]);

		$session->put('products', $products);

		return $session->get('products');
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

<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartService
{
	private $productRepository;

	public function __construct()
	{
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 */
	public function addProduct(Request $request)
	{
		$products = $this->addSessionProduct($request->session(), $request->input('id'));

		return $this->getCartProducts($products);
	}

	/**
	 * Редактирование товара в корзине.
	 */
	public function editProduct(Request $request)
	{
		$products = $this->editSessionProduct($request->session(), $request->input('id'), $request->input('quantity'));

		return $this->getCartProducts($products);
	}

	/**
	 * Удаление товара из корзины.
	 */
	public function deleteProduct(Request $request)
	{
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
	 * Проверка присутствия товара в БД при добавлении товара.
	 */
	private function validateAddProduct(Request $request)
	{
		$validated = $request->validate([
			'id' => 'required|exists:products',
		]);
	}

	/**
	 * Проверка присутствия товара в БД и его объема при редактировании товара.
	 */
	private function validateEditProduct(Request $request)
	{
		$validated = $request->validate([
			'id' => 'integer|required|exists:products',
			'quantity' => 'integer|min:1|required',
		]);
	}

	/**
	 * Проверка присутствия товара в БД при удалении товара.
	 */
	private function validateDeleteProduct(Request $request)
	{
		$validated = $request->validate([
			'id' => 'integer|required|exists:products',
		]);
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

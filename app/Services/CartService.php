<?php

namespace App\Services;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use App\Services\CartValidatorService;
use Illuminate\Http\Request;

class CartService
{
	/**
	 * The product repository instance.
	 *
	 * @var \App\Repositories\IProductRepository
	 */
	private IProductRepository $productRepository;

	public function __construct()
	{
		$this->productRepository = new ProductRepository();
	}

	/**
	 * Добавление товара в корзину.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 */
	public function addProduct($session, $id)
	{
		$products = $this->getSessionProducts($session);

		if (!isset($products[$id])) {
			$products[$id]['quantity'] = 1;
		} else {
			$products[$id]['quantity'] += 1;
		}

		$session->put('products', $products);

		$products = $session->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Редактирование товара в корзине.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 * @param int $quantity
	 */
	public function editProduct($session, $id, $quantity)
	{
		$products = $this->getSessionProducts($session);

		$products[$id]['quantity'] = $quantity;

		$session->put('products', $products);

		$products = $session->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Удаление товара из корзины.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 */
	public function deleteProduct($session, $id)
	{
		$products = $this->getSessionProducts($session);

		unset($products[$id]);

		$session->put('products', $products);

		$products = $session->get('products');

		return $this->getCartProducts($products);
	}

	/**
	 * Вывод товаров из корзины.
	 *
	 * @param \Illuminate\Session\Store $session
	 */
	public function getProducts($session)
	{
		$products = $this->getSessionProducts($session);

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

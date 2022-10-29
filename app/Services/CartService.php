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
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 * @return Illuminate\Support\Collection
	 */
	public function addProduct($session, $id)
	{
		$products = $this->getProducts($session);

		if (!isset($products[$id])) {
			$products[$id]['quantity'] = 1;
		} else {
			$products[$id]['quantity'] += 1;
		}

		$session->put('products', $products);

		$products = $session->get('products');

		return $products;
	}

	/**
	 * Редактирование товара в корзине.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 * @param int $quantity
	 * @return Illuminate\Support\Collection
	 */
	public function editProduct($session, $id, $quantity)
	{
		$products = $this->getProducts($session);

		$products[$id]['quantity'] = $quantity;

		$session->put('products', $products);

		$products = $session->get('products');

		return $products;
	}

	/**
	 * Удаление товара из корзины.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @param int $id
	 * @return Illuminate\Support\Collection
	 */
	public function deleteProduct($session, $id)
	{
		$products = $this->getProducts($session);

		unset($products[$id]);

		$session->put('products', $products);

		$products = $session->get('products');

		return $products;
	}

	/**
	 * Вывод товаров из корзины.
	 *
	 * @param \Illuminate\Session\Store $session
	 * @return Illuminate\Support\Collection
	 */
	public function getProducts($session)
	{
		if ($session->exists('products')) {
			$products = $session->get('products');
		} else {
			$products = [];
		}

		return $products;
	}
}

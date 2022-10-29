<?php

namespace App\Services;

class CartProductService
{
	/**
	 * Добавление товара в пользовательскую сессию.
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

		return $session->get('products');
	}

	/**
	 * Редактирование товара в пользовательской сессии.
	 */
	public function editProduct($session, $id, $quantity)
	{
		$products = $this->getProducts($session);

		$products[$id]['quantity'] = $quantity;

		$session->put('products', $products);

		return $session->get('products');
	}

	/**
	 * Удаление товара из пользовательской сессии.
	 */
	public function deleteProduct($session, $id)
	{
		$products = $this->getProducts($session);

		unset($products[$id]);

		$session->put('products', $products);

		return $session->get('products');
	}

	/**
	 * Получение списка товаров в пользовательской сессии.
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

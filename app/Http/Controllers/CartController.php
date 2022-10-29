<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;
use App\Services\CartValidatorService;
use App\Http\Resources\CartCollection;

class CartController extends Controller
{
	/**
	 * The cart service instance.
	 *
	 * @var \App\Services\CartService
	 */
	private $cartService;

	/**
	 * The cart validator service instance.
	 *
	 * @var \App\Services\CartValidatorService
	 */
	private $cartValidatorService;

	public function __construct()
	{
		$this->cartValidatorService = new CartValidatorService();
		$this->cartService = new CartService();
	}

	/**
	 * Добавление товара в корзину.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Http\Resources\CartCollection
	 */
	public function addProduct(Request $request)
	{
		$this->cartValidatorService->validateAddProduct($request);

		$products = $this->cartService->addProduct($request);

		return (new CartCollection($products));
	}

	/**
	 * Редактирование товара в корзине.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Http\Resources\CartCollection
	 */
	public function editProduct(Request $request)
	{
		$this->cartValidatorService->validateEditProduct($request);

		$products = $this->cartService->editProduct($request);

		return (new CartCollection($products));
	}

	/**
	 * Удаление товара из корзины.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Http\Resources\CartCollection
	 */
	public function deleteProduct(Request $request)
	{
		$this->cartValidatorService->validateDeleteProduct($request);

		$products = $this->cartService->deleteProduct($request);

		return (new CartCollection($products));
	}

	/**
	 * Вывод списка товаров корзины.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Http\Resources\CartCollection
	 */
	public function getInfo(Request $request)
	{
		$products = $this->cartService->getProducts($request);

		return (new CartCollection($products));
	}
}

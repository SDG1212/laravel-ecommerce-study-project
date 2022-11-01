<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Resources\CartCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
	/**
	 * The cart service instance.
	 *
	 * @var \App\Services\CartService
	 */
	private $cartService;

	/**
	 * Create a new controller.
	 *
	 * @return void
	 */
	public function __construct()
	{
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
		$validated_data = $request->validate([
			'id' => [
				'required',
				'integer',
				'exists:products',
				function($attribute, $value, $fail) {
					$products = session('products', []);

					if (isset($products[$value])) {
						$is_product_available = DB::table('products')->where('quantity', '>=', ++$products[$value]['quantity'])->find($value);

						if (!$is_product_available) {
							$fail('The quantity is invalid.');
						}
					} else {
						$is_product_available = DB::table('products')->where('quantity', '>=', 1)->find($value);

						if (!$is_product_available) {
							$fail('The quantity is invalid.');
						}
					}
				}
			],
		]);

		$products = $this->cartService->addProduct($validated_data['id']);

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
		$validated_data = Validator::make($request->all(), [
			'id' => ['required', 'integer', 'exists:products'],
			'quantity' => [
				'required',
				'integer',
				'min:1',
				function($attribute, $value, $fail) use ($request) {
					$is_product_available = DB::table('products')->where('quantity', '>=', $value)->find($request->input('id'));

					if (!$is_product_available) {
						$fail('The ' . $attribute . ' is invalid.');
					}
				},
			]
		])->validated();

		$products = $this->cartService->editProduct($validated_data['id'], $validated_data['quantity']);

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
		$validated_data = $request->validate([
			'id' => ['required', 'integer', 'exists:products'],
		]);

		$products = $this->cartService->deleteProduct($validated_data['id']);

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
		$products = $this->cartService->getProducts();

		return (new CartCollection($products));
	}
}

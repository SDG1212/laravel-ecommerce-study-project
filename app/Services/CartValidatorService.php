<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartValidatorService
{
	/**
	 * Проверка присутствия товара в БД при добавлении товара.
	 */
	public function validateAddProduct(Request $request)
	{
		$request->validate([
			'id' => ['required', 'integer', 'exists:products'],
		]);
	}

	/**
	 * Проверка присутствия товара в БД и его объема при редактировании товара.
	 */
	public function validateEditProduct(Request $request)
	{
		$request->validate([
			'id' => ['required', 'integer', 'exists:products'],
			'quantity' => ['required', 'integer', 'min:1'],
		]);
	}

	/**
	 * Проверка присутствия товара в БД при удалении товара.
	 */
	public function validateDeleteProduct(Request $request)
	{
		$request->validate([
			'id' => ['required', 'integer', 'exists:products'],
		]);
	}
}

<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
	/**
	 * Вывод списка товаров.
	 *
	 * @param array $data
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public function getProducts()
	{
		$query_results = DB::table('products')->select('id', 'name', 'image')->paginate(12)->onEachSide(1);

		return $query_results;
	}
}

<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository implements IProductRepository
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

	/**
	 * Вывод списка товаров по ID.
	 *
	 * @param array $ids
	 * @return 
	 */
	public function getTotalProductsByIds($ids)
	{
		$query_results = DB::table('products')->select('id', 'name', 'image', 'price')->whereIn('id', $ids)->get();

		return $query_results;
	}
}

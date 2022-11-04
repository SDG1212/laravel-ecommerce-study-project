<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CatalogMenu extends Component
{
	/**
	 * Список категорий.
	 *
	 * @var array
	 */
	private $categories = [];

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->categories = DB::table('categories')->select('id', 'name')->get();

		$this->categories->transform(function ($item, $key) {
			$item->url = url("/shop/{$item->id}");

			return $item;
		});
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render()
	{
		return view('components.catalog-menu', ['categories' => $this->categories]);
	}
}

<?php

namespace App\Repositories;

interface IProductRepository
{
	public function getProducts();

	public function getTotalProductsByIds($ids);
}

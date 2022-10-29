<?php

namespace App\Http\Resources;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use App\Http\Resources\CartProductCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
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
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = $this->getProducts($request->session());

        return [
            'products' => $products,
            'total' => number_format($products->sum(function($product) {
                return $product->total;
            }), 2, '.', ' '),
        ];
    }

    private function getProducts($session)
    {
        if ($session->exists('products')) {
            $products = $session->get('products');
        } else {
            $products = [];
        }

        $products_info = $this->productRepository->getTotalProductsByIds(array_keys($products));

        $products_info->transform(function ($item, $key) use ($products) {
            $item->quantity = $products[$item->id]['quantity'];
            $item->total = round($item->price * $item->quantity, 2);

            return $item;
        });

        return $products_info;
    }
}

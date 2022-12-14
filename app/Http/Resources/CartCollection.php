<?php

namespace App\Http\Resources;

use App\Repositories\IProductRepository;
use App\Repositories\ProductRepository;
use App\Http\Resources\CartProductCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'products' => $this->collection,
            'total' => number_format($this->collection->sum(function($product) {
                return $product->total;
            }), 2, '.', ' '),
        ];
    }
}

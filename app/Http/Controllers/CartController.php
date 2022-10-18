<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartCollection;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->session()->exists('products')) {
            $products = $request->session()->get('products');
        } else {
            $products = [];
        }

        if (!isset($products[$request->input('id')])) {
            $products[$request->input('id')]['quantity'] = 1;
        } else {
            $products[$request->input('id')]['quantity'] += 1;
        }

        $request->session()->put('products', $products);

        return $this->getCartInfo($request);
    }

    public function editProduct(Request $request)
    {
        if ($request->session()->exists('products')) {
            $products = $request->session()->get('products');
        } else {
            $products = [];
        }

        $request->validate([
            'id' => 'integer|required',
            'quantity' => 'integer|min:1|required',
        ]);

        $products[$request->input('id')]['quantity'] = $request->input('quantity');

        $request->session()->put('products', $products);

        return $this->getCartInfo($request);
    }

    public function deleteProduct(Request $request)
    {
        if ($request->session()->exists('products')) {
            $products = $request->session()->get('products');
        } else {
            $products = [];
        }

        unset($products[(int)$request->input('id')]);

        $request->session()->put('products', $products);

        return $this->getCartInfo($request);
    }

    public function getInfo(Request $request)
    {
        if ($request->session()->has('products')) {
            return $this->getCartInfo($request);
        }
    }

    private function getCartInfo(Request $request) {
        $products = $request->session()->get('products');

        $products_info = DB::table('products')->select('id', 'name', 'image', 'price')->whereIn('id', array_keys($products))->get();

        $products_info->transform(function ($item, $key) use ($products) {
            $item->quantity = $products[$item->id]['quantity'];
            $item->total = $item->price * $item->quantity;

            return $item;
        });

        return (new CartCollection($products_info));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Resources\SearchCollection;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = DB::table('products')->select('id', 'name', 'image')->where('name', 'like',  '%' . $request->input('text') . '%')->limit(4)->get();

        return (new SearchCollection($products));
    }
}

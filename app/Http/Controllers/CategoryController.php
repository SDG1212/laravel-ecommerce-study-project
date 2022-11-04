<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $categoryInfo = DB::table('categories')->select('name')->find($id);

        return view('category', ['name' => $categoryInfo->name]);
    }
}

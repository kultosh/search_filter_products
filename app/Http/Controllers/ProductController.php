<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json('hello');
        if($request->search)
        {
            Product::where('name', 'like', '%'. $request->search . '%')->orderBy('id', 'desc')->paginate(5);
        }

        $products = Product::orderBy('id', 'desc')->paginate(5);
        return response(['products' => $products], 200);
    }
}

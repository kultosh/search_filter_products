<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // return response()->json('hello');
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return response(['products' => $products], 200);
    }
}

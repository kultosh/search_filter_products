<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json('hello');
        // return $request;

        return Product::when(request('search'), function($query) {
            $query->where('name','like','%' . request('search'). '%');
        })->orderBy('id', 'desc')->paginate(3)->setPath ( '' );

        // if($request->search)
        // {
        //     Product::where('name', 'like', '%'. $request->search . '%')->orderBy('id', 'desc')->paginate(5);
        // }
            // return $request;
            // return Product::orderBy('id', 'desc')->paginate($request->total);
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return response(['data' => $products], 200);
    }

    public function test()
    {
        $q = request('search');
        if($q != ""){
            $product = Product::where ( 'name', 'LIKE', '%' . $q . '%' )->paginate (3)->setPath ( '' );
            return response(['data' => $product], 200);
        }
        // $pagination = $product->appends ( array (
        //     'q' => Input::get ( 'q' ) 
        // ) );
        // if (count ( $user ) > 0)
        // return view ( 'welcome' )->withDetails ( $user )->withQuery ( $q );
        // }
        // return view ( 'welcome' )->withMessage ( 'No Details found. Try to search again !' );
    }
}

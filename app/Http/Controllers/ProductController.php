<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json('hello');
        // return $request;

        return Product::when(request('search'), function($query) {
            $query->where('name','like','%' . request('search'). '%');
        })->orderBy('id', 'desc')->paginate(3);

        // if($request->search)
        // {
        //     Product::where('name', 'like', '%'. $request->search . '%')->orderBy('id', 'desc')->paginate(5);
        // }
            // return $request;
            // return Product::orderBy('id', 'desc')->paginate($request->total);
        // $products = Product::orderBy('id', 'desc')->paginate(5);
        // return response(['data' => $products], 200);
    }

   public function userFilter()
   {
       try {
        $users = User::get(['id','name']);
        return response(['data' => $users], 200);
       } catch (\Exception $error) {
           return response(['error' => $error], 500);
       }
   }

   public function getFilter()
   {
    //    return response()->json(json_decode(request('sort')));
       return Product::when(request('sort'), function($query) {
           $query->whereIn('user_id', json_decode(request('sort')));
       })->orderBy('id','desc')->paginate(3);
   }
}

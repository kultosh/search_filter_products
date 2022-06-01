<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Psy\debug;

class ProfileController extends Controller
{
    public function index()
    {
        // $user = User::with('products')->findOrFail(Auth::id());
        $user = User::findOrFail(Auth::id());
        $products = Product::where('user_id', Auth::id())->orderBy('id', 'desc');
        $getProducts = $products->paginate(3);
        $user['total_products'] = $products->count();
        return response(['user' => $user, 'products' => $getProducts]);
    }

    public function pagination()
    {
        try {
            return Product::where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(3);
        } catch (Exception $error) {
            return response(['error' => $error], 500);
        }
    }
}

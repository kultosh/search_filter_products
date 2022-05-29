<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            return Product::when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })->orderBy('id', 'desc')->paginate(3);
        } catch (Exception $error) {
            return response(['error' => $error], 500);
        }
    }

    public function userFilter()
    {
        try {
            $users = User::get(['id', 'name']);
            return response(['data' => $users], 200);
        } catch (Exception $error) {
            return response(['error' => $error], 500);
        }
    }

    public function getFilter()
    {
       try {
            return Product::when(request('sort'), function ($query) {
                $query->whereIn('user_id', json_decode(request('sort')));
            })->orderBy('id', 'desc')->paginate(3);
       } catch (Exception $error) {
            return response(['error' => $error], 500);
       }
    }

    public function searchSortFilter()
    {
        try {
            if (json_decode(request('sort')) && request('search')) {
                return Product::whereIn('user_id', json_decode(request('sort')))->where('name', 'like', '%' . request('search') . '%')->orderBy('id', 'desc')->paginate(3);
            }
            return false;
        } catch (Exception $error) {
            return response(['error' => $error], 500);
        }
    }

    public function filterPrice()
    {
        try {
            if (json_decode(request('sort')) && request('search') && json_decode(request('user'))) {
                return Product::when(in_array(1, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '<', '100')->whereIn('user_id', json_decode(request('user')))->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(2, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['100', '500'])->whereIn('user_id', json_decode(request('user')))->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(3, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['500', '1000'])->whereIn('user_id', json_decode(request('user')))->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(4, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '>', '1000')->whereIn('user_id', json_decode(request('user')))->where('name', 'like', '%' . request('search') . '%');
                })->orderBy('price', 'desc')->paginate(3);
            }
            else if (json_decode(request('sort')) && json_decode(request('user'))) {
                return Product::when(in_array(1, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '<', '100')->whereIn('user_id', json_decode(request('user')));
                })->when(in_array(2, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['100', '500'])->whereIn('user_id', json_decode(request('user')));
                })->when(in_array(3, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['500', '1000'])->whereIn('user_id', json_decode(request('user')));
                })->when(in_array(4, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '>', '1000')->whereIn('user_id', json_decode(request('user')));
                })->orderBy('price', 'desc')->paginate(3);
            } 
            else if (json_decode(request('sort')) && request('search')) {
                return Product::when(in_array(1, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '<', '100')->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(2, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['100', '500'])->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(3, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['500', '1000'])->where('name', 'like', '%' . request('search') . '%');
                })->when(in_array(4, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '>', '1000')->where('name', 'like', '%' . request('search') . '%');
                })->orderBy('price', 'desc')->paginate(3);
            } else if (json_decode(request('sort'))) {
                return Product::when(in_array(1, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '<', '100');
                })->when(in_array(2, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['100', '500']);
                })->when(in_array(3, json_decode(request('sort'))), function ($query) {
                    $query->orWhereBetween('price', ['500', '1000']);
                })->when(in_array(4, json_decode(request('sort'))), function ($query) {
                    $query->orWhere('price', '>', '1000');
                })->orderBy('price', 'desc')->paginate(3);
            }
            return false;
        } catch (Exception $error) {
            return response(['error' => $error], 500);
        }
    }
}

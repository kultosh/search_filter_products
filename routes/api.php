<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/user/filter', [ProductController::class, 'userFilter']);
    Route::get('/filter', [ProductController::class, 'getFilter']);
    Route::get('/search-filter', [ProductController::class, 'searchSortFilter']);
    Route::get('/search-filter-price', [ProductController::class, 'filterPrice']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/pagination', [ProfileController::class, 'pagination']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
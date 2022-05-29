<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
    Route::get('/logout', [AuthController::class, 'logout']);
});
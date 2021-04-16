<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) { return $request->user(); });


Route::group(['prefix' => 'admin'],function (){
    Route::post('login', 'API\AdminController@login');
    Route::get('category/index','API\CategoriesController@index')-> middleware(['auth:admin-api']);
    Route::post('category/store','API\CategoriesController@store')-> middleware(['auth:admin-api']);
    Route::get('category/show/{id}','API\CategoriesController@show')-> middleware(['auth:admin-api']);
    Route::post('category/update/{id}','API\CategoriesController@update')-> middleware(['auth:admin-api']);
    Route::delete('category/delete/{id}','API\CategoriesController@destroy')-> middleware(['auth:admin-api']);

    /////////////////////////////////// products Routes /////////////////////////////////////

    Route::get('product/index','API\ProductsController@index')-> middleware(['auth:admin-api']);
    Route::post('product/store','API\ProductsController@store')-> middleware(['auth:admin-api']);
    Route::get('product/show/{id}','API\ProductsController@show')-> middleware(['auth:admin-api']);
    Route::post('product/update/{id}','API\ProductsController@update')-> middleware(['auth:admin-api']);
    Route::delete('product/delete/{id}','API\ProductsController@destroy')-> middleware(['auth:admin-api']);
});

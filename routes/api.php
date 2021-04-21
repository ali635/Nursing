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

// Route::middleware('auth:api')->get('/user', function (Request $request) { return $request->user(); });

// Client Login
Route::post('register', 'API\ClientAuthController@register');
Route::post('login', 'API\ClientAuthController@login');

// for update client info by client
Route::middleware('auth:client')->group(function(){
    Route::post('client/update/{id}','API\ClientInfoController@update');
    Route::post('logout','API\ClientAuthController@logoutApi');

});


// for nurse login
Route::post('register', 'API\NurseAuthController@register');
Route::post('login', 'API\NurseAuthController@login');

// for update nurse info by nurse
Route::middleware('auth:api')->group(function(){
    Route::post('nurse/update/{id}','API\NurseInfoController@update');
    Route::post('product/upload/{id}','API\NurseInfoController@uploadImage');
    Route::post('logout','API\NurseAuthController@logoutApi');


});

Route::group(['prefix' => 'admin'],function (){
    Route::post('login', 'API\AdminController@login');
    Route::post('logout','API\AdminController@logoutApi')-> middleware(['auth:admin-api']);

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

    //////////////////////////////// Nurse Routes //////////////////////////////////////////////////////
    ////////////////////// this for admin to give information about nurse and insert   //////////////////////////////

    Route::get('nurse/index','API\NurseInfoController@index')-> middleware(['auth:admin-api']);
    Route::post('nurse/store','API\NurseInfoController@store')-> middleware(['auth:admin-api']);
    Route::get('nurse/show/{id}','API\NurseInfoController@show')-> middleware(['auth:admin-api']);
    Route::delete('nurse/delete/{id}','API\NurseInfoController@destroy')-> middleware(['auth:admin-api']);

    ///////////// client routes ////////////////////////////////////////////////////

    Route::get('product/index','API\ClientInfoController@index')-> middleware(['auth:admin-api']);
    Route::post('product/store','API\ClientInfoController@store')-> middleware(['auth:admin-api']);
    Route::get('product/show/{id}','API\ClientInfoController@show')-> middleware(['auth:admin-api']);
    Route::delete('product/delete/{id}','API\ClientInfoController@destroy')-> middleware(['auth:admin-api']);

});

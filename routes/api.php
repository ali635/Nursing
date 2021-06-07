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
Route::group(['prefix' => 'client'],function (){
    Route::post('register', 'API\ClientAuthController@register');
    Route::post('login', 'API\ClientAuthController@login');

    // for update client info by client
    Route::middleware('auth:client')->group(function(){
        Route::post('update/{id}','API\ClientInfoController@update');
        Route::post('order/store','API\OrdersController@store');
        Route::post('logout','API\ClientAuthController@logoutApi');
        // wishlists routes
        Route::post('wishlist', 'API\WishlistController@store');
        Route::delete('wishlist', 'API\WishlistController@destroy');
        Route::get('wishlist/products', 'API\WishlistController@index');
        Route::get('profile/order', 'API\HomeController@index');

    });

});

// for nurse login
Route::group(['prefix' => 'nurse'],function (){
    Route::post('register', 'API\NurseAuthController@register');
    Route::post('login', 'API\NurseAuthController@login');
    // for update nurse info by nurse
    Route::middleware('auth:api')->group(function(){
        Route::post('nurse/update/{id}','API\NurseInfoController@update');
        //Route::post('nurse/upload/{id}','API\NurseInfoController@uploadImage');
        Route::post('logout','API\NurseAuthController@logoutApi');
    });
});



Route::group(['prefix' => 'admin'],function (){
    Route::post('login', 'API\AdminController@login');
    // you masy login in system 
    Route::middleware('auth:admin-api')->group(function(){
        Route::post('logout','API\AdminController@logoutApi');
        Route::apiResource('category','API\CategoriesController');
        Route::apiResource('product','API\ProductsController');
        Route::apiResource('nurse','API\NurseInfoController')->except(['update']);
        Route::apiResource('client','API\ClientInfoController')->except(['update']);
        Route::apiResource('order','API\OrdersController')->except(['store']);
        Route::get('Dashboard', 'API\StatisticsController@index');
        Route::get('Dashboard/all/nurse', 'API\StatisticsController@getAllNurse');
        Route::get('Dashboard/noactive/nurse', 'API\StatisticsController@getNoNurse');
    });
});

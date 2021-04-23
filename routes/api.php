<?php
use App\client;
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

// Client Login
Route::post('client/register', 'API\ClientAuthController@register');
Route::post('client/login', 'API\ClientAuthController@login');
//  client CRUD With logout
Route::middleware('auth:client')->group(function(){
     Route::apiResource('client','API\ClientInfoController');
     Route::post('client/logout','API\ClientAuthController@logoutApi');
});

// for nurse login
Route::post('nurse/register', 'API\NurseAuthController@register');
Route::post('nurse/login', 'API\NurseAuthController@login');
// for update nurse info by nurse
Route::middleware('auth:api')->group(function(){
    Route::apiResource('nurse','API\NurseInfoController')->only(['update']);
    Route::post('product/upload/{id}','API\NurseInfoController@uploadImage');
    Route::post('logout','API\NurseAuthController@logoutApi');
});

// admin login
Route::post('admin/login', 'API\AdminController@login');
// Admin Control on CRUD category and product and nurse with logout
Route::group(['prefix' => 'admin','middleware' => 'auth:admin-api'],function (){
    Route::apiResource('category','API\CategoriesController');
    Route::apiResource('product','API\ProductsController');
    Route::apiResource('nurse','API\NurseInfoController')->except(['update']);
    Route::post('logout','API\AdminController@logoutApi');
});

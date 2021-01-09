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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'apiJWT',
    'prefix'     => 'devsfood',
    'namespace'  => 'Api'], function () {

    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/me', 'AuthController@me');
    Route::post('auth/refresh', 'AuthController@refresh');

    Route::get('users', 'UserController@index');


    Route::get('user', 'UserController@show');
    Route::put('user', 'UserController@update');           // ([name, email, password])

    Route::post('address', 'DeliveryController@store');
    Route::get('address', 'DeliveryController@show');

    Route::get('orders', 'OrderController@index');
    Route::get('orders/{id}', 'OrderController@show');
    Route::post('orders', 'OrderController@store');         // (id_adress, [cupom], products, payment_type, delivery_cost, delivery_time)
    Route::put('orders/{id}', 'OrderController@update');    // ([payment_data, payment_status, process_status])
});


Route::group(['prefix' => 'devsfood', 'namespace' => 'Api'], function () {

    // Legenda:
    // * = endpoint precisa de auth

    // Formas de envio do AUTH:
    // - Authorization: Bearer TOKEN
    // - QueryString token: TOKEN

    Route::post('auth/login', 'AuthController@login');


    Route::post('user', 'UserController@store');               // (name, email, password)


    Route::get('categories', 'CategoryController@index');

    Route::get('products', 'ProductController@index');         // ([search, page, category])
    Route::get('products/{id}', 'ProductController@show');

    Route::get('deliverycalc', 'DeliveryController@index');      // ([id_address, street, zipcode, city, state])
    Route::get('cupom', 'DeliveryController@cupom');                // (code)



    Route::get('frete', 'DeliveryController@frete');
});

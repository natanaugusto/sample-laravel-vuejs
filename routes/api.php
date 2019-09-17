<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'products'], function() {
        Route::get('/', 'Products@index')->name('products.index');
        Route::get('/{id}', 'Products@show');
        Route::post('/', 'Products@store');
        Route::put('/{id}', 'Products@update');
        Route::delete('/{id}', 'Products@destroy');
    });

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', 'Categories@index');
        Route::get('/{id}', 'Categories@show');
        Route::post('/', 'Categories@store');
        Route::put('/{id}', 'Categories@update');
        Route::delete('/{id}', 'Categories@destroy');
    });
});

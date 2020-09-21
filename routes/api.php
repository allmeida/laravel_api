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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('api.')->group(function(){
    Route::prefix('produtos')->group(function(){
        Route::get('/', 'ProdutoController@index');
        Route::get('/{id}', 'ProdutoController@show');

        Route::post('/', 'ProdutoController@store');
        Route::put('/{id}', 'ProdutoController@update');

        Route::delete('/{id}', 'ProdutoController@delete');
    });
});

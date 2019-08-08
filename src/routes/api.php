<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\InvoicesController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('user/login', 'LoginController@login');
        Route::post('user/register', 'RegisterController@register');
    });


    Route::get('status', 'InvoicesController@getInvoiceByNumber')
        ->name('getInvoiceNumber')->middleware('jwt.auth');
    Route::get('catalog', 'CatalogController@getCatalogByType')
        ->name('catalog')->middleware('jwt.auth');
    Route::get('report', 'LeadsController@showByNumber')
        ->name('report')->middleware('jwt.auth');
});

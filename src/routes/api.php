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


//Дичь какая то надо реализовать это более красиво

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization");

Route::group(['namespace' => 'Api', 'middleware' => ['api.headers']], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('user/login', 'LoginController@login');
        Route::post('user/register', 'RegisterController@register');
    });


    Route::get('status', 'InvoicesController@getInvoiceByNumber')
        ->name('getInvoiceNumber')->middleware('jwt.auth');

    Route::get('catalog/directions', 'CatalogController@directions')
        ->name('directions')->middleware('jwt.auth');
    Route::get('catalog/cities', 'CatalogController@cities')
        ->name('cities')->middleware('jwt.auth');
    Route::get('catalog/countries', 'CatalogController@countries')
        ->name('countries')->middleware('jwt.auth');
    Route::get('catalog/cities-to/{cityFromCode}', 'CatalogController@getDirectionsCityToFromCityFrom')
        ->name('cities-to')->middlware('jwt.auth');


    Route::get('report', 'LeadsController@list')
        ->name('report')->middleware('jwt.auth');

    Route::post('order', 'OrdersController@add')
        ->name('add-order')->middleware('jwt.auth');

    Route::get('templates', 'TemplatesController@list')
        ->name('list-templates')->middleware('jwt.auth');

    Route::post('templates', 'TemplatesController@add')
        ->name('add-template')->middleware('jwt.auth');

});

<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\InvoicesController;
use App\Http\Controllers\Api\Auth\LoginController;

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
        Route::post('auth/login', LoginController::class . '@login');
    });


    Route::get('status', 'InvoicesController@getInvoiceByNumber')
        ->name('getInvoiceNumber');
});

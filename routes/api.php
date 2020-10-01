<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

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

Route::group(['prefix' => "app"], function () {
    Route::group(['middleware' => 'api_basic_auth'], function () {
        Route::post('login', [AppController::class, 'login']);
    });
});

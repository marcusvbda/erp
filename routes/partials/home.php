<?php
Route::get('', 'HomeController@index')->name("admin.home");
Route::group(['prefix' => "dashboard"], function () {
    Route::post('get_info/{type}', 'HomeController@getInfo')->name("admin.get_info");
});

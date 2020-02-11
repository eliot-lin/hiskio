<?php

Route::group(['namespace' => 'Hiskio\Shoppingcart\Http\Controllers'], function() {
    Route::get('cart', 'CartController@index')->name('cart');
    
    Route::post('add', 'CartController@add');
    Route::post('del', 'CartController@del');
    Route::post('cache', 'CartController@cache');
});
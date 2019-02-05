<?php

Route::group(['prefix' => '/producers/{producerId}'], function () {
    Route::get('/nodes', 'Api\Account\ProducersController@nodes');

    // Products
    Route::get('/products', 'Api\Account\ProductsController@products');
});
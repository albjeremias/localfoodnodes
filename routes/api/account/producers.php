<?php

Route::group(['prefix' => '/producers/{producerId}'], function () {
    Route::get('/nodes', 'Api\Account\ProducersController@nodes');
    Route::get('/nodes/{nodeId}/add', 'Api\Account\ProducersController@addNode');
    Route::get('/nodes/{nodeId}/remove', 'Api\Account\ProducersController@removeNode');

    // Products
    Route::get('/products', 'Api\Account\ProductsController@products');
});
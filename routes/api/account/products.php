<?php

Route::group(['prefix' => '/producers/{producerId}/products/{productId}'], function() {
    Route::get('/', 'Api\Account\ProductsController@product');
    Route::post('/', 'Api\Account\ProductsController@updateProduct');

    Route::post('/deliveries/{nodeId}/{date}/add', 'Api\Account\ProductsController@addProductNodeDeliveryLink');
    Route::post('/deliveries/{nodeId}/{date}/update', 'Api\Account\ProductsController@updateProductNodeDeliveryLink');
    Route::delete('/deliveries/{nodeId}/{date}/delete', 'Api\Account\ProductsController@deleteProductNodeDeliveryLink');

    Route::get('/variant', 'Api\Account\ProductsController@getNewVariant');
    Route::get('/variants', 'Api\Account\ProductsController@variants');
    Route::post('/variants', 'Api\Account\ProductsController@updateVariants');
    Route::delete('/variants/{variantId}', 'Api\Account\ProductsController@deleteVariant');

    Route::get('/stock', 'Api\Account\ProductsController@stock');
    Route::post('/stock', 'Api\Account\ProductsController@updateStock');
});
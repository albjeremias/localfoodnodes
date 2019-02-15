<?php

// Activate all products
Route::post('/producers/{producerId}/products/toggle-visibility', 'Api\Account\ProductsController@setAllProductsVisibilityToggle');

Route::group(['prefix' => '/producers/{producerId}/products/{productId}'], function() {
    Route::get('/', 'Api\Account\ProductsController@product');
    Route::post('/', 'Api\Account\ProductsController@updateProduct');

    Route::post('/toggle-visibility', 'Api\Account\ProductsController@setProductVisibilityToggle');

    Route::get('/variant', 'Api\Account\ProductsController@getNewVariant');
    Route::get('/variants', 'Api\Account\ProductsController@variants');
    Route::post('/variants', 'Api\Account\ProductsController@updateVariants');
    Route::delete('/variants/{variantId}', 'Api\Account\ProductsController@deleteVariant');

    Route::get('/stock', 'Api\Account\ProductsController@stock');
    Route::post('/stock', 'Api\Account\ProductsController@updateStock');
});
<?php

// Activate all products
Route::post('/producers/{producerId}/products/toggle-visibility', 'Api\Account\ProductsController@setAllProductsVisibilityToggle');

Route::group(['prefix' => '/producers/{producerId}/products/{productId}'], function() {
    Route::post('/toggle-visibility', 'Api\Account\ProductsController@setProductVisibilityToggle');
    Route::post('/', 'Api\Account\ProductsController@updateProduct');
});
<?php

// Activate all products
Route::post('/producers/{producerId}/products/visible', 'Api\Account\ProductsController@setAllProductsVisible');
Route::post('/producers/{producerId}/products/hidden', 'Api\Account\ProductsController@setAllProductsHidden');

Route::group(['prefix' => '/producers/{producerId}/products/{productId}'], function() {
    Route::post('/visible', 'Api\Account\ProductsController@setProductVisible');
    Route::post('/hidden', 'Api\Account\ProductsController@setProductHidden');
    Route::post('/', 'Api\Account\ProductsController@updateProduct');
});
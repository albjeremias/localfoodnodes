<?php

Route::group(['prefix' => '/nodes/{nodeId}'], function() {
    Route::post('/date', 'Api\Account\NodesController@createDate');
    Route::delete('/date/{date}', 'Api\Account\NodesController@deleteDate');
    Route::get('/dates', 'Api\Account\NodesController@dates');

    Route::get('/products/{date}', 'Api\Account\NodesController@productNodeDeliveryLinks');
});
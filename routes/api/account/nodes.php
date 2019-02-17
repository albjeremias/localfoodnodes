<?php

Route::group(['prefix' => '/nodes/{nodeId}'], function () {
    Route::get('/deliveries', 'Api\Account\NodesController@deliveries');
    Route::get('/products/{date}', 'Api\Account\NodesController@productNodeDeliveryLinks');
});
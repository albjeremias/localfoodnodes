<?php

Route::group(['prefix' => '/nodes/{nodeId}'], function () {
    Route::get('/deliveries', 'Api\Account\NodesController@deliveries');
});
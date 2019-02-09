<?php

Route::group(['prefix' => '/users'], function() {
    Route::get('/user', 'Api\Account\UsersController@user');
    Route::get('/nodes', 'Api\Account\UsersController@nodes');
});
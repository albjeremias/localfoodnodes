<?php

Route::get('/translations', 'Api\PublicApiController@translations');
Route::get('/currencies', 'Api\PublicApiController@currencies');
Route::get('/nodes', 'Api\PublicApiController@nodes');

Route::group(['prefix' => '/economy'], function () {
    Route::get('/transactions', 'Api\PublicApiController@transactions');
});

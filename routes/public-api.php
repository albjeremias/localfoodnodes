<?php

Route::get('/translations', 'PublicApiController@translations');
Route::get('/currencies', 'PublicApiController@currencies');
Route::get('/nodes', 'PublicApiController@nodes');

Route::group(['prefix' => '/economy'], function () {
    Route::get('/transactions', 'PublicApiController@transactions');
});

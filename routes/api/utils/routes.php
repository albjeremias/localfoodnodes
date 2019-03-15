<?php

Route::get('/translations', 'Api\UtilsApiController@translations');
Route::get('/currencies', 'Api\UtilsApiController@currencies');
Route::get('/nodes', 'Api\UtilsApiController@nodes');
Route::get('/map-metrics', 'Api\UtilsApiController@mapMetrics');
Route::get('/package-units', 'Api\UtilsApiController@packageUnits');

Route::group(['prefix' => '/economy'], function() {
    Route::get('/transactions', 'Api\UtilsApiController@transactions');
});

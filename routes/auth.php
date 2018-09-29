<?php

// Auth
Route::get('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::post('/authenticate', 'AuthController@authenticate');

// Password Reset
Route::group(['prefix' => '/password'], function () {
    Route::get('/reset', 'ResetPasswordController@initForm');
    Route::post('/email', 'ResetPasswordController@sendLink');
    Route::get('/reset/{token}', 'ResetPasswordController@resetForm');
    Route::post('/reset', 'ResetPasswordController@reset');
});

// Admin
Route::group(['prefix' => '/admin'], function () {
    // Auth
    Route::get('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout');
    Route::post('/authenticate', 'AuthController@authenticate');

    // Password Reset
    Route::group(['prefix' => '/password'], function () {
        Route::get('/reset', 'ResetPasswordController@initForm');
        Route::post('/email', 'ResetPasswordController@sendLink');
        Route::get('/reset/{token}', 'ResetPasswordController@resetForm');
        Route::post('/reset', 'ResetPasswordController@reset');
    });
});

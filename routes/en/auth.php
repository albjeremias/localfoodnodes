<?php

// Auth
Route::get('/login', 'AuthController@login')->name('en_login');
Route::get('/logout', 'AuthController@logout')->name('en_logout');
Route::post('/authenticate', 'AuthController@authenticate')->name('en_authenticate');

// Password Reset
Route::group(['prefix' => '/password', 'as' => 'password'], function() {
    Route::get('/reset', 'ResetPasswordController@initForm')->name('en_password_reset');
    Route::post('/reset/email', 'ResetPasswordController@sendLink')->name('en_password_reset_send_link');
    Route::get('/reset/{token}', 'ResetPasswordController@resetForm')->name('en_password_reset_token');
    Route::post('/reset', 'ResetPasswordController@reset')->name('en_password_reset_change');
});

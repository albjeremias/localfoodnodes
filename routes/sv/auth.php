<?php

// Route::view('/search', 'new.public.search');
// Route::view('/login', 'new.public.login');
// Route::view('/register', 'new.public.register');
// Route::view('/account/nodes', 'new.account.user.nodes');

// Auth
Route::get('/logga-in', 'AuthController@login')->name('sv_login');
Route::get('/logga-ut', 'AuthController@logout')->name('sv_logout');
Route::post('/autentisera', 'AuthController@authenticate')->name('sv_authenticate');

// Password Reset
Route::group(['prefix' => '/password', 'as' => 'losenord'], function() {
    Route::get('/aterstall', 'ResetPasswordController@initForm')->name('sv_password_reset');
    Route::post('/aterstall/email', 'ResetPasswordController@sendLink')->name('sv_password_reset_send_link');
    Route::get('/aterstall/{token}', 'ResetPasswordController@resetForm')->name('sv_password_reset_token');
    Route::post('/aterstall', 'ResetPasswordController@reset')->name('sv_password_reset_change');
});

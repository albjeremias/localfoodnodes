<?php

Route::get('/', 'Admin\AdminController@index');
Route::get('/users', 'Admin\AdminController@users');
Route::get('/users/{userId}/activate', 'Admin\AdminController@activateUser');
Route::get('/economy/transactions', 'Admin\AdminController@transactions');
Route::post('/economy/transactions', 'Admin\AdminController@uploadTransactionsFile');
Route::put('/economy/transactions', 'Admin\AdminController@updateTransaction');
// Route::get('/transactions/categories', 'Admin\AdminController@transactionCategories');

// Email
Route::group(['prefix' => '/email'], function() {
    Route::get('/', 'Admin\EmailController@index');
    Route::get('/user/activation', 'Admin\EmailController@userActivation');
    Route::get('/user/reset-password', 'Admin\EmailController@resetPassword');
    Route::get('/order/producer', 'Admin\EmailController@orderProducer');
    Route::get('/order/customer', 'Admin\EmailController@orderCustomer');
});

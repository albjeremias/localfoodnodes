<?php

// Index
Route::get('/', 'IndexController@index')->name('en_index');

// Account create
Route::get('/register', 'Account\UserController@create')->name('en_register');
Route::post('/account/user/insert', 'Account\UserController@insert')->name('en_account_user_insert');
Route::get('/account/user/activate/token/{token}', 'Account\UserController@activateToken')->name('en_account_user_activate_token'); // Activate account even if user is not logged in
Route::post('/account/user/membership/callback', 'Account\UserController@membershipCallback')->name('en_account_user_membership_callback'); // Need to be public with the new membership donation form

// Cart - needs auth since cart only works for logged in users
Route::group(['prefix' => '/checkout', 'middleware' => 'auth.account'], function () {
    Route::get('/', 'CartController@index');
    Route::post('/item/add', 'CartController@addItem');
    Route::post('/items/add', 'CartController@addItems');
    Route::post('/item/{CartDateItemLinkId}/update', 'CartController@updateItem');
    Route::get('/item/{CartDateItemLinkId}/remove', 'CartController@removeItem');
    Route::get('/order/create', 'OrderController@createOrder');
});

// Static pages
Route::get('/find-out-more', 'PageController@findOutMore')->name('en_find_out_more');
Route::get('/membership', 'PageController@membership')->name('en_membership');
Route::get('/economy', 'PageController@economy')->name('en_economy');
Route::get('/economy/transactions', 'PageController@transactions')->name('en_economy_transaction');
Route::get('/team', 'PageController@team')->name('en_team');
Route::get('/statistics', 'PageController@statistics')->name('en_statistics');
Route::get('/vision', 'PageController@vision')->name('en_vision');
Route::get('/faq', 'PageController@vision')->name('en_faq');
Route::get('/gdpr', 'PageController@gdpr')->name('en_gdpr');
Route::get('/app', 'PageController@app')->name('en_app');

// Page - There routes must be in the bottom of this file because else they'll match every request
Route::get('/{type}/{slug}/{subType?}/{subSlug?}', 'PermalinkController@route');

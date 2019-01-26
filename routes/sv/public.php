<?php

// Index
Route::get('/', 'IndexController@index')->name('sv_index');

// Account create
Route::get('/konto/skapa/{type?}', 'Account\UserController@create')->name('sv_account_user_create');
Route::post('/account/user/insert', 'Account\UserController@insert')->name('sv_account_user_insert');
Route::get('/konto/aktivera/token/{token}', 'Account\UserController@activateToken')->name('sv_account_user_activate_token'); // Activate account even if user is not logged in
Route::post('/account/user/membership/callback', 'Account\UserController@membershipCallback')->name('sv_account_user_membership_callback'); // Need to be public with the new membership donation form

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
Route::get('/las-mer', 'PageController@findOutMore')->name('sv_findOutMore');
Route::get('/medlemskap', 'PageController@membership')->name('sv_membership');
Route::get('/ekonomi', 'PageController@economy')->name('sv_economy');
Route::get('/economy/transactions', 'PageController@transactions');
Route::get('/team', 'PageController@team');
Route::get('/statistics', 'PageController@statistics');
Route::get('/gdpr', 'PageController@gdpr');
Route::get('/app', 'PageController@app');

// Page - There routes must be in the bottom of this file because else they'll match every request
Route::get('/{type}/{slug}/{subType?}/{subSlug?}', 'PermalinkController@route');

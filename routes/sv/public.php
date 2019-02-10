<?php

// Index
Route::get('/', 'IndexController@index')->name('sv_index');

// Account create
Route::get('/registrera', 'Account\UserController@create')->name('sv_register');
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
Route::get('/las-mer', 'PageController@findOutMore')->name('sv_find_out_more');
Route::get('/medlemskap', 'PageController@membership')->name('sv_membership');
Route::get('/ekonomi', 'PageController@economy')->name('sv_economy');
Route::get('/economy/transactions', 'PageController@transactions')->name('sv_economy_transactions');
Route::get('/team', 'PageController@team')->name('sv_team');
Route::get('/statistik', 'PageController@statistics')->name('statistics');
Route::get('/vision', 'PageController@vision')->name('sv_vision');
Route::get('/faq', 'PageController@vision')->name('sv_faq');
Route::get('/gdpr', 'PageController@gdpr')->name('sv_gdpr');
Route::get('/app', 'PageController@app')->name('sv_app');


Route::get('/nod/{slug}', 'IndexController@node')->name('sv_node');
Route::get('/nod/{slug}/producent/{subSlug?}', 'IndexController@nodeProducer')->name('sv_node_producer');
Route::get('/nod/{slug}/produkt/{subSlug?}', 'IndexController@nodeProduct')->name('sv_node_product');

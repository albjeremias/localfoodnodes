<?php

// User
Route::group(['prefix' => '/anvandare'], function() {
    Route::get('/aktivera', 'Account\UserController@activate')->name('sv_account_user_activate');
    Route::get('/aktivera/resend', 'Account\UserController@activateResend')->name('sv_account_user_activate_resend');
    Route::get('/', 'Account\UserController@index')->name('sv_account_user');
    Route::get('/redigera', 'Account\UserController@edit')->name('sv_account_user_edit');
    Route::post('/updatera', 'Account\UserController@update')->name('sv_account_user_update');
    Route::get('/ta-bort', 'Account\UserController@delete')->name('sv_account_user_delete');
    Route::get('/losenord/redigera', 'Account\UserController@editPassword')->name('sv_account_user_password_edit');
    Route::post('/losenord/uppdatera', 'Account\UserController@updatePassword')->name('sv_account_user_password_update');
    Route::get('/noder', 'Account\UserController@pickups')->name('sv_account_user_nodes');
    Route::get('/utlamning', 'Account\UserController@pickups')->name('sv_account_user_pickups');
    Route::get('/bestallning/producent/{producerId}', 'Account\UserController@producerOrders')->name('sv_account_user_orders_producer');
    Route::get('/bestallning/produkt/{productId}', 'Account\UserController@productOrders')->name('sv_account_user_orders_product');

    Route::get('/gdpr/godkann', 'Account\UserController@gdpr')->name('sv_account_user_gdpr_confirm');
    Route::view('/gdpr', 'new.account.user.gdpr')->name('sv_account_user_gdpr');

    Route::get('/bestallning/{orderItemId}', 'Account\UserController@order')->name('sv_account_user_order');
    Route::get('/bestallning/{orderItemId}/ta-bort', 'Account\UserController@deleteOrderItem')->name('sv_account_user_order_delete');
    Route::get('/nod/{nodeId}', 'Account\UserController@toggleNode')->name('sv_account_user_node');
    Route::get('/medlemskap', 'Account\UserController@membership')->name('sv_account_user_membership');
});

// Node
Route::group(['prefix' => '/nod'], function() {
    Route::get('/skapa', 'Account\NodeController@create')->name('sv_account_node_create');
    Route::post('/insert', 'Account\NodeController@insert')->name('sv_account_node_insert');
    Route::get('/{nodeId}/edit/pickup', 'Account\NodeController@editPickupDates')->name('sv_account_node_edit_pickup');
    Route::get('/{nodeId}', 'Account\NodeController@index')->name('sv_account_node');
    Route::get('/{nodeId}/redigera', 'Account\NodeController@edit')->name('sv_account_node_edit');
    Route::post('/{nodeId}/uppdatera', 'Account\NodeController@update')->name('sv_account_node_update');
    Route::get('/{nodeId}/ta-bort', 'Account\NodeController@delete')->name('sv_account_node_delete');
    Route::get('/{nodeId}/ta-bort/godkann', 'Account\NodeController@deleteConfirm')->name('sv_account_node_delete_confirm');
    Route::get('/{nodeId}/lamna', 'Account\NodeController@leave')->name('sv_account_node_leave');
    Route::get('/{nodeId}/anvandare', 'Account\NodeController@users')->name('sv_account_node_users');
    Route::get('/{nodeId}/producenter', 'Account\NodeController@producers')->name('sv_account_node_producers');
    Route::get('/{nodeId}/producenter/{producerId}/svartlista', 'Account\NodeController@blacklistProducer')->name('sv_account_node_producer_blacklist');

    Route::post('/{nodeId}/utlamning/lagg-till', 'Account\NodeController@addDelivery')->name('sv_account_node_delivery_add');
    Route::get('/{nodeId}/utlamning/{date}/ta-bort', 'Account\NodeController@deleteDelivery')->name('sv_account_node_delivery_delete');

    Route::post('/{nodeId}/inbjudan/skicka', 'Account\NodeController@sendAdminInvite')->name('sv_account_node_invite_send');
    Route::get('/{nodeId}/inbjudan/acceptera', 'Account\NodeController@acceptInvite')->name('sv_account_node_accept');
    Route::get('/{nodeId}/inbjudan/{userId}/avbryt', 'Account\NodeController@cancelInvite')->name('sv_account_node_invite_cancel');
});

// Producer
Route::group(['prefix' => '/producent'], function() {
    Route::get('/skapa', 'Account\ProducerController@create')->name('sv_account_producer_create');
    Route::post('/insert', 'Account\ProducerController@insert')->name('sv_account_producer_insert');
    Route::get('/{producerId}', 'Account\ProducerController@index')->name('sv_account_producer');
    Route::get('/{producerId}/redigera', 'Account\ProducerController@edit')->name('sv_account_producer_edit');
    Route::post('/{producerId}/uppdatera', 'Account\ProducerController@update')->name('sv_account_producer_update');
    Route::get('/{producerId}/ta-bort', 'Account\ProducerController@delete')->name('sv_account_producer_delete');
    Route::get('/{producerId}/ta-bort/godkann', 'Account\ProducerController@deleteConfirm')->name('sv_account_producer_delete_confirm');
    Route::get('/{producerId}/lamna', 'Account\ProducerController@leave')->name('sv_account_producer_lesve');
    Route::get('/{producerId}/produkter', 'Account\ProducerController@products')->name('sv_account_producer_products');

    Route::get('/{producerId}/kanaler', 'Account\ProducerController@channels')->name('sv_account_producer_channels');
    Route::post('/{producerId}/channels', 'Account\ProducerController@saveChannels')->name('sv_account_producer_channels_save');
	Route::get('/{producerId}/slutfor', 'Account\ProducerController@finish')->name('sv_account_producer_finish');

	Route::get('/{producerId}/utlamning', 'Account\ProducerController@deliveries')->name('sv_account_producer_deliveries');
    Route::get('/{producerId}/utlamning/{orderDateId}/picklist', 'Account\ProducerController@picklist')->name('sv_account_producer_delivery_picklist');
    Route::get('/{producerId}/bestallning/anvandare/{userId}', 'Account\OrderController@userOrders')->name('sv_account_producer_orders_user');
    Route::get('/{producerId}/bestallning/produkt/{productId}', 'Account\OrderController@productOrders')->name('sv_account_producer_orders_product');
    Route::get('/{producerId}/bestallning/{orderId}', 'Account\OrderController@order')->name('sv_account_producer_order');
    Route::post('/{producerId}/inbjudan/skicka', 'Account\ProducerController@sendAdminInvite')->name('sv_account_producer_invite_send');
    Route::get('/{producerId}/inbjudan/acceptera', 'Account\ProducerController@acceptInvite')->name('sv_account_producer_invite_accept');
    Route::get('/{producerId}/inbjudan/{userId}/avbryt', 'Account\ProducerController@cancelInvite')->name('sv_account_producer_invite_cancel');

    // Producer order
    Route::get('/{producerId}/bestallning/{orderItemId}/status/{status}', 'Account\OrderController@changeOrderStatus')->name('sv_account_producer_order_status');
});

// Product
Route::group(['prefix' => '/producent/{producerId}/produkt'], function() {
    Route::get('/skapa', 'Account\ProductController@create')->name('sv_account_product_create');
    Route::post('/insert', 'Account\ProductController@insert')->name('sv_account_product_insert');
    Route::get('/{productId}/redigera', 'Account\ProductController@edit')->name('sv_account_product_edit');
    Route::post('/{productId}/uppdatera', 'Account\ProductController@update')->name('sv_account_product_update');
    Route::get('/{productId}/ta-bort', 'Account\ProductController@delete')->name('sv_account_product_delete');
    Route::get('/{productId}/ta-bort/godkann', 'Account\ProductController@deleteConfirm')->name('sv_account_product_delete_confirm');
    Route::post('/{productId}/valj-forpackningsenhet', 'Account\ProductController@setPackageUnit')->name('sv_account_product_set_package_unit');

    // Overview
    Route::get('/{productId}', 'Account\ProductController@index')->name('sv_account_product');

    // Stock and variants
    Route::get('/{productId}/saldo-och-varianter', 'Account\ProductVariantController@index')->name('sv_account_product_stock_and_variants');
    Route::post('/{productId}/varianter', 'Account\ProductVariantController@updateVariants')->name('sv_account_product_variants_update');
    Route::post('/{productId}/saldo', 'Account\ProductVariantController@updateStock')->name('sv_account_product_stock_update');

    // Deliveries
    Route::get('/{productId}/utlamningar', 'Account\ProductController@editDeliveries')->name('sv_account_product_deliveries');
    Route::post('/{productId}/utlamningar/uppdatera', 'Account\ProductController@updateDeliveries')->name('sv_account_product_deliveries_update');
});

// Image
Route::group(['prefix' => '/image'], function() {
    Route::post('/upload', 'Account\ImageController@upload')->name('sv_account_image_upload');
    Route::get('/{imageId}/delete', 'Account\ImageController@delete')->name('sv_account_image_delete');
});

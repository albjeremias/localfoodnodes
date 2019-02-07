<?php

// User
Route::group(['prefix' => '/user'], function () {
    Route::get('/activate', 'Account\UserController@activate')->name('en_account_user_activate');
    Route::get('/activate/resend', 'Account\UserController@activateResend')->name('en_account_user_activate_resend');
    Route::get('/', 'Account\UserController@index')->name('en_account_user');
    Route::get('/edit', 'Account\UserController@edit')->name('en_account_user_edit');
    Route::post('/update', 'Account\UserController@update')->name('en_account_user_update');
    Route::get('/delete', 'Account\UserController@delete')->name('en_account_user_delete');
    Route::get('/delete/confirm', 'Account\UserController@deleteConfirm')->name('en_account_user_delete_confirm');
    Route::get('/password/edit', 'Account\UserController@editPassword')->name('en_account_user_password_edit');
    Route::post('/password/update', 'Account\UserController@updatePassword')->name('en_account_user_password_update');
    Route::get('/pickups', 'Account\UserController@pickups')->name('en_account_user_pickups');
    Route::get('/orders/producer/{producerId}', 'Account\UserController@producerOrders')->name('en_account_user_orders_producer');
    Route::get('/orders/product/{productId}', 'Account\UserController@productOrders')->name('en_account_user_orders_product');
    // What?
    Route::get('/gdpr/delete/confirm', 'Account\UserController@gdprDeleteConfirm')->name('en_account_user_gdpr_delete_confirm');
    Route::get('/gdpr', 'Account\UserController@gdpr')->name('en_account_user_gdpr');

    Route::get('/order/{orderItemId}', 'Account\UserController@order')->name('en_account_user_order');
    Route::get('/order/{orderItemId}/delete', 'Account\UserController@deleteOrderItem')->name('en_account_user_order_delete');
    Route::get('/node/{nodeId}', 'Account\UserController@toggleNode')->name('en_account_user_node');
    Route::get('/membership', 'Account\UserController@membership')->name('en_account_user_membership');
});

// Node
Route::group(['prefix' => '/node'], function () {
    Route::get('/create', 'Account\NodeController@create')->name('en_account_node_create');
    Route::post('/insert', 'Account\NodeController@insert')->name('en_account_node_insert');
    Route::get('/{nodeId}', 'Account\NodeController@index')->name('en_account_node');
    Route::get('/{nodeId}/edit', 'Account\NodeController@edit')->name('en_account_node_edit');
    Route::post('/{nodeId}/update', 'Account\NodeController@update')->name('en_account_node_update');
    Route::get('/{nodeId}/delete', 'Account\NodeController@delete')->name('en_account_node_delete');
    Route::get('/{nodeId}/delete/confirm', 'Account\NodeController@deleteConfirm')->name('en_account_node_delete_confirm');
    Route::get('/{nodeId}/leave', 'Account\NodeController@leave')->name('en_account_node_leave');
    Route::get('/{nodeId}/users', 'Account\NodeController@users')->name('en_account_node_users');
    Route::get('/{nodeId}/producers', 'Account\NodeController@producers')->name('en_account_node_producers');
    Route::get('/{nodeId}/producer/{producerId}/blacklist', 'Account\NodeController@blacklistProducer')->name('en_account_node_producer_blacklist');

    Route::post('/{nodeId}/delivery/add', 'Account\NodeController@addDelivery')->name('en_account_node_delivery_add');
    Route::get('/{nodeId}/delivery/{date}/delete', 'Account\NodeController@deleteDelivery')->name('en_account_node_delivery_delete');

    Route::post('/{nodeId}/invite/send', 'Account\NodeController@sendAdminInvite')->name('en_account_node_invite_send');
    Route::get('/{nodeId}/invite/accept', 'Account\NodeController@acceptInvite')->name('en_account_node_accept');
    Route::get('/{nodeId}/invite/{userId}/cancel', 'Account\NodeController@cancelInvite')->name('en_account_node_invite_cancel');
});

// Producer
Route::group(['prefix' => '/producer'], function () {
    Route::get('/create', 'Account\ProducerController@create')->name('en_account_producer_create');
    Route::post('/insert', 'Account\ProducerController@insert')->name('en_account_producer_insert');
    Route::get('/{producerId}', 'Account\ProducerController@index')->name('en_account_producer');
    Route::get('/{producerId}/edit', 'Account\ProducerController@edit')->name('en_account_producer_edit');
    Route::post('/{producerId}/update', 'Account\ProducerController@update')->name('en_account_producer_update');
    Route::get('/{producerId}/delete', 'Account\ProducerController@delete')->name('en_account_producer_delete');
    Route::get('/{producerId}/delete/confirm', 'Account\ProducerController@deleteConfirm')->name('en_account_producer_delete_confirm');
    Route::get('/{producerId}/leave', 'Account\ProducerController@leave')->name('en_account_producer_lesve');
    Route::get('/{producerId}/products', 'Account\ProducerController@products')->name('en_account_producer_products');

	Route::get('/{producerId}/channels', 'Account\ProducerController@channels')->name('en_account_producer_channels');
	Route::get('/{producerId}/finish', 'Account\ProducerController@finish')->name('en_account_producer_finish');

    Route::get('/{producerId}/deliveries', 'Account\ProducerController@deliveries')->name('en_account_producer_deliveries');
    Route::get('/{producerId}/delivery/{orderDateId}/picklist', 'Account\ProducerController@picklist')->name('en_account_producer_delivery_picklist');
    Route::get('/{producerId}/orders/user/{userId}', 'Account\OrderController@userOrders')->name('en_account_producer_orders_user');
    Route::get('/{producerId}/orders/product/{productId}', 'Account\OrderController@productOrders')->name('en_account_producer_orders_product');
    Route::get('/{producerId}/order/{orderId}', 'Account\OrderController@order')->name('en_account_producer_order');
    Route::post('/{producerId}/invite/send', 'Account\ProducerController@sendAdminInvite')->name('en_account_producer_invite_send');
    Route::get('/{producerId}/invite/accept', 'Account\ProducerController@acceptInvite')->name('en_account_producer_invite_accept');
    Route::get('/{producerId}/invite/{userId}/cancel', 'Account\ProducerController@cancelInvite')->name('en_account_producer_invite_cancel');

    // Producer node map
    Route::get('/{producerId}/map/nodes', 'Account\ProducerController@mapGetNodes')->name('en_account_producer_map_nodes');
    Route::post('/{producerId}/map/node/add', 'Account\ProducerController@mapAddNode')->name('en_account_producer_map_nodes_add');
    Route::post('/{producerId}/map/node/remove', 'Account\ProducerController@mapRemoveNode')->name('en_account_producer_map_node_remove');

    // Producer order
    Route::get('/{producerId}/order/{orderItemId}/status/{status}', 'Account\OrderController@changeOrderStatus')->name('en_account_producer_order_status');
});

// Product
Route::group(['prefix' => '/producer/{producerId}/product'], function () {
    Route::get('/create', 'Account\ProductController@create')->name('en_account_product_create');
    Route::post('/insert', 'Account\ProductController@insert')->name('en_account_product_insert');
    Route::get('/{productId}/edit', 'Account\ProductController@edit')->name('en_account_product_edit');
    Route::post('/{productId}/update', 'Account\ProductController@update')->name('en_account_product_update');
    Route::get('/{productId}/delete', 'Account\ProductController@delete')->name('en_account_product_delete');
    Route::get('/{productId}/delete/confirm', 'Account\ProductController@deleteConfirm')->name('en_account_product_delete_confirm');
    Route::post('/{productId}/set-package-unit', 'Account\ProductController@setPackageUnit')->name('en_account_product_set_package_unit');

    // Variants
    Route::get('/{productId}/variants', 'Account\ProductVariantController@index')->name('en_account_product_variants');
    Route::post('/{productId}/variants', 'Account\ProductVariantController@createAndUpdate')->name('en_account_product_variants_create_and_update');

    // Production
    Route::get('/{productId}/production', 'Account\ProductProductionController@index')->name('en_account_product_production');
    Route::get('/{productId}/production/{productionId}/delete', 'Account\ProductProductionController@deleteProduction')->name('en_account_product_production_delete');
    Route::post('/{productId}/production/update', 'Account\ProductProductionController@update')->name('en_account_product_production_update');

    // Deliveries
    Route::get('/{productId}/deliveries', 'Account\ProductController@editDeliveries')->name('en_account_product_deliveries');
    Route::post('/{productId}/deliveries/update', 'Account\ProductController@updateDeliveries')->name('en_account_product_deliveries_update');

    // Overview
	Route::get('/{productId}', 'Account\ProductProductionController@index')->name('en_account_product');

});

// Image
Route::group(['prefix' => '/image'], function () {
    Route::post('/upload', 'Account\ImageController@upload')->name('en_account_image_upload');
    Route::get('/{imageId}/delete', 'Account\ImageController@delete')->name('en_account_image_delete');
});

<?php

// Settings
Route::get('/locale/{locale}', 'System\SystemController@changeLocale');

Route::get('/info', 'System\SystemController@info');

Route::get('/cron/notifications', 'System\CronController@notifications');
Route::get('/cron/currency', 'System\CronController@currency');
Route::get('/cron/statistics', 'System\CronController@statistics');
Route::get('/cron/nodes', 'System\CronController@nodes');
Route::get('/cron/node-dates', 'System\CronController@nodeDates');

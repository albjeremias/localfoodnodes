<?php

Route::get('/info', 'System\SystemController@info');

Route::get('/cron/notifications', 'System\CronController@notifications');
Route::get('/cron/currency', 'System\CronController@currency');
Route::get('/cron/statistics', 'System\CronController@statistics');

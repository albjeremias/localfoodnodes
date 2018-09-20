<?php

Route::get('/cron/notifications', 'System\CronController@notifications');
Route::get('/cron/currency', 'System\CronController@currency');
Route::get('/cron/statistics', 'System\CronController@statistics');

// Temp route
Route::get('/script', 'System\CronController@script');
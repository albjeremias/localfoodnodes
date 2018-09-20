<?php

Route::get('/cron/notification', 'System\CronController@notifications');
Route::get('/cron/currency', 'System\CronController@currency');
<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\System\NotificationGenerator;
use App\System\CurrencyRateImporter;

class CronController extends BaseController
{
    public function currency(Request $request)
    {
        $currencyRateImporter = new CurrencyRateImporter();
        $currencyRateImporter->import();
    }

    public function notifications(Request $request)
    {
        $notificationGenerator = new NotificationGenerator();
        $notificationGenerator->generateNextPickupDate();
        $notificationGenerator->generatePickupReminderDay();
        // $notificationGenerator->generatePickupReminderHour();

        $notificationGenerator->sendUserNotifications();
    }
}

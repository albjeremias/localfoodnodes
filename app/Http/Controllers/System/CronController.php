<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\System\Importers\CurrencyRateImporter;
use App\System\NotificationGenerator\NotificationGenerator;
use App\System\StatisticsGenerator\StatisticsGenerator;

use App\Order\OrderDateItemLink;

class CronController extends BaseController
{
    /**
     * Currency cron jobs
     *
     * @param Request $request
     */
    public function currency(Request $request, CurrencyRateImporter $currencyRateImporter)
    {
        $currencyRateImporter->import();
    }

    /**
     * Statistic cron jobs
     *
     * @param Request $request
     */
    public function statistics(Request $request, StatisticsGenerator $statisticsGenerator)
    {
        $statisticsGenerator->generate();
    }

    /**
     * Notification cron jobs
     *
     * @param Request $request
     */
    public function notifications(Request $request, NotificationGenerator $notificationGenerator)
    {
        $notificationGenerator->generateNextPickupDate();
        $notificationGenerator->generatePickupReminderDay();
        // $notificationGenerator->generatePickupReminderHour();

        $notificationGenerator->sendUserNotifications();
    }
}

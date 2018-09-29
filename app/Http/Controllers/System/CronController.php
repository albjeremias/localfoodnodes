<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\System\Importers\CurrencyRateImporter;
use App\System\Generators\NotificationGenerator;
use App\System\Generators\StatisticsGenerator;

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
     * Generate statistics for
     * - Number of orders
     * - Order amount (in EUR)
     *
     * @param Request $request
     */
    public function statistics(Request $request, StatisticsGenerator $statisticsGenerator)
    {
        // Order
        $statisticsGenerator->ordersCountAndAmount();
        $statisticsGenerator->ordersPerNodesAndTags();
        $statisticsGenerator->ordersCountAndAmountPerNodeAndDate();

        // User
        $statisticsGenerator->userCount();

        // Producer
        $statisticsGenerator->producerCount();

        // Node
        $statisticsGenerator->nodeCount();
        $statisticsGenerator->nodesMembersByNode();
        $statisticsGenerator->nodesCustomersPerNode();
        $statisticsGenerator->nodesCustomersPerNodeAndDate();
        $statisticsGenerator->nodesProducersPerNodeAndDate();
        $statisticsGenerator->nodesProductsPerNodeAndDate();
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

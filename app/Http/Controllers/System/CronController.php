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
        $statisticsGenerator->ordersCountAndAmount();
        $statisticsGenerator->userCount();
        $statisticsGenerator->producerCount();
        $statisticsGenerator->nodeCount();
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

    public function script()
    {
        $orderDateItemLinks = OrderDateItemLink::all();
        $orderDateItemLinks->map(function($orderDateItemLink) {
            $orderItem = $orderDateItemLink->getItem();
            if (!$orderItem) {
                $orderDateItemLink->amount = 0;
                $orderDateItemLink->save();
            } else {
                $amount = $orderDateItemLink->quantity * $orderItem->getProduct()->price;
                if ($orderItem->getVariant()) {
                    $amount = $orderDateItemLink->quantity * $orderItem->getVariant()->price;
                }

                $orderDateItemLink->amount = $amount;
                $orderDateItemLink->currency = $orderItem->getProducer()->currency;
                $orderDateItemLink->save();
            }
        });
    }
}

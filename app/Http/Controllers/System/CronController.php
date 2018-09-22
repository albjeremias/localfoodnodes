<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\System\NotificationGenerator;
use App\System\CurrencyRateImporter;
use App\System\StatisticsGenerator;

use App\Order\OrderDateItemLink;

class CronController extends BaseController
{
    /**
     * Currency cron jobs
     *
     * @param Request $request
     */
    public function currency(Request $request)
    {
        $currencyRateImporter = new CurrencyRateImporter();
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
    public function statistics(Request $request)
    {
        $statisticsGenerator = new StatisticsGenerator();
        $statisticsGenerator->totalOrderAmount();
        $statisticsGenerator->userCount();
        $statisticsGenerator->producerCount();
        $statisticsGenerator->nodeCount();
    }

    /**
     * Notification cron jobs
     *
     * @param Request $request
     */
    public function notifications(Request $request)
    {
        $notificationGenerator = new NotificationGenerator();
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

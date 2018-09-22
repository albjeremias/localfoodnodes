<?php

namespace App\System;

use Illuminate\Support\Facades\DB;

use App\Helpers\CurrencyHelper;
use App\Order\OrderDateItemLink;
use App\Order\OrderDate;
use App\User\User;
use App\Producer\Producer;
use App\Node\Node;

class StatisticsGenerator
{
    private $currencyHelper;

    public function __construct()
    {
        $this->currencyHelper = new CurrencyHelper();
    }

    public function totalOrderAmount()
    {
        $oldest = OrderDate::orderBy('date', 'asc')->first()->date;
        $latest = OrderDate::orderBy('date', 'desc')->first()->date;

        $dateInterval = new \DateInterval('P1D');
        $datePeriod = new \DatePeriod($oldest, $dateInterval, $latest);

        $orderDateItemLinks = OrderDateItemLink::all();

        $ordersPerDate = [];
        $orderAmountPerDate = [];
        foreach ($datePeriod as $date) {
            $ordersPerDate[$date->format('Y-m-d')] = 0;
            $orderAmountPerDate[$date->format('Y-m-d')] = 0;
        }

        $totalOrderAmount = 0;
        foreach ($orderDateItemLinks as $orderDateItemLink) {
            $amount = $this->currencyHelper->convert($orderDateItemLink->amount, $orderDateItemLink->currency, 'USD');
            $totalOrderAmount += $amount;

            $orderDate = $orderDateItemLink->getDate();
            if ($orderDate) {
                $ordersPerDate[$orderDate->date('Y-m-d')] += 1;
                $orderAmountPerDate[$orderDate->date('Y-m-d')] += $amount;
            }
        }

        $this->insertOrUpdate(['key' => 'order_amount_total', 'value' => $totalOrderAmount]);
        $this->insertOrUpdate(['key' => 'order_amount_per_date', 'value' => serialize($orderAmountPerDate)]);
        $this->insertOrUpdate(['key' => 'orders_per_date', 'value' => serialize($ordersPerDate)]);
    }

    public function userCount()
    {
        $total = User::count();
        $query = ['key' => 'users', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    public function producerCount()
    {
        $total = Producer::count();
        $query = ['key' => 'producers', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    public function nodeCount()
    {
        $total = Node::count();
        $query = ['key' => 'nodes', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    private function insertOrUpdate($query)
    {
        try {
            DB::table('statistics')->insert($query);
        } catch (\Exception $e) {
            DB::table('statistics')->where('key', $query['key'])->update(['value' => $query['value']]);
        }
    }
}
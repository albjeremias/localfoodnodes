<?php

namespace App\System\Generators;

use Illuminate\Support\Facades\DB;

use App\System\Utils\CurrencyConverter;
use App\Order\OrderDateItemLink;
use App\Order\OrderDate;
use App\User\User;
use App\Producer\Producer;
use App\Node\Node;

class StatisticsGenerator
{
    private $currencyConverter;

    /**
     * Constructor.
     *
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Generate total order count and amount.
     *
     * @return void
     */
    public function ordersCountAndAmount()
    {
        $oldest = OrderDate::orderBy('date', 'asc')->first()->date;
        $latest = OrderDate::orderBy('date', 'desc')->first()->date;
        $latest->modify('+1 day');

        $dateInterval = new \DateInterval('P1D');
        $datePeriod = new \DatePeriod($oldest, $dateInterval, $latest);

        $ordersPerDate = [];
        $orderAmountPerDate = [];
        foreach ($datePeriod as $date) {
            $ordersPerDate[$date->format('Y-m-d')] = 0;
            $orderAmountPerDate[$date->format('Y-m-d')] = 0;
        }

        $rows = DB::table('order_date_item_links')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->select('amount', 'currency', 'date')
        ->get();

        $totalOrderAmount = 0;
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');
            $totalOrderAmount += $amount;

            $ordersPerDate[$row->date] += 1;
            $orderAmountPerDate[$row->date] += $amount;
        }

        $this->insertOrUpdate(['key' => 'orders_amount_total', 'data' => $totalOrderAmount]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_date', 'data' => json_encode($orderAmountPerDate)]);
        $this->insertOrUpdate(['key' => 'orders_count_total', 'data' => count($rows)]);
        $this->insertOrUpdate(['key' => 'orders_count_per_date', 'data' => json_encode($ordersPerDate)]);
    }

    /**
     * Generate user count.
     *
     * @return void
     */
    public function userCount()
    {
        $total = User::count();
        $query = ['key' => 'users_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate producer count.
     *
     * @return void
     */
    public function producerCount()
    {
        $total = Producer::count();
        $query = ['key' => 'producers_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate node count.
     *
     * @return void
     */
    public function nodeCount()
    {
        $total = Node::count();
        $query = ['key' => 'nodes_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }

    /**
     * Helper function that does inserts or updates to database.
     *
     * @param array $query
     * @return void
     */
    private function insertOrUpdate($query)
    {
        try {
            DB::table('statistics')->insert($query);
        } catch (\Exception $e) {
            DB::table('statistics')->where('key', $query['key'])->update(['data' => $query['data']]);
        }
    }
}
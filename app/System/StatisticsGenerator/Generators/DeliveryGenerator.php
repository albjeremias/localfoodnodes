<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\System\Utils\CurrencyConverter;
use App\Order\OrderDate;

class DeliveryGenerator extends BaseGenerator
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
     * Run scripts.
     *
     * @return void
     */
    public function generate()
    {
        $this->countAndAmount();
        $this->customers();
        $this->producers();
        $this->products();
    }

    /**
     * Generate order count and amount per delivery (node and date)
     *
     * Settings:
     * delivery_order_count
     * delivery_order_amount
     *
     * @return void
     */
    private function countAndAmount()
    {
        $oldest = OrderDate::orderBy('date', 'asc')->first()->date;
        $latest = OrderDate::orderBy('date', 'desc')->first()->date;
        $latest->modify('+1 day');

        $dateInterval = new \DateInterval('P1D');
        $datePeriod = new \DatePeriod($oldest, $dateInterval, $latest);

        $rows = DB::table('order_date_item_links')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->select('amount', 'currency', 'date', 'node_id', 'quantity')
        ->whereNotNull('currency')
        ->get();

        $ordersCountPerNodeAndDate = [];
        $ordersAmountPerNodeAndDate = [];

        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency);

            // Count
            if (!isset($ordersCountPerNodeAndDate[$row->node_id])) {
                $ordersCountPerNodeAndDate[$row->node_id] = [];
            }

            if (!isset($ordersCountPerNodeAndDate[$row->node_id][$row->date])) {
                $ordersCountPerNodeAndDate[$row->node_id][$row->date] = 0;
            }

            $ordersCountPerNodeAndDate[$row->node_id][$row->date] += (int) $row->quantity;

            // Amount
            if (!isset($ordersAmountPerNodeAndDate[$row->node_id])) {
                $ordersAmountPerNodeAndDate[$row->node_id] = [];
            }

            if (!isset($ordersAmountPerNodeAndDate[$row->node_id][$row->date])) {
                $ordersAmountPerNodeAndDate[$row->node_id][$row->date] = 0;
            }

            $ordersAmountPerNodeAndDate[$row->node_id][$row->date] += $amount;
        }

        $this->insertOrUpdate(['key' => 'delivery_order_count', 'data' => json_encode($ordersCountPerNodeAndDate)]);
        $this->insertOrUpdate(['key' => 'delivery_order_amount', 'data' => json_encode($ordersAmountPerNodeAndDate)]);
    }

    /**
     * Generate number of unique customers per delivery (node and date).
     *
     * @return void
     */
    private function customers()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->select(DB::raw('order_items.node_id, order_dates.date, count(distinct order_items.user_id) AS count'))
        ->groupBy('node_id', 'date')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = [];
            }

            if (!isset($data[$row->node_id][$row->date])) {
                $data[$row->node_id][$row->date] = $row->count;
            }
        }

        $query = ['key' => 'delivery_customers', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate number of producers per delivery (node and date).
     *
     * @return void
     */
    private function producers()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->select(DB::raw('order_items.node_id, order_dates.date, count(distinct order_items.producer_id) AS count'))
        ->groupBy('node_id', 'date')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = [];
            }

            if (!isset($data[$row->node_id][$row->date])) {
                $data[$row->node_id][$row->date] = $row->count;
            }
        }

        $query = ['key' => 'delivery_producers', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate number of products per delivery (node and date).
     *
     * @return void
     */
    private function products()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->select(DB::raw('order_items.node_id, order_dates.date, count(distinct order_items.product_id) AS count'))
        ->groupBy('node_id', 'date')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = [];
            }

            if (!isset($data[$row->node_id][$row->date])) {
                $data[$row->node_id][$row->date] = $row->count;
            }
        }

        $query = ['key' => 'delivery_products', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }
}
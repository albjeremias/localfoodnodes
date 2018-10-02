<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\System\Utils\CurrencyConverter;
use App\Order\OrderDate;

class OrderGenerator extends BaseGenerator
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
        $this->ordersPerNode();
        $this->ordersPerNodeAndTag();
    }

    /**
     * Generate total order count and amount.
     *
     * Statistics generated:
     * orders_amount
     * orders_amount_per_date
     * orders_product_count
     * orders_product_count_per_date
     * orders_count
     * orders_count_per_date
     *
     * @return void
     */
    public function countAndAmount()
    {
        $oldest = OrderDate::orderBy('date', 'asc')->first()->date;
        $latest = OrderDate::orderBy('date', 'desc')->first()->date;
        $latest->modify('+1 day');

        $dateInterval = new \DateInterval('P1D');
        $datePeriod = new \DatePeriod($oldest, $dateInterval, $latest);

        $ordersCountPerDate = [];
        $ordersItemsCountPerDate = [];
        $orderAmountPerDate = [];
        foreach ($datePeriod as $date) {
            $ordersCountPerDate[$date->format('Y-m-d')] = 0;
            $ordersItemsCountPerDate[$date->format('Y-m-d')] = 0;
            $orderAmountPerDate[$date->format('Y-m-d')] = 0;
        }

        $rows = DB::table('order_date_item_links')
        ->join('order_dates', 'order_dates.id', '=', 'order_date_item_links.order_date_id')
        ->select('amount', 'currency', 'date', 'quantity')
        ->whereNotNull('currency')
        ->get();

        $ordersCount = 0;
        $ordersItemsCount = 0;
        $ordersAmount = 0;
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR'); // Convert to default currency

            // Total count
            $ordersCount += 1;
            $ordersItemsCount += (int) $row->quantity;
            $ordersAmount += $amount;

            // Per date
            $ordersCountPerDate[$row->date] += 1;
            $ordersItemsCountPerDate[$row->date] += (int) $row->quantity;
            $orderAmountPerDate[$row->date] += $amount;
        }

        $this->insertOrUpdate(['key' => 'order_count', 'data' => $ordersCount]);
        $this->insertOrUpdate(['key' => 'order_count_per_date', 'data' => json_encode($ordersCountPerDate)]);
        $this->insertOrUpdate(['key' => 'order_items_count', 'data' => $ordersItemsCount]);
        $this->insertOrUpdate(['key' => 'order_items_count_per_date', 'data' => json_encode($ordersItemsCountPerDate)]);
        $this->insertOrUpdate(['key' => 'order_amount', 'data' => $ordersAmount]);
        $this->insertOrUpdate(['key' => 'order_amount_per_date', 'data' => json_encode($orderAmountPerDate)]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ordersPerNode()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->select('amount', 'currency', 'node_id', 'product_id')
        ->whereNotNull('currency')
        ->get();

        $ordersCountPerNode = [];
        $ordersAmountPerNode = [];
        $ordersUniqueItemsCount = [];
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');

            // Group by nodes
            if (!isset($ordersAmountPerNode[$row->node_id])) {
                $ordersCountPerNode[$row->node_id] = 0;
                $ordersAmountPerNode[$row->node_id] = [
                    'count' => 0,
                    'amount' => 0,
                ];
            }

            $ordersUniqueItemsCount[$row->product_id] = null; // Count keys
            $ordersCountPerNode[$row->node_id] += 1;
            $ordersAmountPerNode[$row->node_id]['count'] += 1;
            $ordersAmountPerNode[$row->node_id]['amount'] += $amount;
        }

        $this->insertOrUpdate(['key' => 'order_unique_items_count', 'data' => count($ordersUniqueItemsCount)]);
        $this->insertOrUpdate(['key' => 'order_count_per_node', 'data' => json_encode($ordersCountPerNode)]);
        $this->insertOrUpdate(['key' => 'order_amount_per_node', 'data' => json_encode($ordersAmountPerNode)]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ordersPerNodeAndTag()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->leftJoin('product_tags', 'order_items.product_id', '=', 'product_tags.product_id')
        ->select('amount', 'currency', 'node_id', 'tag')
        ->whereNotNull('currency')
        ->get();

        $ordersAmountPerTag = [];
        $ordersAmountPerNodeAndTag = [];
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');

            // Grouped by tags
            $tag = $row->tag ?: 'untagged';

            if (!isset($ordersAmountPerTag[$tag])) {
                $ordersAmountPerTag[$tag] = [
                    'amount' => 0,
                    'count' => 0,
                ];
            }

            $ordersAmountPerTag[$tag]['count'] += 1;
            $ordersAmountPerTag[$tag]['amount'] += $amount;

            // Group by nodes and tags
            if (!isset($ordersAmountPerNodeAndTag[$row->node_id])) {
                $ordersAmountPerNodeAndTag[$row->node_id] = [
                    'tags' => [],
                ];
            }

            if (!isset($ordersAmountPerNodeAndTag[$row->node_id]['tags'][$tag])) {
                $ordersAmountPerNodeAndTag[$row->node_id]['tags'][$tag] = [
                    'count' => 0,
                    'amount' => 0
                ];
            }

            $ordersAmountPerNodeAndTag[$row->node_id]['tags'][$tag]['count'] += 1;
            $ordersAmountPerNodeAndTag[$row->node_id]['tags'][$tag]['amount'] += $amount;
        }

        $this->insertOrUpdate(['key' => 'order_amount_per_tag', 'data' => json_encode($ordersAmountPerTag)]);
        $this->insertOrUpdate(['key' => 'order_amount_per_node_and_tag', 'data' => json_encode($ordersAmountPerNodeAndTag)]);
    }
}
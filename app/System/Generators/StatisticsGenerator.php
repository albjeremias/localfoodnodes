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
     * Settings:
     *   orders_amount
     *   orders_amount_per_date
     *   orders_count
     *   orders_count_per_date
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
        ->select('amount', 'currency', 'date', 'quantity')
        ->whereNotNull('currency')
        ->get();

        $ordersAmount = 0;
        $ordersCount = 0;
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');
            $ordersAmount += $amount;
            $ordersCount += (int) $row->quantity;

            $ordersPerDate[$row->date] += (int) $row->quantity;
            $orderAmountPerDate[$row->date] += $amount;
        }

        $this->insertOrUpdate(['key' => 'orders_count', 'data' => $ordersCount]);
        $this->insertOrUpdate(['key' => 'orders_count_per_date', 'data' => json_encode($ordersPerDate)]);
        $this->insertOrUpdate(['key' => 'orders_amount', 'data' => $ordersAmount]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_date', 'data' => json_encode($orderAmountPerDate)]);
    }

    /**
     * Generate order count and amount per node and date.
     *
     * Settings:
     *   orders_amount_total
     *   orders_amount_per_date
     *   orders_count
     *   orders_count_per_date
     *
     * @return void
     */
    public function ordersCountAndAmountPerNodeAndDate()
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
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');

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

        $this->insertOrUpdate(['key' => 'orders_count_per_node_and_date', 'data' => json_encode($ordersCountPerNodeAndDate)]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_node_and_date', 'data' => json_encode($ordersAmountPerNodeAndDate)]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ordersPerNodesAndTags()
    {
        $rows = DB::table('order_date_item_links')
        ->join('order_items', 'order_items.id', '=', 'order_date_item_links.order_item_id')
        ->leftJoin('product_tags', 'order_items.product_id', '=', 'product_tags.product_id')
        ->select('order_date_item_links.id', 'amount', 'currency', 'node', 'tag')
        ->whereNotNull('currency')
        ->get();

        $ordersCountPerNode = [];
        $ordersAmountPerNode = [];
        $ordersAmountPerTag = [];
        $ordersAmountPerNodeAndTag = [];
        foreach ($rows as $row) {
            $amount = $this->currencyConverter->convert($row->amount, $row->currency, 'EUR');
            $node = json_decode($row->node);

            // Group by nodes
            if (!isset($ordersAmountPerNode[$node->id])) {
                $ordersCountPerNode[$node->id] = 0;
                $ordersAmountPerNode[$node->id] = [
                    'node_name' => $node->name,
                    'count' => 0,
                    'amount' => 0,
                ];
            }

            $ordersCountPerNode[$node->id] += 1;
            $ordersAmountPerNode[$node->id]['count'] += 1;
            $ordersAmountPerNode[$node->id]['amount'] += $amount;

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
            if (!isset($ordersAmountPerNodeAndTag[$node->id])) {
                $ordersAmountPerNodeAndTag[$node->id] = [
                    'node_name' => $node->name,
                    'tags' => [],
                ];
            }

            if (!isset($ordersAmountPerNodeAndTag[$node->id]['tags'][$tag])) {
                $ordersAmountPerNodeAndTag[$node->id]['tags'][$tag] = [
                    'count' => 0,
                    'amount' => 0
                ];
            }

            $ordersAmountPerNodeAndTag[$node->id]['tags'][$tag]['count'] += 1;
            $ordersAmountPerNodeAndTag[$node->id]['tags'][$tag]['amount'] += $amount;
        }

        $this->insertOrUpdate(['key' => 'orders_count_per_node', 'data' => json_encode($ordersCountPerNode)]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_node', 'data' => json_encode($ordersAmountPerNode)]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_tag', 'data' => json_encode($ordersAmountPerTag)]);
        $this->insertOrUpdate(['key' => 'orders_amount_per_node_and_tag', 'data' => json_encode($ordersAmountPerNodeAndTag)]);
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
     * Generate membership count per node.
     *
     * @return void
     */
    public function nodesMembersByNode()
    {
        $rows = DB::table('user_node_links')
        ->select('node_id', 'user_id')
        ->get();

        $nodesMembersPerNode = [];
        foreach ($rows as $row) {
            if (!isset($nodesMembersPerNode[$row->node_id])) {
                $nodesMembersPerNode[$row->node_id] = 0;
            }

            $nodesMembersPerNode[$row->node_id] += 1;
        }

        $query = ['key' => 'nodes_members_per_node', 'data' => json_encode($nodesMembersPerNode)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate number of unique memberships per node.
     *
     * @return void
     */
    public function nodesNumberOfUniqueCustomersPerNode()
    {
        $rows = DB::table('order_items')
        ->select(DB::raw('node_id, count(*) as count'))
        ->groupBy('node_id')
        ->get();

        $nodesNumberOfUniqueCustomersPerNode = [];
        foreach ($rows as $row) {
            if (!isset($nodesNumberOfUniqueCustomersPerNode[$row->node_id])) {
                $nodesNumberOfUniqueCustomersPerNode[$row->node_id] = 0;
            }

            $nodesNumberOfUniqueCustomersPerNode[$row->node_id] = $row->count;
        }

        $query = ['key' => 'nodes_unique_customers_per_node', 'data' => json_encode($nodesNumberOfUniqueCustomersPerNode)];
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
        $query['updated'] = date('Y-m-d H:i:s');

        try {
            DB::table('statistics')->insert($query);
        } catch (\Exception $e) {
            DB::table('statistics')
            ->where('key', $query['key'])
            ->update($query);
        }
    }
}
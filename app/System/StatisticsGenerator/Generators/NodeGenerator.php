<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\Node\Node;

class NodeGenerator extends BaseGenerator
{
    /**
     * Run scripts.
     *
     * @return void
     */
    public function generate()
    {
        $this->count();
        $this->members();
        $this->customers();
        $this->producers();
        $this->products();
    }

    /**
     * Generate node count.
     *
     * @return void
     */
    private function count()
    {
        $total = Node::count();
        $query = ['key' => 'node_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate current membership count per node.
     *
     * @return void
     */
    private function members()
    {
        $rows = DB::table('user_node_links')
        ->select('node_id', 'user_id')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = 0;
            }

            $data[$row->node_id] += 1;
        }

        $query = ['key' => 'node_members', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate total number of ordering customers per node.
     *
     * @return void
     */
    private function customers()
    {
        $rows = DB::table('order_items')
        ->select(DB::raw('node_id, count(*) as count'))
        ->groupBy('node_id')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = 0;
            }

            $data[$row->node_id] = $row->count;
        }

        $query = ['key' => 'node_customers', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate current number of producers per node.
     *
     * @return void
     */
    private function producers()
    {
        $rows = DB::table('producer_node_links')
        ->select(DB::raw('node_id, count(DISTINCT producer_id) AS count'))
        ->groupBy('node_id')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = 0;
            }

            $data[$row->node_id] = $row->count;
        }

        $query = ['key' => 'node_producers', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate current number of products per node.
     *
     * @return void
     */
    private function products()
    {
        $rows = DB::table('product_node_delivery_links')
        ->join('products', 'products.id', '=', 'product_node_delivery_links.product_id')
        ->select(DB::raw('node_id, count(DISTINCT product_id) AS count'))
        ->where('is_hidden', false)
        ->groupBy('node_id')
        ->get();

        $data = [];
        foreach ($rows as $row) {
            if (!isset($data[$row->node_id])) {
                $data[$row->node_id] = 0;
            }

            $data[$row->node_id] = $row->count;
        }

        $query = ['key' => 'node_products', 'data' => json_encode($data)];
        $this->insertOrUpdate($query);
    }
}
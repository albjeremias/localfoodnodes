<?php

namespace App\System;

use Illuminate\Support\Facades\DB;

use App\Node\Node;
use App\Node\NodeDate;

class NodeDatesGenerator
{
    /**
     * Run generator.
     *
     * @return void
     */
    public function generate()
    {
        $nodes = Node::all();

        foreach ($nodes as $node) {
            // Clean up old dates
            $dates = $node->getDeliveryDates();
            foreach ($dates as $date) {
                try {
                    NodeDate::create([
                        'node_id' => $node->id,
                        'datetime' => $date . ' ' . $node->delivery_time,
                    ]);
                } catch (Exception $e) {
                    // Ignore duplicate, do nothing
                }
            }
        }
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
            DB::table('nodes_generated')->insert($query);
        } catch (\Exception $e) {
            DB::table('nodes_generated')
            ->where('node_id', $query['node_id'])
            ->update($query);
        }
    }
}
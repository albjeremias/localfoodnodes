<?php

namespace App\System;

use Illuminate\Support\Facades\DB;

use App\Node\Node;

class NodesGenerator
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
            $nodeData = $node->toArray();
            $nodeData['users'] = $node->userLinks()->count();
            $nodeData['producers'] = $node->producerLinks()->count();
            $nodeData['average_producer_distance'] = $node->getAverageProducerDistance();

            // Fixing “Inf and NaN cannot be JSON encoded” the easy way
            $data = json_encode(unserialize(str_replace(['NAN;','INF;'], '0;', serialize($nodeData))));

            $this->insertOrUpdate([
                'node_id' => $nodeData['id'],
                'data' => $data,
            ]);
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
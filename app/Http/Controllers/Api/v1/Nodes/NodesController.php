<?php

namespace App\Http\Controllers\Api\v1\Nodes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Node\Node;

class NodesController extends \App\Http\Controllers\Controller
{
    public function nodes(Request $request)
    {
        if (!Cache::has('nodes')) {
            $nodes = Node::with(['imageRelationship'])->get();
            Cache::put('nodes', $nodes, 5);
        }

        return Cache::get('nodes');
    }

    public function count(Request $request)
    {
        return Node::count();
    }

    public function node(Request $request, $nodeId)
    {
        return Node::with(['imageRelationship'])->find($nodeId);
    }

    public function nodeDates(Request $request, $nodeId)
    {
        $node = Node::find($nodeId);

        return $node->getDeliveryDatesWithProducts();
    }
}

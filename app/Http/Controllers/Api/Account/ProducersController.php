<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Producer\ProducerNodeLink;

class ProducersController extends ApiBaseController
{
    // GET /api/account/producer/{producerId}/nodes
    public function nodes(Request $request, $producerId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();

        return $producer->nodeLinks()->map(function($nodeLink) {
            return $nodeLink->getNode();
        });
    }

    /**
     * Add node to map action.
     */
    public function addNode(Request $request, $producerId, $nodeId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();

        try {
            ProducerNodeLink::create(['producer_id' => $producer->id, 'node_id' => $nodeId]);
        } catch(\Exception $e) {
            return response()->json($e, 400);
        }

        return $producer->nodeLinks()->map(function($nodeLink) {
            return $nodeLink->getNode();
        });
    }

    /**
     * Remove node from map action.
     */
    public function removeNode(Request $request, $producerId, $nodeId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();

        // Remove producer node link
        $producerNodeLink = ProducerNodeLink::where('producer_id', $producer->id)->where('node_id', $nodeId)->first();
        $producerNodeLink->delete();

        return $producer->nodeLinks()->map(function($nodeLink) {
            return $nodeLink->getNode();
        });
    }
}
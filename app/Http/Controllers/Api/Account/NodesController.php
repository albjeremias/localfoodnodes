<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiBaseController;

use App\Node\Node;

class NodesController extends ApiBaseController
{
    // GET /api/account/node/{nodeId}/deliveries
    public function deliveries(Request $request, $nodeId)
    {
        $node = Node::find($nodeId);

        if (!$node) {
            return response()->json('Node id is missing.', 400);
        }

        return $node->getDeliveryDates();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $nodeId
     * @param [type] $date
     * @return void
     */
    public function productNodeDeliveryLinks(Request $request, $nodeId, $date)
    {
        $node = Node::find($nodeId);
        return $node->productNodeDeliveryLinksByDate($date);
    }

}
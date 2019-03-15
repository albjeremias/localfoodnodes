<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiBaseController;

use App\Node\Node;
use App\Node\NodeDate;

class NodesController extends ApiBaseController
{
    // GET /api/account/node/{nodeId}/deliveries
    // public function deliveries(Request $request, $nodeId)
    // {
    //     $node = Node::find($nodeId);

    //     if (!$node) {
    //         return response()->json('Node id is missing.', 400);
    //     }

    //     return $node->getDeliveryDates();
    // }

    public function dates(Request $request, $nodeId)
    {
        if (!$nodeId) {
            return response()->json('Node id is missing.', 400);
        }

        return NodeDate::where('node_id', $nodeId)->pluck('datetime');
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

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $nodeId
     * @param [type] $date
     * @return void
     */
    public function createDate(Request $request, $nodeId)
    {
        if (!$nodeId) {
            return response()->json('Node id is missing.', 400);
        }

        $node = Node::find($nodeId);

        if (!$request->has('date')) {
            return response()->json('Date is missing.', 400);
        }

        \Log::debug(var_export($request->input('date'), true));
        $datetime = date('Y-m-d H:i:s', strtotime($request->input('date')));
        $date = date('Y-m-d', strtotime($request->input('date')));
        $nodeDate = NodeDate::withTrashed()
        ->where('node_id', $node->id)
        ->whereDate('datetime', $date)
        ->first();

        if ($nodeDate) {
            if ($nodeDate->trashed()) {
                $nodeDate->restore();
                $nodeDate->datetime = $datetime; // Update time
                $nodeDate->save();
            } else {
                return response()->json('The date ' . $date . ' already exists.', 400);
            }
        } else {
            $nodeDate = NodeDate::create([
                'node_id' => $node->id,
                'datetime' => $datetime
            ]);
        }

        return NodeDate::where('node_id', $node->id)->pluck('datetime');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $nodeId
     * @param [type] $date
     * @return void
     */
    public function deleteDate(Request $request, $nodeId, $date)
    {
        if (!$nodeId) {
            return response()->json('Node id is missing.', 400);
        }

        $node = Node::find($nodeId);

        if (!$date) {
            return response()->json('Date is missing.', 400);
        }

        NodeDate::where([
            'node_id' => $node->id,
            'datetime' => $date
        ])->delete();

        return NodeDate::where('node_id', $node->id)->pluck('datetime');
    }
}
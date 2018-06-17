<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\User\UserNodeLink;

class NodesController extends BaseController
{
    public function nodes(Request $request)
    {
        $user = Auth::guard('api')->user();

        return $user->nodes()->sortBy(function($node) {
            return $node->name;
        });
    }

    public function followNode(Request $request, $nodeId)
    {
        $user = Auth::guard('api')->user();
        $userNodeLink = UserNodeLink::where('user_id', $user->id)->where('node_id', $nodeId)->first();

        if (!$userNodeLink) {
            UserNodeLInk::create([
                'user_id' => $user->id,
                'node_id' => $nodeId
            ]);
        }
    }

    public function unfollowNode(Request $request, $nodeId)
    {
        $user = Auth::guard('api')->user();
        $userNodeLink = UserNodeLink::where('user_id', $user->id)->where('node_id', $nodeId)->first();

        if ($userNodeLink) {
            $userNodeLink->delete();
        }
    }
}

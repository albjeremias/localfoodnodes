<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiBaseController;

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
}
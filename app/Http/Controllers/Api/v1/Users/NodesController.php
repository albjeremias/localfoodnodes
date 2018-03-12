<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class NodesController extends BaseController
{
    public function nodes(Request $request)
    {
        $user = Auth::guard('api')->user();
        return $user->nodes();
    }
}

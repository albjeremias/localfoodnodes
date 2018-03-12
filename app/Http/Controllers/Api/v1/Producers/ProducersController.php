<?php

namespace App\Http\Controllers\Api\v1\Producers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Producer\Producer;

class ProducersController extends BaseController
{
    public function producers(Request $request)
    {
        return Producer::all();
    }

    public function count(Request $request)
    {
        return Producer::count();
    }
}

<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Order\OrderDateItemLink;

class SystemController extends BaseController
{
    public function info(Request $request)
    {
        echo phpinfo();
    }
}

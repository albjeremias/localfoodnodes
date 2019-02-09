<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiBaseController;

class UsersController extends ApiBaseController
{
    public function user(Request $request)
    {
        return Auth::user();
    }

    public function nodes(Request $request)
    {
        $user = Auth::user();

        return $user->nodes();
    }
}
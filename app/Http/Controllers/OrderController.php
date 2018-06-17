<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \App\Traits\OrderLogic;

class OrderController extends Controller
{
    use OrderLogic;

    /**
     * Create order action.
     */
    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $errors = $this->validateOrder($user);

        if ($errors->isEmpty()) {
            $orderDateItemLinks = $this->saveOrder($user);

            $this->sendCustomerOrderEmail($orderDateItemLinks, $user);
            $this->sendProducerOrderEmails($orderDateItemLinks, $user);
            $user->cartDateItemLinks()->each->delete();

            \App\Helpers\SlackHelper::message('notification', $user->name . ' placed an order.');

            return response()->json([], 200);
        }

        if ($errors) {
            $request->session()->flash('error', $errors->all());
            return response()->json(['error' => true], 400);
        }
    }
}

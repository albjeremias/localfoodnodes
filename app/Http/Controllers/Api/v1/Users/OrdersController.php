<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \App\Traits\OrderLogic;

class OrdersController extends \App\Http\Controllers\Controller
{
    use OrderLogic;

    public function orders(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orderDateItemLinks = $user->orderDateItemLinks();

        $orderDateItemLinks = $orderDateItemLinks->map(function($orderDateItemLink) {
            $orderDate = $orderDateItemLink->getDate();
            $orderItem = $orderDateItemLink->getItem();

            $orderDateItemLinkArray = $orderDateItemLink->toArray();
            $orderDateItemLinkArray['date'] = $orderDate->toArray();
            $orderDateItemLinkArray['item'] = $orderItem->toArray();

            return $orderDateItemLinkArray;
        });

        return $orderDateItemLinks;
    }

    /**
     * Create order action.
     */
    public function createOrder(Request $request)
    {
        $user = Auth::guard('api')->user();
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

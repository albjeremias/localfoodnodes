<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use \App\Traits\OrderLogic;

class OrdersController extends BaseController
{
    use OrderLogic;

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $orderDateItemLinkId
     * @return void
     */
    public function order(Request $request, $orderDateItemLinkId)
    {
        $user = Auth::guard('api')->user();

        if (!$orderDateItemLinkId) {
            return null;
        }

        $orderDateItemLink = $user->orderDateItemLink($orderDateItemLinkId);

        if (!$orderDateItemLink) {
            return null;
        }

        return $this->loadRelatedOrderData($orderDateItemLink);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function orders(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orderDateItemLinks = $user->orderDateItemLinks();

        return $this->loadRelatedOrdersData($orderDateItemLinks);
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

    /**
     * Delete order item action.
     */
    public function deleteOrder(Request $request, $orderDateItemLinkId)
    {
        $user = Auth::guard('api')->user();

        $orderDateItemLink = $user->orderDateItemLink($orderDateItemLinkId);

        if ($orderDateItemLink) {
            $orderDateItemLink->delete();
        }

        $orderDateItemLinks = $user->orderDateItemLinks();
        return $this->loadRelatedOrdersData($orderDateItemLinks);
    }

    /**
     * Helper
     */
    private function loadRelatedOrdersData(Collection $orderDateItemLinks)
    {
        return $orderDateItemLinks->map(function($orderDateItemLink) {
            return $this->loadRelatedOrderData($orderDateItemLink);
        });
    }

    /**
     * Undocumented function
     *
     * @param [type] $orderDateItemLink
     * @return void
     */
    private function loadRelatedOrderData(\App\Order\OrderDateItemLink $orderDateItemLink)
    {
        $orderDate = $orderDateItemLink->getDate();
        $orderItem = $orderDateItemLink->getItem();

        $orderDateItemLinkArray = $orderDateItemLink->toArray();
        $orderDateItemLinkArray['date'] = $orderDate->toArray();
        $orderDateItemLinkArray['item'] = $orderItem->toArray();

        return $orderDateItemLinkArray;
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Order\OrderDateItemLink;
use App\Order\OrderItem;
use App\Order\OrderDate;

class OrdersController extends BaseController
{
    public function count()
    {
        return OrderDateItemLink::count();
    }

    public function orders(Request $request)
    {
        if (!Cache::has('orders')) {
            $orderDateItemLinks = OrderDateItemLink::with(['orderItemRelationship', 'orderDateRelationship'])->get();
            $orders = $orderDateItemsLinks->map(function($orderDateItemLink) {
                // Exclude user details here
                $item = $orderDateItemLink->getItem();
                $date = $orderDateItemLink->getDate();

                if ($item) {
                    $orderDateItemLink->item = $item;
                } else {
                    return null;
                }

                if ($date) {
                    $orderDateItemLink->date = $date;
                } else {
                    return null;
                }

                return $orderDateItemLink;
            })->filter();

            Cache::put('orders', $orders, 60);
        }

        return Cache::get('orders');
    }

    public function orderItem(Request $request, $orderItemId)
    {
        return OrderItem::find($orderItemId);
    }

    public function orderDate(Request $request, $orderDateId)
    {
        return OrderDate::find($orderDateId);
    }

    public function circulation()
    {
        if (!Cache::has('circulation')) {
            $orderDateItemLinks = OrderDateItemLink::with(['orderItemRelationship', 'orderDateRelationship'])->get();
            $circulation = $orderDateItemLinks->map(function($orderDateItemLink) {
                $item = $orderDateItemLink->getItem();
                $date = $orderDateItemLink->getDate();

                if (!$item || !$date) {
                    return 0;
                }

                $price = $orderDateItemLink->getItem()->product['price'];

                return $price * $orderDateItemLink->quantity;
            })->sum();

            Cache::put('circulation', $circulation, 1);
        }

        return Cache::get('circulation');
    }
}

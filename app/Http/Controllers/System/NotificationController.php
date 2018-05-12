<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class NotificationController extends BaseController
{
    /**
     * There are new products to order.
     * Optional
     *
     * @param Request $request
     * @return void
     */
    public function newProductOnNode(Request $request)
    {

    }

    /**
     * Next scheduled pickup date.
     * Optional
     *
     * @param Request $request
     * @return void
     */
    public function nextPickupDate(Request $request)
    {

    }

    /**
     * Pickup of ordered products. First notification is send 1 day before pickup, the second 1 hour before pickup.
     *
     * @param Request $request
     * @return void
     */
    public function upcomingPickup(Request $request)
    {

    }

    /**
     * Producer has a new order.
     *
     * @param Request $request
     * @return void
     */
    public function newIncomingOrder(Request $request)
    {

    }
}

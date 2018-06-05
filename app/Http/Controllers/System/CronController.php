<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class NotificationController extends BaseController
{
    /**
     * New products.
     * Run: every hour.
     *
     *
     * @param Request $request
     * @return void
     */
    public function newProductOnNode(Request $request)
    {

    }

    /**
     * Next scheduled pickup date.
     * Run: three days before
     *
     *
     * @param Request $request
     * @return void
     */
    public function nextPickupDate(Request $request)
    {

    }

    /**
     * Pickup of ordered products.
     * Run: First notification 1 day before pickup, the second 1 hour before pickup.
     *
     * @param Request $request
     * @return void
     */
    public function upcomingPickup(Request $request)
    {

    }

    /**
     * Producer has a new order.
     * Run: Every hours
     *
     * @param Request $request
     * @return void
     */
    public function newIncomingOrder(Request $request)
    {

    }
}

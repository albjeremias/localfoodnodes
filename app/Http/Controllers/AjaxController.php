<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use LocalFoodNodes\Sdk\LocalFoodNodes;

use App\Http\Requests;
use App\Node\Node;
use App\Node\Reko;
use App\Helpers\MapHelper;
use App\Order\OrderDateItemLink;

class AjaxController extends BaseController
{
    /**
     * Proxy for the frontend to communicating with API
     *
     * @param Request $request
     * @return string json
     */
    public function apiProxy(Request $request)
    {
        $method = $request->has('method') ? $request->input('method') : 'get';
        $url = $request->input('url');

        $api = new LocalFoodNodes(env('API_URL'), env('PUBLIC_API_CLIENT_ID'), env('PUBLIC_API_SECRET'), env('PUBLIC_API_USERNAME'), env('PUBLIC_API_PASSWORD'));
        return $api->request($method, $url, $request->all());
    }

    /**
     * Endpoint for fetching order count.
     *
     * @return int
     */
    public function orderCount()
    {
        if (!Cache::has('orderCount')) {
            $count = OrderDateItemLink::count();
            Cache::put('orderCount', $count, 60);
        }

        return Cache::get('orderCount');
    }

    /**
     * Endpoint for fetching total order circulation.
     *
     * @return int
     */
    public function orderCirculation()
    {
        if (!Cache::has('orderCirculation')) {
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

            Cache::put('orderCirculation', $circulation, 60);
        }

        return Cache::get('orderCirculation');
    }

    /**
     * Get all map contents.
     *
     * Initial load: show x nodes closest to user location
     * On search: show the (one) node closest to searched location
     * On zoom: Load nodes within bountries
     *
     * @param Request $request
     * @return array
     */
    public function mapContent(Request $request)
    {
        $mapHelper = new MapHelper();
        $nodes = $this->getNodes($request, $mapHelper);

        if (!Cache::has('reko')) {
            $reko = Reko::all();
            Cache::put('reko', $reko, 60);
        } else {
            $reko = Cache::get('reko');
        }

        return response()->json([
            'nodes' => $nodes,
            'reko' => $reko,
        ]);
    }

    /**
     * Get nodes.
     *
     * @param Request $request
     * @param MapHelper $mapHelper
     * @return Collection
     */
    private function getNodes(Request $request, $mapHelper)
    {
        if ($request->has('bounds')) {
            $bounds = $request->input('bounds');
            $nodes = $mapHelper->getNodesByBounds($bounds);
        } else {
            $nodes = Node::all();
        }

        return $nodes;
    }

    /**
     * Get reko.
     *
     * @return Collection
     */
    private function getReko()
    {
        return Reko::all();
    }
}

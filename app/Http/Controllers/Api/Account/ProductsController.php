<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiBaseController;

use App\Product\Product;
use App\Product\ProductNodeDeliveryLink;
use App\Product\ProductFilter;

class ProductsController extends ApiBaseController
{
    // GET /api/account/producer/{producerId}/products?nodeId={nodeId}&date={date}
    public function products(Request $request, $producerId)
    {
        // Filters
        $date = $request->input('date');
        $nodeId = $request->input('nodeId');

        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $productIds = $producer->products()->map(function($product) {
            return $product->id;
        });

        // return $productIds;

        // Get product ids matching node and date filter
        if ($nodeId) {
            $linkQuery = ProductNodeDeliveryLink::where('node_id', $nodeId)->whereIn('product_id', $productIds);

            if ($date) {
                $linkQuery->where('date', $date);
            }

            $productIds = $linkQuery->get()->pluck('product_id')->unique();

            return $productIds;

            $products = Product::with([
                'producerRelationship',
                'productVariantsRelationship',
                'imageRelationship'
            ])->where('producer_id', $producer->id)
            ->whereIn('id', $productsId)
            ->get();
        } else {
            $products = Product::with([
                'producerRelationship',
                'productVariantsRelationship',
                'imageRelationship'
            ])->where('producer_id', $producerId)
            ->get();
        }

        return $products;
    }

    // POST /api/account/producer/{producerId}/product/{productId}
    // {
    //     variantId,
    //     deadline,
    //     stock,
    //     price
    // }


    // POST /api/account/producer/{producerId}/products/activate

}
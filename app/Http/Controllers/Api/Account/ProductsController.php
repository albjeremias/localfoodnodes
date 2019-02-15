<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\ApiBaseController;

use App\Product\Product;
use App\Product\ProductNodeDeliveryLink;
use App\Product\ProductFilter;
use App\Product\ProductVariant;

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

        // Get product ids matching node and date filter
        if ($nodeId) {
            $linkQuery = ProductNodeDeliveryLink::where('node_id', $nodeId)->whereIn('product_id', $productIds);

            if ($date) {
                $linkQuery->where('date', $date);
            }

            $productIds = $linkQuery->get()->pluck('product_id')->unique();

//            return $productIds;

            $products = Product::with([
                'producerRelationship',
                'productVariantsRelationship',
                'imageRelationship'
            ])->where('producer_id', $producer->id)
            ->whereIn('id', $productIds)
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

    public function product(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        return $product;
    }

    // POST /api/account/producer/{producerId}/products/{productId}
    public function updateProduct(Request $request, $producerId, $productId)
    {
        if (!$request->has('data')) {
            return response()->json('Data is missing.', 400);
        }

        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        foreach ($request->input('data') as $field => $value) {
            $product->{$field} = $value;
        }

        // Update variants too

        $product->save();

        return $product;
    }

    // POST /api/account/producer/{producerId}/products/toggle-visibility
    public function setAllProductsVisibilityToggle(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();

        return $producer->products->map(function($product) {
            $product->is_hidden = !$product->is_hidden;
            $product->save();

            return $product;
        });
    }

    // POST /api/account/producer/{producerId}/products/{productId}/toggle-visibility
    public function setProductVisibilityToggle(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $product->is_hidden = !$product->is_hidden;
        $product->save();

        return $product;
    }

    public function getNewVariant(Request $request, $producerId, $productId)
    {
        $variant = new ProductVariant();

        return array_fill_keys($variant->getFillable(), null);
    }

    public function variants(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        $variants = ProductVariant::where('product_id', $product->id)->orderBy('main_variant', 'desc')->orderBy('id', 'desc')->get();
        $variant = new ProductVariant();

        $response = [
            'main_variant' => $product->mainVariant()->id,
            'use_variants' => $product->variants()->count() > 0 ? true : false,
            'shared_variant_quantity' => $product->shared_variant_quantity,
            'package_unit' => $product->package_unit,
            'variants' => $variants,
            'newVariants' => [],
        ];

        if ($product->variants()->count() === 0) {
            $response['newVariants'] = [
                array_fill_keys($variant->getFillable(), null)
            ];
        }

        return $response;
    }

    public function updateVariants(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        $variants = $request->input('variants');

        $product->shared_variant_quantity = $variants['shared_variant_quantity'];
        $product->package_unit = $variants['package_unit'];

        $mainVariant = $variants['main_variant'];
        $newVariantIsMain = false;
        if (strpos($variants['main_variant'], 'new-variant-index-') !== false) {
             // Set flag to check if created variant is main
            $newVariantIsMain = true;
            // Set index of new variant to main variant for now. This will change when we loop and create the new variants
            // and will be assigned a variant id instead.
            $mainVariant = (int) str_replace('new-variant-index-', '', $variants['main_variant']);
        }

        // Create new
        foreach ($variants['newVariants'] as $index => $data) {
            $data['product_id'] = $productId;
            $data['main_variant'] = false;

            $variant = new ProductVariant();
            $errors = $variant->validate($data);
            if ($errors->isEmpty()) {
                $variant->fill($data);
                $variant->save();

                if ($newVariantIsMain && $mainVariant === $index) {
                    $mainVariant = $variant->id;
                }
            } else {
                error_log(var_export($errors, true));
                // Set error on field an return to frontend
            }
        }

        // Update
        foreach ($variants['variants'] as $data) {
            $variant = ProductVariant::find($data['id']);
            $variant->fill($data);
            $errors = $variant->validate($data);
            if ($errors->isEmpty()) {
                $variant->save();
            } else {
                error_log(var_export($errors, true));
                // Set error on field an return to frontend
            }
        }

        $product->save();

        // Set main variant
        $variants = ProductVariant::where('product_id', $productId)->orderBy('main_variant', 'desc')->orderBy('id', 'desc')->get();
        $variants = $variants->map(function($variant) use ($mainVariant) {
            $variant->main_variant = $variant->id === $mainVariant ? true : false;
            $variant->save();
            return $variant;
        });

        return $variants;
    }

    public function deleteVariant(Request $request, $producerId, $productId, $variantId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $variant = $product->variant($variantId);

        $variant->delete();

        return ProductVariant::where('product_id', $productId)->orderBy('main_variant', 'desc')->orderBy('id', 'desc')->get();
    }

    public function stock(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        return [
            'has_stock' => $product->has_stock ? true : false,
            'stock_quantity' => $product->stock_quantity,
            'recurring' => $product->stock_type === 'recurring' || $product->stock_type === 'csa',
            'csa' => $product->stock_type === 'csa',
        ];
    }

    public function updateStock(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        $stock = $request->input('stock');

        $product->has_stock = $stock['has_stock'];
        $product->stock_quantity = $stock['stock_quantity'];

        if ($stock['csa']) {
            $product->stock_type = 'csa';
        } else if ($stock['recurring']) {
            $product->stock_type = 'recurring';
        }

        // Todo: How validate?
        $product->save();

        return response($stock, 200);
    }
}
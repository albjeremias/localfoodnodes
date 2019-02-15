<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Api\ApiBaseController;

use App\Product\Product;
use App\Product\ProductNodeDeliveryLink;
use App\Product\ProductFilter;
use App\Product\ProductVariant;

class ProductsController extends ApiBaseController
{
    /**
     * Get all products for a producer.
     *
     * @param Request $request
     * @param [type] $producerId
     * @return void
     */
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

    /**
     * Get product.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
    public function product(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        return $product;
    }

    /**
     * Update product.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
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

    /**
     * Toggle all products visibility
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
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

    /**
     * Toggle specific product visibility.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
    public function setProductVisibilityToggle(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $product->is_hidden = !$product->is_hidden;
        $product->save();

        return $product;
    }

    /**
     * Get new empty variant.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
    public function getNewVariant(Request $request, $producerId, $productId)
    {
        $variant = new ProductVariant();
        $variant = array_fill_keys($variant->getFillable(), null);
        $index = (int) $request->input('currentIndex');

        $variant['main_variant'] = false;
        $variant['id'] = 'new-variant-index-' . ($index++);

        return $variant;
    }

    /**
     * Get variants.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
    public function variants(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $mainVariant = $product->mainVariant();

        $variants = ProductVariant::where('product_id', $product->id)->orderBy('main_variant', 'desc')->orderBy('id', 'asc')->get();
        $variant = new ProductVariant();

        // Recalculate quantity for shared variant quantity
        // Todo: private reusable method
        if ($product->shared_variant_quantity) {
            $variants = $variants->map(function($variant) use ($product, $mainVariant) {
                $variant->quantity = floor(($mainVariant->quantity * $mainVariant->package_amount) / $variant->package_amount);
                return $variant;
            });
        }

        $response = [
            'errors' => [],
            'main_variant' => $product->mainVariant()->id,
            'use_variants' => $product->variants()->count() > 0 ? true : false,
            'shared_variant_quantity' => $product->shared_variant_quantity,
            'package_unit' => $product->package_unit,
            'variants' => $variants->toArray(),
            'newVariants' => [],
        ];

        if ($product->variants()->count() === 0) {
            $response['newVariants'] = [
                array_fill_keys($variant->getFillable(), null)
            ];
        }

        return $response;
    }

    /**
     * Update variants.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
    public function updateVariants(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $mainVariant = $product->mainVariant();

        $variantsData = $request->input('variants');

        $product->shared_variant_quantity = $variantsData['shared_variant_quantity'];
        $product->package_unit = $variantsData['package_unit'];
        $product->save();

        // Reset main variant, will be set later
        DB::table('product_variants')->where('product_id', $product->id)->update(['main_variant' => false]);

        $allErrors = [];

        // Create new variants
        foreach ($variantsData['newVariants'] as $index => $data) {
            $data['product_id'] = $productId;
            $data['main_variant'] = $variantsData['main_variant'] == $data['id'] ? true : false;

            if ($data['main_variant']) {
                $data['quantity'] = $product->stock_quantity;
                $data['price'] = $product->price;
            }

            if ($variantsData['shared_variant_quantity'] && $data['package_amount']) {
                $data['quantity'] = floor(($mainVariant->quantity * $mainVariant->package_amount) / $data['package_amount']);
            }

            $variant = new ProductVariant();

            $errors = $variant->validate($data);
            if ($errors->isEmpty()) {
                $variant->fill($data);
                $variant->save();
                unset($variantsData['newVariants'][$index]);
            } else {
                $allErrors[$data['id']] = $errors->toArray();
            }
        }

        // Update
        foreach ($variantsData['variants'] as $data) {
            $variant = ProductVariant::find($data['id']);
            $data['main_variant'] = $variantsData['main_variant'] == $data['id'] ? true : false;
            $variant->fill($data);

            $errors = $variant->validate($data);
            if ($errors->isEmpty()) {
                $variant->save();
            } else {
                $allErrors[$index] = $errors->toArray();
            }
        }

        $variants = ProductVariant::where('product_id', $product->id)->orderBy('main_variant', 'desc')->orderBy('id', 'asc')->get()->toArray();

        if (!empty($allErrors)) {
            return response([
                'variants' => $variants,
                'newVariants' => $variantsData['newVariants'],
                'errors' => $allErrors
            ], 400);
        } else {
            return $variants;
        }

        // Return variants with correct sort order
        // return ProductVariant::where('product_id', $product->id)->orderBy('main_variant', 'desc')->orderBy('id', 'desc')->get()->toArray();
    }

    /**
     * Delete variant.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @param [type] $variantId
     * @return void
     */
    public function deleteVariant(Request $request, $producerId, $productId, $variantId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $variant = $product->variant($variantId);

        // If deleting main variant - set new...
        if ($variant->main_variant) {

        }

        $variant->delete();

        return ProductVariant::where('product_id', $productId)->orderBy('main_variant', 'desc')->orderBy('id', 'asc')->get()->toArray();
    }

    /**
     * Get stock.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
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

    /**
     * Update stock.
     *
     * @param Request $request
     * @param [type] $producerId
     * @param [type] $productId
     * @return void
     */
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
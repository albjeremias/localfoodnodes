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
use App\Helpers\UnitsHelper;

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
        $nodeId = $request->input('nodeId');
        $date = $request->input('date');

        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $productIds = $producer->products()->map(function($product) {
            return $product->id;
        });

        $withQuery = [
            'imageRelationship',
            'producerRelationship',
            'productVariantsRelationship',
        ];

        if ($request->has('all')) {
            // Get all products with a delivery link for the node and date
            if ($nodeId && $date) {
                $withQuery['deliveryLinksRelationship'] = function($query) use ($nodeId, $date) {
                    $query->where('node_id', $nodeId)
                    ->where('date', $date);
                };

                $withQuery['productVariantsRelationship.deliveryLinksRelationship'] = function($query) use ($nodeId, $date) {
                    $query->where('node_id', $nodeId)
                    ->where('date', $date);
                };
            }

            return Product::with($withQuery)
            ->where('producer_id', $producer->id)
            ->get();
        } else {
            // Get products matching node and date
            if ($nodeId) {
                // Exclude products without any delivery links for specified node and date
                $linkQuery = ProductNodeDeliveryLink::where('node_id', $nodeId)->whereIn('product_id', $productIds);

                if ($date) {
                    $linkQuery->where('date', $date);
                }

                $productIds = $linkQuery->get()->pluck('product_id')->unique();
                return Product::with($withQuery)->where('producer_id', $producer->id)
                ->whereIn('id', $productIds)
                ->get();
            } else {
                // All products for a producer
                return Product::with($withQuery)
                ->where('producer_id', $producer->id)
                ->get();
            }
        }
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
     * Add product node delivery link.
     *
     * @param Request $request
     * @param int $producerId
     * @param int $productId
     * @return void
     */
    public function addProductNodeDeliveryLink(Request $request, $producerId, $productId, $nodeId, $date)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        try {
            if (!$product->variants()->isEmpty()) {
                foreach ($product->variants() as $variant) {
                    $productNodeDeliveryLink = ProductNodeDeliveryLink::create([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'node_id' => $nodeId,
                        'date' => $date,
                        'quantity' => null,
                        'price' => null,
                        'deadline' => null,
                    ]);
                }
            } else {
                $productNodeDeliveryLink = ProductNodeDeliveryLink::create([
                    'product_id' => $product->id,
                    'node_id' => $nodeId,
                    'date' => $date,
                    'quantity' => null,
                    'price' => null,
                    'deadline' => null,
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response('Delivery link already exists', 400);
        }
    }

    /**
     * Add product node delivery link.
     *
     * @param Request $request
     * @param int $producerId
     * @param int $productId
     * @return void
     */
    public function deleteProductNodeDeliveryLink(Request $request, $producerId, $productId, $nodeId, $date)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        ProductNodeDeliveryLink::where('product_id', $product->id)
        ->where('node_id', $nodeId)
        ->where('date', $date)
        ->delete();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $nodeId
     * @param [type] $date
     * @return void
     */
    public function updateProductNodeDeliveryLink(Request $request, $producerId, $productId, $nodeId, $date)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        $productNodeDeliveryLink = ProductNodeDeliveryLink::where('product_id', $product->id)
        ->where('product_variant_id', $request->input('product_variant_id'))
        ->where('node_id', $nodeId)
        ->where('date', $date)
        ->first();

        // Create if deliery link doesn't exist
        if (!$productNodeDeliveryLink) {
            $productNodeDeliveryLink = new ProductNodeDeliveryLink();
            $productNodeDeliveryLink->product_id = $product->id;
            $productNodeDeliveryLink->date = new \DateTime($date);
        }

        $data = [
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'deadline' => $request->input('deadline'),
        ];

        if ($request->has('product_variant_id')) {
            $data['product_variant_id'] = $request->input('product_variant_id');
        }

        $productNodeDeliveryLink->fill($productNodeDeliveryLink->sanitize($data));
        $errors = $productNodeDeliveryLink->validate();

        if ($errors->isEmpty()) {
            $productNodeDeliveryLink->save();
            return $productNodeDeliveryLink;
        } else {
            return response($errors, 400);
        }
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
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);
        $mainVariant = $product->mainVariant();

        $index = (int) $request->input('currentIndex');
        $variant = new ProductVariant();
        $variant->id = 'new-variant-index-' . ($index++);

        if (!$mainVariant) {
            $variant->price = $product->price;
            $variant->package_amount = $product->package_amount;
        }

        $variant->main_variant = false;

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

        // Recalculate quantity for shared variant quantity
        if ($product->shared_variant_quantity) {
            $variants = $variants->map(function($variant) use ($product, $mainVariant) {
                $variant->quantity = floor(($mainVariant->quantity * $mainVariant->package_amount) / $variant->package_amount);
                return $variant;
            });
        }

        return [
            'errors' => [],
            'main_variant' => !$product->variants()->isEmpty() ? $product->mainVariant()->id : null,
            'use_variants' => !$product->variants()->isEmpty(),
            'shared_variant_quantity' => (bool) $product->shared_variant_quantity,
            'package_unit' => $product->package_unit,
            'variants' => $variants->toArray(),
            'newVariants' => [],
        ];
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
            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->name = $data['name'] ?? null;
            $variant->package_amount = $data['package_amount'];

            // Set main variant
            if (!$mainVariant || ($variantsData['main_variant'] == $data['id'])) {
                $variant->main_variant = true;
                $variant->price = $product->price;

                if (UnitsHelper::isStandardUnit($product->price_unit)) {
                    $variant->package_amount = $product->package_amount; // Estimate exists
                }

                $mainVariant = $variant;
            } else {
                $variant->price = (int) $data['price'];
            }

            // Calculate quantity
            if ($variantsData['shared_variant_quantity'] && $data['package_amount']) {
                $variant->quantity = floor(($mainVariant->quantity * $mainVariant->package_amount) / $variant->package_amount);
            }

            $errors = $variant->validate();
            if ($errors->isEmpty()) {
                $variant->save();

                // Remove from new variants array
                unset($variantsData['newVariants'][$index]);
            } else {
                $allErrors[$index] = $errors->toArray();
            }
        }

        // Update old variants
        foreach ($variantsData['variants'] as $data) {
            $variant = ProductVariant::find($data['id']);
            $variant->main_variant = $variantsData['main_variant'] == $data['id'] ? true : false;
            $variant->name = $data['name'] ?? null;
            $variant->price = $data['price'] ?? null;
            $variant->quantity = (float) $data['quantity'] ?? null;
            $variant->package_amount = $data['package_amount'] ?? null;

            $errors = $variant->validate();

            if ($errors->isEmpty()) {
                // Set main variant
                if (!$mainVariant || ($variantsData['main_variant'] == $data['id'])) {
                    $variant->main_variant = true;
                    $mainVariant = $variant;
                }

                $variant->save();
            } else {
                $allErrors[$variant->id] = $errors->toArray();
            }
        }

        // If shared stock
        // - Update product package amount to main variant...

        $variants = ProductVariant::where('product_id', $product->id)->orderBy('main_variant', 'desc')->orderBy('id', 'asc')->get()->toArray();

        if (!empty($allErrors)) {
            return response([
                'variants' => $variants,
                'newVariants' => $variantsData['newVariants'],
                'errors' => $allErrors,
                'main_variant' => $mainVariant->id
            ], 400);
        } else {
            return [
                'variants' => $variants,
                'main_variant' => $mainVariant->id,
            ];
        }
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
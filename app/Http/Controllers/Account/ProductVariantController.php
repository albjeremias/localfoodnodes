<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User\User;
use App\Producer\Producer;
use App\Product\Product;
use App\Product\ProductVariant;

class ProductVariantController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * Check if requested producer account exist, or if user has permission.
         */
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            // Producer
            $producerId = $request->route('producerId');
            $producerAdminLink = $user->producerAdminLink($producerId);
            $errorMessage = trans('admin/messages.request_no_producer');

            if (!$producerAdminLink) {
                $request->session()->flash('error', [$errorMessage]);
                return redirect('/account/user');
            }

            $producer = $producerAdminLink->getProducer();

            if (!$producer) {
                $request->session()->flash('error', [$errorMessage]);
                return redirect('/account/user');
            }

            // Product
            $productId = $request->route('productId');
            $product = $producer->product($productId);
            $errorMessage = trans('admin/messages.request_no_product');

            if (!$product) {
                $request->session()->flash('error', [$errorMessage]);
                return redirect('/account/producer/' . $producer->id);
            }

            // Variant
            $variantId = $request->route('variantId');
            $errorMessage = trans('admin/messages.request_no_variant');

            // No variant id so nothing to check, continue to controller action
            if (!$variantId) {
                return $next($request);
            }

            $variant = $product->variant($variantId);
            if (!$variant) {
                $request->session()->flash('error', [$errorMessage]);
                return redirect('/account/producer/' . $producer->id . '/product/' . $product->id . '/variants');
            }

            return $next($request);
        });
    }

    /**
     * Variants view.
     *
     * @param Request $request
     * @param int $productId
     */
    public function index(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        return view('new.account.product.stocks-and-variants.index', [
            'product' => $product,
            'producer' => $producer,
            'breadcrumbs' => [
	            $product->name => [
		            'link' => '/account/producer/' . $producer->id . '/product/' . $product->id . '/edit',
		            'icon' => ''
	            ],
	            __('Stock and variants') => ['']
            ]
        ]);
    }

    /**
     * Update variant.
     *
     * @param Product $product
     * @param array $data
     * @param MessageBag &$allErrors
     * @return MessageBag $allErrors
     */
    public function createAndUpdate(Request $request, $producerId, $productId)
    {
        $user = Auth::user();
        $producer = $user->producerAdminLink($producerId)->getProducer();
        $product = $producer->product($productId);

        // Variant settings
        if ($request->has('package_unit')) {
            $product->package_unit = $request->input('package_unit');
        }

        $product->shared_variant_quantity = $request->has('shared_variant_quantity');
        $product->save();

        // Variants
        if ($request->input('variants')) {
            foreach ($request->input('variants') as $variantId => $data) {
                $data['product_id'] = $product->id;

                if ($variantId === 'new') {
                    $productVariant = new ProductVariant();
                    $errors = $productVariant->validate($productVariant->sanitize($data));

                    if ($errors->isEmpty()) {
                        $productVariant->fill($data);
                        $productVariant->save();
                    }
                } else if ($variant = $product->variant($variantId)) {
                    foreach ($data as $field => $value) {
                        $variant->{$field} = $value;
                    }

                    $variant->main_variant = ($variant->id == $request->input('main_variant'));
                    $variant->save();
                }
            }
        }

        return redirect()->back();
    }
}

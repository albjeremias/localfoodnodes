<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

use App\Product\Product;
use App\Producer\Producer;
use App\Node\Node;
use App\Cart\CartDateItemLink;
use \App\Traits\CartLogic;

class CartController extends \App\Http\Controllers\Controller
{
    use CartLogic;

    public function getCart(Request $request)
    {
        $user = Auth::guard('api')->user();
        return CartDateItemLink::where('user_id', $user->id)->get();
    }

    /**
     * @param int product_id
     * @param int variant_id
     * @param array delivery_dates
     * @param int quantity
     */
    public function addCartItem(Request $request)
    {
        $user = Auth::guard('api')->user();

        $messages = new MessageBag();
        $product = Product::find($request->input('product_id'));

        // Validate
        $errors = $this->validateAddItemRequest($request, $product);

        // Abort and display errors
        if (!$errors->isEmpty()) {
            return $errors; // Status code here?
        }

        // Load additional data
        $user = Auth::user();
        $variant = $product->variants()->where('id', $request->input('variant_id'))->first();
        $producer = Producer::where('id', $product->producer_id)->first();
        $node = Node::find($request->input('node_id'));
        $data = [
            'delivery_dates' => $request->input('delivery_dates'),
            'quantity' => $request->input('quantity'),
            'message' => $request->input('message'),
        ];

        // Add item to cart
        $messages = $this->add($data, $user, $producer, $product, $variant, $node);
        $messages->add('added_to_cart', trans('public/product.added_to_cart'));

        return $messages;
    }

        /**
     * Update cart item quantity action.
     *
     * @param Request $request
     * @param int $cartItemId
     */
    public function updateCartItem(Request $request)
    {
        $cartDateItemLinkId = $request->input('cartDateItemLinkId');
        $quantity = $request->input('quantity');

        // if (!$quantity) {
        //     return $this->removeItem($request, $cartDateItemLinkId);
        // }

        $user = Auth::guard('api')->user();
        $cartDateItemLink = $user->cartDateItemLink($cartDateItemLinkId);

        if (!$cartDateItemLink) {
            // CART ITEM DOESNT EXIST
            // $request->session()->flash('message', [trans('public/checkout.cart_item_update_failed')]);
            // return redirect()->back();
        }

        $cartItem = $cartDateItemLink->getItem();

        $product = Product::find($cartItem->product['id']);
        $variant = $product->variants()->where('id', $cartItem->variant['id'])->first();
        $node = Node::find($cartItem->node['id']);

        if ($cartDateItemLink->getItem()->product['production_type'] === 'csa') {
            // CSA is all or nothing, update all dates
            $cartDateItemLinks = $user->cartItems($product->id)->map(function($cartItem) use ($product, $variant, $node, $quantity) {          // Loop all cart items
                return $cartItem->cartDateItemLinks()->map(function($cartDateItemLink) use ($product, $variant, $node, $quantity) { // Loop cartDateItemLinks
                    return $this->validateAndUpdateCartDateItemLink($cartDateItemLink, $product, $variant, $node, $quantity);       // Update
                });
            });

            // Since all items are updated, return all items
            $errors = false;
            $cartDateItemLinks = $cartDateItemLinks->map(function($cartDateItemLink) use ($errors) {
                if ($cartDateItemLink->errors) {
                    $errors = $cartDateItemLinks->errors;
                }

                return $cartDateItemLink->data;
            });

            if ($errors) {
                return response($cartDateItemLinks->data, 403);
            } else {
                return response($cartDateItemLinks->data, 200);
            }
        } else {
            $cartDateItemLink = $this->validateAndUpdateCartDateItemLink($cartDateItemLink, $product, $variant, $node, $quantity);

            if ($return->errors) {
                return response($cartDateItemLink->data, 403);
            } else {
                return response($cartDateItemLink->data, 200);
            }
        }
    }

    /**
     * Remove cart item action
     */
    public function removeCartItem(Request $request, $cartDateItemLinkId)
    {
        $user = Auth::guard('api')->user();

        $cartDateItemLink = $user->cartDateItemLink($cartDateItemLinkId);

        if (!$cartDateItemLink) {
            // Return error message!
        }

        if (isset($cartDateItemLink->getItem()->product['production_type']) && $cartDateItemLink->getItem()->product['production_type'] === 'csa') {
            // CSA is all or nothing, remove everything
            $user->cartItems($cartDateItemLink->getItem()->product['id'])->map(function($cartItem) {
                $cartItem->cartDateItemLinks()->each(function($cartDateItemLink) {
                    $cartDateItemLink->delete();
                });
            });
        } else {
            $cartDateItemLink->delete();
        }

        // Return updated cart
        return CartDateItemLink::where('user_id', $user->id)->get();
    }
}

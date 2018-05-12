<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

use App\Product\Product;
use App\Producer\Producer;
use App\Node\Node;
use App\Cart\CartDateItemLink;
use \App\Traits\CartLogic;

class CartController extends BaseController
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
            return response(['error' => 'add_to_cart_error', 'message' => $errors->all()], 400);
        }

        // Load additional data
        $data = [
            'delivery_dates' => $request->input('delivery_dates'),
            'quantity' => $request->input('quantity'),
            'message' => $request->input('message'),
        ];

        $user = Auth::user();
        $variant = $product->variants()->where('id', $request->input('variant_id'))->first();
        $producer = Producer::where('id', $product->producer_id)->first();
        $node = Node::find($request->input('node_id'));

        $errors = $this->add($data, $user, $producer, $product, $variant, $node);

        // Abort and display errors
        if (!$errors->isEmpty()) {
            return response(['error' => $errors->keys()[0], 'message' => $errors->all()], 400);
        }

        // Add item to cart
        return CartDateItemLink::where('user_id', $user->id)->get();
    }

    /**
     * Update cart item quantity action. Always return all cart items with response.
     *
     * @param Request $request
     * @param int $cartItemId
     */
    public function updateCartItem(Request $request)
    {
        $cartDateItemLinkId = $request->input('cartDateItemLinkId');
        $quantity = $request->input('quantity');

        $user = Auth::guard('api')->user();
        $cartDateItemLink = $user->cartDateItemLink($cartDateItemLinkId);


        if (!$cartDateItemLink) {
            return response($cartDateItemLinks, 400);
        }

        $cartItem = $cartDateItemLink->getItem();

        $product = Product::find($cartItem->product['id']);
        $variant = $product->variants()->where('id', $cartItem->variant['id'])->first();
        $node = Node::find($cartItem->node['id']);

        // CSA is all or nothing, update all dates and return all dates too.
        if ($cartDateItemLink->getItem()->product['production_type'] === 'csa') {
            $cartDateItemLinks = $user->cartItems($product->id)->map(function($cartItem) use ($product, $variant, $node, $quantity) {       // Loop all cart items
                return $cartItem->cartDateItemLinks()->map(function($cartDateItemLink) use ($product, $variant, $node, $quantity) {         // Loop cartDateItemLinks
                    return $this->validateAndUpdateCartDateItemLink($cartDateItemLink, $product, $variant, $node, $quantity);               // Update
                });
            })->flatten();

            // Since all items are updated, return all items
            $errors = false;
            $cartDateItemLinks = $cartDateItemLinks->map(function($cartDateItemLink) use ($errors) {
                if ($cartDateItemLink->errors) {
                    $errors = $cartDateItemLinks->errors;
                }

                return $cartDateItemLink->data;
            });

            // Return the items, errors are implicit with the status code
            return $errors ? response($cartDateItemLinks, 400) : response($cartDateItemLinks, 200);
        }

        // For everything that's not CSA just update the the single cartDateItemLink.
        if ($cartDateItemLink->getItem()->product['production_type'] !== 'csa') {
            $cartDateItemLink = $this->validateAndUpdateCartDateItemLink($cartDateItemLink, $product, $variant, $node, $quantity);

            return $return->errors ? response($cartDateItemLink->data, 400) : response($cartDateItemLink->data, 200);
        }
    }

    /**
     * Remove cart item action
     */
    public function removeCartItem(Request $request, $cartDateItemLinkId)
    {
        $user = Auth::guard('api')->user();

        $cartDateItemLink = $user->cartDateItemLink($cartDateItemLinkId);

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

<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

class CartService
{
    public function addToCart(User $user, array $data)
    {
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $data['product_id'])->first();

        if ($item) {

            $item->increment('quantity', $data['quantity']);
        } else {

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
        }

        $this->updateTotalPrice($cart);

        return $cart->fresh();
    }


    public function removeFromCart(User $user, int $productId)
    {
        $cart = $user->cart;

        if (!$cart) {
            return;
        }

        $cart->items()->where('product_id', $productId)->delete();

        $this->updateTotalPrice($cart);
    }


    private function updateTotalPrice(Cart $cart)
    {
        $total = $cart->items()->with('product')->get()->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $cart->update(['total_price' => $total,]);
    }


    public function getCart(User $user)
    {
        return Cart::with(['items.product'])->where('user_id', $user->id)->first();
    }
}

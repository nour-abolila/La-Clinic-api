<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\CartResource;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}


    public function show()
    {
        $cart = $this->cartService->getCart(auth()->user());

        return success('Cart retrieved successfully', new CartResource($cart));
    }


    public function add(AddToCartRequest $request)
    {
        $cart = $this->cartService->addToCart(auth()->user(), $request->validated());

        return success('Product added to cart', new CartResource($cart->load('items.product')));
    }


    public function remove($productId)
    {
        $this->cartService->removeFromCart(auth()->user(), $productId);

        return success('Product removed successfully');
    }
}

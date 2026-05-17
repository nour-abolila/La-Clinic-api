<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(OrderRequest $request)
    {
        $products = Product::whereIn('id', $request->products)->get();

        $total = $products->sum('price');
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_price' => $total,
        ]);

        $order->products()->attach($request->products);

        return ApiResponse::success(
            'Order created successfully',
            ['order' => $order]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10);
        return ApiResponse::success(
            'products retrieved successfully',
            ['products' => ProductResource::collection($products)]
        );
    }



    public function show(Product $product)
    {
        return ApiResponse::success(
            'product show successfully',
            ['product' => new ProductResource($product)]
        );
    }
}

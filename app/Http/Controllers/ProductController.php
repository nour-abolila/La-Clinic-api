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
        $products = Product::select('id', 'name', 'description', 'price')->paginate($this->paginate);
        return ApiResponse::success(
            'products retrieved successfully',
            ['products' => $products]
        );
    }



    public function show(Product $product)
    {
        return ApiResponse::success(
            'product show successfully',
            ['data' => new ProductResource($product)]
        );
    }
}

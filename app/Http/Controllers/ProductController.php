<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->active()->latest()->get();
        return ApiResponse::success(
            'Products retrieved successfully',
            ProductResource::collection($products)
        );
    }


    public function store(StoreProductRequest $request, Product $product)
    {
        $product = Product::create($request->validated());
        return ApiResponse::success(
            'Product created successfully',
            new ProductResource($product),
        );
    }


    public function show(Product $product)
    {
        return ApiResponse::success(
            'Product retrieved successfully',
            new ProductResource($product)
        );
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return ApiResponse::success(
            'Product updated successfully',
            new ProductResource($product)
        );
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return ApiResponse::success(
            'Product deleted successfully'
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::paginate(10);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $product = Product::create($request->all());
    //     return response()->json($product, 201);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Product $product)
    // {
    //     $product->update($request->all());
    //     return response()->json($product);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     return response()->json(['message' => 'Product deleted successfully']);
    // }
}

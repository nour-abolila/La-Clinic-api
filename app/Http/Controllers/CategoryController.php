<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug', 'description')->get();
        return ApiResponse::success(
            'Categories retrieved successfully',
            ['categories' => $categories]
        );
    }


    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return ApiResponse::success(
            'Category created successfully',
            new CategoryResource($category),
        );
    }


    public function show(Category $category)
    {
        return ApiResponse::success(
            'Category show successfully',
            ['data' => new CategoryResource($category)]
        );
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return ApiResponse::success(
            'Category updated successfully',
            ['data' => new CategoryResource($category)]
        );
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return ApiResponse::success('Category deleted successfully');
    }
}

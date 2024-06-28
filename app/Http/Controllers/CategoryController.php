<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'icon' => 'required|string|max:255'
        ]);

        // Slug
        $slug = Str::slug($data['name']);
        $data['slug'] = Category::where('slug', $slug)->exists() ? $slug . '-' . Str::random(5) : $slug;

        $category = Category::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category Created Successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => new CategoryResource($category)
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'icon' => 'required|string|max:255'
        ]);

        // Name Unique
        $existingCategory = Category::where('name', $data['name'])->where('id', '<>', $category->id)->first();
        if ($existingCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category Already Exists',
                'data' => null
            ], 422);
        }

        // Slug
        $slug = Str::slug($data['name']);
        $data['slug'] = Category::where('slug', $slug)->where('id', '<>', $category->id)->exists() ? $slug . '-' . Str::random(5) : $slug;

        $category->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category Edited Successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category Deleted Successfully'
        ]);
    }
}

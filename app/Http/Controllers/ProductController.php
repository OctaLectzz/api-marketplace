<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGalery;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return ProductResource::collection($products);
    }

    public function dashboard()
    {
        if (auth()->user()->role == 'Admin') {
            $products = Product::latest()->get();
        } else {
            $products = Product::where('user_id', auth()->id())->latest()->get();
        }

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'category_id' => 'nullable|integer|exists:categories,id',
            'photos.*' => 'required|image|mimes:png,jpg,jpeg,gif,webp,yuv,heic|max:10048'
        ]);
        $data['user_id'] = auth()->id();

        // Slug
        $slug = Str::slug($data['name']);
        $data['slug'] = Product::where('slug', $slug)->exists() ? $slug . '-' . Str::random(5) : $slug;

        $product = Product::create($data);

        // Call ProductGaleryController@store
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = 'IMG_Product' . time() . '-' . uniqid() . '.' . $photo->extension();
                $photo->move(public_path('products'), $photoName);

                ProductGalery::create([
                    'photo' => $photoName,
                    'product_id' => $product->id
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product Created Successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'category_id' => 'nullable|integer|exists:categories,id',
            'photos.*' => 'nullable'
        ]);
        $data['user_id'] = auth()->id();

        // Slug
        $slug = Str::slug($data['name']);
        $data['slug'] = Product::where('slug', $slug)->exists() ? $slug . '-' . Str::random(5) : $slug;

        $product->update($data);

        // Call ProductGaleryController@update
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = 'IMG_Product' . time() . '-' . uniqid() . '.' . $photo->extension();
                $photo->move(public_path('products'), $photoName);

                ProductGalery::create([
                    'photo' => $photoName,
                    'product_id' => $product->id
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product Edited Successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product Deleted Successfully'
        ]);
    }
}

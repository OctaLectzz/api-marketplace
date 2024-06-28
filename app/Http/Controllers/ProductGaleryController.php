<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductGalery;
use App\Http\Resources\ProductGaleryResource;

class ProductGaleryController extends Controller
{
    public function index()
    {
        $productgaleries = ProductGalery::latest()->get();

        return ProductGaleryResource::collection($productgaleries);
    }

    public function store(Request $request, $productId)
    {
        $data = $request->validate([
            'photos.*' => 'required|image|mimes:png,jpg,jpeg,gif,webp,yuv,heic|max:10048',
        ]);
        $data['product_id'] = $productId;

        $createdGalleries = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = 'IMG_Product' . time() . '-' . uniqid() . '.' . $photo->extension();
                $photo->move(public_path('products'), $photoName);

                $createdGalleries[] = ProductGalery::create([
                    'photo' => $photoName,
                    'product_id' => $data['product_id']
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product Galery Created Successfully',
            'data' => ProductGaleryResource::collection($createdGalleries)
        ]);
    }

    public function show(ProductGalery $productgalery)
    {
        return response()->json([
            'data' => new ProductGaleryResource($productgalery)
        ]);
    }

    public function update(Request $request, $productId)
    {
        $data = $request->validate([
            'photos.*' => 'required|image|mimes:png,jpg,jpeg,gif,webp,yuv,heic|max:10048',
        ]);
        $data['product_id'] = $productId;

        $newPhotoNames = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = 'IMG_Product' . time() . '-' . uniqid() . '.' . $photo->extension();
                $photo->move(public_path('products'), $photoName);
                $newPhotoNames[] = $photoName;

                ProductGalery::create([
                    'photo' => $photoName,
                    'product_id' => $data['product_id']
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product Galery Updated Successfully',
            'data' => ProductGaleryResource::collection(ProductGalery::where('product_id', $data['product_id'])->get())
        ]);
    }

    public function destroy(ProductGalery $productgalery)
    {
        $productgalery->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product Galery Deleted Successfully'
        ]);
    }
}

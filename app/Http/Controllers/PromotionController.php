<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Resources\PromotionResource;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        return PromotionResource::collection($promotions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banner' => 'required|image|mimes:png,jpg,jpeg,gif,webp,yuv,heic|max:10048',
            'url' => 'required|url|max:255'
        ]);

        // Banner
        if ($request->hasFile('banner')) {
            $bannerName = 'IMG_Promotion' . time() . '-' . uniqid() . '.' . $request->banner->getClientOriginalExtension();
            $request->banner->move(public_path('promotions'), $bannerName);
            $data['banner'] = $bannerName;
        }

        $promotion = Promotion::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion Created Successfully',
            'data' => new PromotionResource($promotion)
        ]);
    }

    public function show(Promotion $promotion)
    {
        return response()->json([
            'data' => new PromotionResource($promotion)
        ]);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'banner' => 'required|image|mimes:png,jpg,jpeg,gif,webp,yuv,heic|max:10048',
            'url' => 'required|url|max:255'
        ]);

        // Banner
        if ($request->hasFile('banner')) {
            $bannerName = 'IMG_Promotion' . time() . '-' . uniqid() . '.' . $request->banner->getClientOriginalExtension();
            $request->banner->move(public_path('promotions'), $bannerName);
            $data['banner'] = $bannerName;
        }

        $promotion->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion Edited Successfully',
            'data' => new PromotionResource($promotion)
        ]);
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion Deleted Successfully'
        ]);
    }
}

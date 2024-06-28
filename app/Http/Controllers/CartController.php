<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::latest()->get();

        return CartResource::collection($carts);
    }

    public function getbyuser()
    {
        $carts = Cart::where('user_id', auth()->id())->latest()->get();

        return response()->json([
            'data' => CartResource::collection($carts)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);
        $data['user_id'] = auth()->id();

        $cart = Cart::where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->first();
        if ($cart) {
            $data['quantity'] = $cart->quantity + $data['quantity'];
            $cart->update($data);
        } else {
            $cart = Cart::create($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Created Successfully',
            'data' => new CartResource($cart)
        ]);
    }

    public function show(Cart $cart)
    {
        return response()->json([
            'data' => new CartResource($cart)
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);
        $data['user_id'] = auth()->id();

        // Stock Check
        $product = Product::findOrFail($data['product_id']);
        if ($data['quantity'] > $product->stock) {
            $cart->update([
                'quantity' => $product->stock
            ]);

            return response()->json([
                'status' => 'failed',
                'message' => 'Order quantity cannot exceed stock',
            ], 403);
        } else {
            $cart->update($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Edited Successfully',
            'data' => new CartResource($cart)
        ]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Deleted Successfully'
        ]);
    }
}

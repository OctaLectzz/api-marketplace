<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\TransactionResource;
use App\Models\Product;

class TransactionController extends Controller
{
    public function __construct()
    {
        // \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        // \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        // \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        // \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = env('MIDTRANS_SANITIZE');
        \Midtrans\Config::$is3ds = env('MIDTRANS_3DS');
    }

    public function index()
    {
        $transactions = Transaction::latest()->get();

        return TransactionResource::collection($transactions);
    }

    public function dashboard()
    {
        if (auth()->user()->role == 'Admin') {
            $transactions = Transaction::latest()->get();
        } else {
            $transactions = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get();
        }

        return TransactionResource::collection($transactions);
    }

    public function getbyuser()
    {
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get();

        return response()->json([
            'data' => TransactionResource::collection($transactions)
        ]);
    }

    public function store(Request $request)
    {
        $transactiondata = $request->validate([
            'product_price' => 'required|numeric',
            'shipping_price' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'courier' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255',
            'resi' => 'nullable|string|max:255',
        ]);
        $transactiondata['user_id'] = auth()->id();

        // Invoice
        $transactiondata['invoice'] = 'INV-' . date('YmdHis') . '-' . str_pad(Transaction::count() + 1, 5, '0', STR_PAD_LEFT);

        $transaction = Transaction::create($transactiondata);

        // Call TransactionDetailController@store
        $transactiondetaildata = $request->validate([
            'transactiondetail.*.product_id' => 'required|integer|exists:products,id',
            'transactiondetail.*.price' => 'required|numeric',
            'transactiondetail.*.quantity' => 'required|integer'
        ]);
        foreach ($transactiondetaildata['transactiondetail'] as $item) {
            $transaction->transactionDetails()->create($item);

            $product = Product::findOrFail($item['product_id']);
            $product->update([
                'stock' => $product->stock - $item['quantity']
            ]);

            $cart = Cart::where('user_id', auth()->id())->where('product_id', $item['product_id'])->first();
            $cart->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Created Successfully',
            'data' => new TransactionResource($transaction)
        ]);
    }

    public function ongkir(Request $request)
    {
        $couriers = ['jne', 'tiki', 'pos'];
        $results = [];

        foreach ($couriers as $courier) {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
                ->post('https://api.rajaongkir.com/starter/cost', [
                    'origin'      => $request->origin,
                    'destination' => $request->destination,
                    'weight'      => $request->weight,
                    'courier'     => $courier
                ])
                ->json();

            if (isset($response['rajaongkir']['results'][0]['costs'])) {
                foreach ($response['rajaongkir']['results'][0]['costs'] as $cost) {
                    $results[] = [
                        'courier' => strtoupper($courier),
                        'service' => $cost['service'],
                        'description' => $cost['description'],
                        'price' => $cost['cost'][0]['value'],
                        'etd' => $cost['cost'][0]['etd']
                    ];
                }
            }
        }

        return response()->json($results);
    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'data' => new TransactionResource($transaction)
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'product_price' => 'required|numeric',
            'shipping_price' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'courier' => 'nullable|string|max:255',
            'shipping_estimation' => 'nullable|string|max:255',
            'shipping_description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255'
        ]);

        // Get SnapToken Midtrans
        $payload = [
            'transaction_details' => [
                'order_id'     => $transaction->invoice,
                'gross_amount' => $data['total_price'],
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email'      => $transaction->user->email,
            ],
            'item_details' => [
                [
                    'id'            => $transaction->invoice,
                    'price'         => $data['total_price'],
                    'quantity'      => 1,
                    'name'          => 'Buy Product',
                    'brand'         => env('APP_NAME'),
                    'category'      => 'Online Shop',
                    'merchant_name' => config('app.name'),
                ],
            ],
        ];
        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        $data['snap_token'] = $snapToken;

        $transaction->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Edited Successfully',
            'data' => new TransactionResource($transaction)
        ]);
    }

    public function updateshipping(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'resi' => 'nullable|string|max:255',
            'shipping_status' => 'required'
        ]);

        // Stock Restore
        if ($data['shipping_status'] == 4) {
            foreach ($transaction->transactionDetails as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update([
                    'stock' => $product->stock + $item['quantity']
                ]);
            }
        }

        $transaction->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Shipping Transaction Edited Successfully',
            'data' => new TransactionResource($transaction)
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Deleted Successfully'
        ]);
    }
}

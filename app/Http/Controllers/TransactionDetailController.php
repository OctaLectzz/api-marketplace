<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Resources\TransactionDetailResource;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $transactiondetails = TransactionDetail::latest()->get();

        return TransactionDetailResource::collection($transactiondetails);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'product_id' => 'required|integer|exists:products,id',
            'price' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $transactiondetail = TransactionDetail::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Detail Created Successfully',
            'data' => new TransactionDetailResource($transactiondetail)
        ]);
    }

    public function show(TransactionDetail $transactiondetail)
    {
        return response()->json([
            'data' => new TransactionDetailResource($transactiondetail)
        ]);
    }

    public function update(Request $request, TransactionDetail $transactiondetail)
    {
        $data = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'product_id' => 'required|integer|exists:products,id',
            'price' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $transactiondetail->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Detail Edited Successfully',
            'data' => new TransactionDetailResource($transactiondetail)
        ]);
    }

    public function destroy(TransactionDetail $transactiondetail)
    {
        $transactiondetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Detail Deleted Successfully'
        ]);
    }
}

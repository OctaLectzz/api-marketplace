<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TransactionResource;

class SettingController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'Admin') {
            // Counts
            $users = User::count();
            $categories = Category::count();
            $products = Product::count();
            $transactions = Transaction::count();

            // Transactions
            $transactionAll = Transaction::latest()->get();
            $transactionNotyetpaids = Transaction::where('shipping_status', 0)->count();
            $transactionPackageds = Transaction::where('shipping_status', 1)->count();
            $transactionSents = Transaction::where('shipping_status', 2)->count();
            $transactionFinisheds = Transaction::where('shipping_status', 3)->count();
            $transactionCanceleds = Transaction::where('shipping_status', 4)->count();

            // Monthly Transactions
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlyTotals = array_fill(0, 12, 0);
            $transactionsPerMonth = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')->groupBy('month')->whereNotIn('shipping_status', [0, 4])->get();
            foreach ($transactionsPerMonth as $transaction) {
                $monthIndex = $transaction->month - 1;
                $monthlyTotals[$monthIndex] = $transaction->total;
            }
        } else {
            // Counts
            $users = User::count();
            $categories = Category::count();
            $products = Product::where('user_id', auth()->id())->count();
            $transactions = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->count();

            // Transactions
            $transactionAll = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get();
            $transactionNotyetpaids = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('shipping_status', 0)->count();
            $transactionPackageds = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('shipping_status', 1)->count();
            $transactionSents = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('shipping_status', 2)->count();
            $transactionFinisheds = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('shipping_status', 3)->count();
            $transactionCanceleds = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('shipping_status', 4)->count();

            // Monthly Transactions
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlyTotals = array_fill(0, 12, 0);
            $transactionsPerMonth = Transaction::whereHas('transactionDetails.product', function ($query) {
                $query->where('user_id', auth()->id());
            })->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')->groupBy('month')->whereNotIn('shipping_status', [0, 4])->get();
            foreach ($transactionsPerMonth as $transaction) {
                $monthIndex = $transaction->month - 1;
                $monthlyTotals[$monthIndex] = $transaction->total;
            }
        }

        return response()->json([
            'userlength' => $users,
            'categorylength' => $categories,
            'productlength' => $products,
            'transactionlength' => $transactions,
            'transactionAll' => TransactionResource::collection($transactionAll),
            'transactionNotyetpaids' => $transactionNotyetpaids,
            'transactionPackageds' => $transactionPackageds,
            'transactionSents' => $transactionSents,
            'transactionFinisheds' => $transactionFinisheds,
            'transactionCanceleds' => $transactionCanceleds,
            'months' => $months,
            'transactionMonthly' => $monthlyTotals
        ]);
    }

    public function show()
    {
        $setting = Setting::first();

        return response()->json([
            'data' => new SettingResource($setting)
        ]);
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->validate([
            'version' => 'required|numeric',
            'terms' => 'required',
            'tutorial' => 'required',
            'privacy_policy' => 'required'
        ], [
            'version.numeric' => 'Versi harus berupa angka'
        ]);

        $setting->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Setting Edited Successfully',
            'data' => new SettingResource($setting)
        ]);
    }
}

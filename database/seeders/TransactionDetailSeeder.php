<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionDetail::create([
            'transaction_id' => 1,
            'product_id' => 2,
            'price' => 11999000,
            'quantity' => 2,
            'created_at' => '2024-03-27 15:07:58',
            'updated_at' => '2024-03-27 15:07:58'
        ]);
        TransactionDetail::create([
            'transaction_id' => 1,
            'product_id' => 3,
            'price' => 2190000,
            'quantity' => 1,
            'created_at' => '2024-03-27 15:07:58',
            'updated_at' => '2024-03-27 15:07:58'
        ]);
        TransactionDetail::create([
            'transaction_id' => 2,
            'product_id' => 1,
            'price' => 400000,
            'quantity' => 1,
            'created_at' => '2024-03-15 12:20:12',
            'updated_at' => '2024-03-15 12:20:12'
        ]);
        TransactionDetail::create([
            'transaction_id' => 3,
            'product_id' => 2,
            'price' => 11999000,
            'quantity' => 1,
            'created_at' => '2024-04-18 15:07:58',
            'updated_at' => '2024-04-18 15:07:58'
        ]);
        TransactionDetail::create([
            'transaction_id' => 4,
            'product_id' => 1,
            'price' => 400000,
            'quantity' => 3,
            'created_at' => '2024-05-30 17:54:14',
            'updated_at' => '2024-05-30 17:54:14'
        ]);
        TransactionDetail::create([
            'transaction_id' => 4,
            'product_id' => 2,
            'price' => 11999000,
            'quantity' => 1,
            'created_at' => '2024-05-30 17:54:14',
            'updated_at' => '2024-05-30 17:54:14'
        ]);
    }
}

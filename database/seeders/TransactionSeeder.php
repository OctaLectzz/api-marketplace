<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'invoice' => 'INV-20240327150758-00001',
            'user_id' => 5,
            'product_price' => 26188000,
            'shipping_price' => 38000,
            'total_price' => 26226000,
            'courier' => 'JNE REG',
            'shipping_estimation' => '1-2',
            'shipping_description' => 'Layanan Reguler',
            'snap_token' => 'ff85a143-add7-4d5f-953f-e190a6652561',
            'shipping_status' => 3,
            'created_at' => '2024-03-27 15:07:58',
            'updated_at' => '2024-03-27 15:07:58'
        ]);
        Transaction::create([
            'invoice' => 'INV-20240315122012-00002',
            'user_id' => 5,
            'product_price' => 400000,
            'shipping_price' => 40500,
            'total_price' => 440500,
            'courier' => 'POS Pos Reguler',
            'shipping_estimation' => '8 HARI',
            'shipping_description' => 'Pos Reguler',
            'snap_token' => '34855d4d-fcd0-454d-81e6-7f4fb6493212',
            'shipping_status' => 2,
            'created_at' => '2024-03-15 12:20:12',
            'updated_at' => '2024-03-15 12:20:12'
        ]);
        Transaction::create([
            'invoice' => 'INV-20240530174452-00003',
            'user_id' => 7,
            'product_price' => 11999000,
            'shipping_price' => 265000,
            'total_price' => 12264000,
            'courier' => 'POS Pos Kargo',
            'shipping_estimation' => '9 HARI',
            'shipping_description' => 'Pos Kargo',
            'snap_token' => '49af9fae-4051-41ec-9de3-9168bef8893b',
            'shipping_status' => 1,
            'created_at' => '2024-04-18 15:07:58',
            'updated_at' => '2024-04-18 15:07:58'
        ]);
        Transaction::create([
            'invoice' => 'INV-20240530175414-00004',
            'user_id' => 10,
            'product_price' => 13199000,
            'shipping_price' => 34000,
            'total_price' => 13233000,
            'courier' => 'JNE OKE',
            'shipping_estimation' => '2-3',
            'shipping_description' => 'Ongkos Kirim Ekonomis',
            'snap_token' => '748f6d49-0b86-4dfa-af9d-668b34efe708',
            'shipping_status' => 2,
            'created_at' => '2024-05-30 17:54:14',
            'updated_at' => '2024-05-30 17:54:14'
        ]);
    }
}

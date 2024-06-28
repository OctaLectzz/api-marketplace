<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'slug' => 'nike-air-jordan-panda',
            'name' => 'Nike Air Jordan Panda',
            'user_id' => 1,
            'weight' => 50,
            'stock' => 50,
            'price' => 400000,
            'description' => "Brand New
            Verified & Authentic
            Women's sizing
            Processing time of 5-10 business days
            SKU:DC0774-101",
            'category_id' => 7
        ]);
        Product::create([
            'slug' => 'iphone-12-pro-max',
            'name' => 'iPhone 12 Pro Max',
            'user_id' => 1,
            'weight' => 30,
            'stock' => 21,
            'price' => 11999000,
            'description' => "Seperti saudaranya yang lain, desain iPhone 12 Pro Max mempunyai sentuhan nostalgia tapi juga modern. Hal itu karena bingkai handphone yang terinspirasi dari iPhone 4 yang memberikan sentuhan klasik ke handphone baru ini. Selain bingkai, iPhone 12 Pro juga mempunyai Ceramic Shield untuk layarnya, sehingga layarnya lebih kokoh dan tahan banting.

            Tapi tentu saja, masih ada perbedaan di antara iPhone 12 Pro Max dan iPhone 12 lainnya!

            Perbedaan pertama adalah ukuran dan kualitas layar iPhone 12 Pro Max. iPhone 12 Pro Max mempunyai layar OLED sebesar 6.7 inci. Ukurannya cukup besar, bahkan lebih besar daripada handphone lain seperti Samsung Galaxy Note 20 Ultra.

            Kualitas layar milik iPhone 12 Pro Max juga mendapat upgrade dari Apple. Layar handphone yang harus dipegang dengan dua tangan ini sangat cerah, warna yang jelas, dan kita bisa menonton video HDR dengan baik. Handphone ini juga dilengkapi dengan stereo yang akan menemani kamu saat menonton video atau mendengarkan musik.",
            'category_id' => 5
        ]);
        Product::create([
            'slug' => 'apple-airpods-gen-2',
            'name' => 'Apple Airpods Gen 2',
            'user_id' => 1,
            'weight' => 10,
            'stock' => 109,
            'price' => 2190000,
            'description' => "Selamat datang di Gemini Acc Official Shop.
            Store Aksesoris Premium Terlengkap di Indonesia 🥳

            Mohon Baca deskripsi produk kami terlebih dahulu, agar tidak terjadi kesalahan dalam pengiriman.

            Ketentuan Pembelian Aksesoris di toko kami:
            ✅ Mohon tanyakan Ketersediaan Stok terlebih dahulu sebelum pembayaran.
            ✅ Pastikan varian dan tipe yang dipilih Sudah sesuai dengan yang diinginkan.
            ✅ Lakukan Perekaman Saat Unboxing Paket, sebagai bukti Klaim Komplain
            ✅ Agar pengiriman lebih aman dan tidak rusak, Sangat kami anjurkan tambahkan Kotak kardus saat pemesanan, agar kita packing dengan kardus.

            Apple Airpods Gen 2 Original Garansi Resmi

            Spesifikasi :
            Connections: Bluetooth
            Charging Case: Lightning connector
            Power and Battery AirPods with Charging Case: more than 24 hours of listening time
            Dual optical sensors
            Speech-detecting accelerometer
            Unit Utama

            Didukung Chip Apple H1 koneksi 2x lebih cepat dan latensi 30% lebih rendah
            Mendukung pengisian daya secara nirkabel di charger nirkabel bersertifikat Qi
            Indikator LED memberi tahu AirPods sedang diisi daya
            Bisa menggunakan Port Lightning untuk mengisi daya baterai
            Daya tahan baterai hingga 5 jam

            Sistem packing :
            Produk akan dicek terlebih dahulu sebelum di packing dan akan di packing dengan menggunakan bubble wrap.
            Direkomendasikan untuk menambahakan varian extra bubble + dus untuk memastikan produk sampai tujuan dengan aman

            TERIMAKASIH
            HAPPY SHOPPING ^^",
            'category_id' => 5
        ]);
    }
}

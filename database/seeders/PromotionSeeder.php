<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
            'banner' => 'IMG_Promotion1717059134-66583e3ef31d9.png',
            'url' => 'http://localhost:9000/product/iphone-12-pro-max'
        ]);
        Promotion::create([
            'banner' => 'IMG_Promotion1717059155-66583e536a4ff.webp',
            'url' => 'http://localhost:9000/product/apple-airpods-gen-2'
        ]);
        Promotion::create([
            'banner' => 'IMG_Promotion1717058225-66583ab116efe.jpg',
            'url' => 'http://localhost:9000/product/nike-air-jordan-panda'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ProductGalery;
use Illuminate\Database\Seeder;

class ProductGalerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductGalery::create([
            'product_id' => 1,
            'photo' => 'IMG_Product1716054279-6648e907d50eb.webp'
        ]);
        ProductGalery::create([
            'product_id' => 1,
            'photo' => 'IMG_Product1716054279-6648e907deccb.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 1,
            'photo' => 'IMG_Product1716054279-6648e907e0a1c.webp'
        ]);

        ProductGalery::create([
            'product_id' => 2,
            'photo' => 'IMG_Product1716054941-6648eb9d572b7.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 2,
            'photo' => 'IMG_Product1716054941-6648eb9d624e4.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 2,
            'photo' => 'IMG_Product1716054941-6648eb9d63b51.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 2,
            'photo' => 'IMG_Product1716054941-6648eb9d65675.webp'
        ]);
        ProductGalery::create([
            'product_id' => 2,
            'photo' => 'IMG_Product1716054941-6648eb9d67102.jpg'
        ]);

        ProductGalery::create([
            'product_id' => 3,
            'photo' => 'IMG_Product1716055246-6648ecce88c51.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 3,
            'photo' => 'IMG_Product1716055246-6648ecce9235c.jpg'
        ]);
        ProductGalery::create([
            'product_id' => 3,
            'photo' => 'IMG_Product1716055246-6648ecce93f9c.jpg'
        ]);
    }
}

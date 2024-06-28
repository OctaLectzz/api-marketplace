<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Sport',
            'slug' => 'sport',
            'icon' => 'sports_tennis'
        ]);
        Category::create([
            'name' => 'Electronic',
            'slug' => 'electronic',
            'icon' => 'cable'
        ]);
        Category::create([
            'name' => 'Beautiful',
            'slug' => 'beautiful',
            'icon' => 'woman'
        ]);
        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'icon' => 'accessibility_new'
        ]);
        Category::create([
            'name' => 'Gadget',
            'slug' => 'gadget',
            'icon' => 'phone_android'
        ]);
        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'icon' => 'bed'
        ]);
        Category::create([
            'name' => 'Sneaker',
            'slug' => 'sneaker',
            'icon' => 'do_not_step'
        ]);
        Category::create([
            'name' => 'Tools',
            'slug' => 'tools',
            'icon' => 'construction'
        ]);
        Category::create([
            'name' => 'Baby',
            'slug' => 'baby',
            'icon' => 'child_care'
        ]);
    }
}

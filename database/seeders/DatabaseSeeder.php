<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndoRegionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductGalerySeeder::class,
            PromotionSeeder::class,
            CartSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            SettingSeeder::class
        ]);
    }
}

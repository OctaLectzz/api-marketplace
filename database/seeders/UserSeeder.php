<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'avatar' => '1716963804-adminn.png',
            'username' => 'adminn',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'province_id' => 6,
            'regency_id' => 23,
            // 'district_id' => 3275040,
            // 'village_id' => 1101010007,
            'address_one' => 'Karangasem, Laweyan, Surakarta City',
            'country' => 'Indonesia',
            'zip_code' => 51544
        ]);
        User::factory()->create([
            'avatar' => '1716963804-adminn.png',
            'username' => 'racekkaaa',
            'name' => 'Muhammad Racka Virgian Arifai',
            'email' => 'octalectzz@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'province_id' => 6,
            'regency_id' => 23,
            // 'district_id' => 3275040,
            // 'village_id' => 1101010007,
            'address_one' => 'Karangasem, Laweyan, Surakarta City',
            'country' => 'Indonesia',
            'zip_code' => 51544
        ]);

        // Mitra
        User::factory()->create([
            'username' => 'mitraa',
            'name' => 'Mitra',
            'email' => 'mitra@example.com',
            'password' => bcrypt('password'),
            'role' => 'Mitra',
            'province_id' => 6,
            'regency_id' => 23,
            // 'district_id' => 3275040,
            // 'village_id' => 1101010007,
            'address_one' => 'Karangasem, Laweyan, Surakarta City',
            'country' => 'Indonesia',
            'zip_code' => 51544
        ]);
        User::factory()->create([
            'username' => 'fadboy',
            'name' => 'Fadly Rizky Maulana',
            'email' => 'fadlu07@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Mitra',
            'province_id' => 6,
            'regency_id' => 23,
            // 'district_id' => 3275040,
            // 'village_id' => 1101010007,
            'address_one' => 'Karangasem, Laweyan, Surakarta City',
            'country' => 'Indonesia',
            'zip_code' => 51544
        ]);

        // Customer
        User::factory()->create([
            'avatar' => '1716385450-octalectzz.jpg',
            'username' => 'octalectzz',
            'name' => 'Octavyan Putra Ramadhan',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'Customer',
            'phone_number' => '089690220404',
            'province_id' => 10,
            'regency_id' => 118,
            // 'district_id' => 1810060,
            // 'village_id' => 1803130019,
            'country' => 'Indonesia',
            'zip_code' => 57514,
            'address_one' => 'Jl.Seta No.32, Larangan RT4/RW4 Gayam Sukoharjo',
            'address_two' => 'Ketoprak Jakarta'
        ]);
        User::factory(10)->create();
    }
}

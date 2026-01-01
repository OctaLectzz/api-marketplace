<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class IndoRegionProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = Http::withOptions(['verify' => false])
            ->withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
            ->get('https://rajaongkir.komerce.id/api/v1/destination/province')->json()['data'];

        foreach ($provinces as $province) {
            Province::create([
                'id'        => $province['id'],
                'name'        => $province['name'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}

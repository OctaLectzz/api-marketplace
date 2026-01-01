<?php

namespace Database\Seeders;

use App\Models\Regency;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class IndoRegionRegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = Province::all();

        foreach ($provinces as $province) {
            $cities = Http::withOptions(['verify' => false,])
                ->withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
                ->get('https://rajaongkir.komerce.id/api/v1/destination/city/' . $province->id)->json()['data'];

            $insert_city = [];

            foreach ($cities as $city) {

                $data = [
                    'id'          => $city['id'],
                    'province_id'   => $province->id,
                    'type'          => $city['name'],
                    'name'          => $city['name'],
                    'postal_code'   => $city['zip_code'] ?? null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];

                $insert_city[] = $data;
            }

            $insert_city = collect($insert_city);

            $city_chunks = $insert_city->chunk(100);

            foreach ($city_chunks as $chunk) {
                Regency::insert($chunk->toArray());
            }
        }
    }
}

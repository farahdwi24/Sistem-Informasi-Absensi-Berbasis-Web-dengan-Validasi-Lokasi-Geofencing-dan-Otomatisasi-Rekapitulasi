<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::query()->delete();
        
        Location::create([
            'nama_lokasi' => 'Kantor Induk UPTD Puskesmas Soropia',
            'latitude' => -3.98765,
            'longitude' => 122.61234,
            'radius_meter' => 50,
        ]);

        Location::create([
            'nama_lokasi' => 'Pustu Toronipa',
            'latitude' => -3.98111,
            'longitude' => 122.62222,
            'radius_meter' => 50,
        ]);

        Location::create([
            'nama_lokasi' => 'Pustu Tapulaga',
            'latitude' => -3.97333, 
            'longitude' => 122.63333,
            'radius_meter' => 50,
        ]);
    }
}

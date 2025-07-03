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
        $locations = [
            [
                'name' => 'Dojo Pusat Jember',
                'code' => 'JMB001',
                'address' => 'Jl. Gajah Mada No. 123, Jember, Jawa Timur',
                'phone' => '0331-123456',
                'capacity' => 50,
                'facilities' => 'Ruang latihan utama, ruang ganti, toilet, parkir luas',
                'latitude' => -8.1689,
                'longitude' => 113.7006,
                'is_active' => true,
            ],
            [
                'name' => 'Dojo Cabang Sumbersari',
                'code' => 'JMB002',
                'address' => 'Jl. Raya Sumbersari No. 45, Jember, Jawa Timur',
                'phone' => '0331-234567',
                'capacity' => 30,
                'facilities' => 'Ruang latihan, ruang ganti, toilet',
                'latitude' => -8.1598,
                'longitude' => 113.7217,
                'is_active' => true,
            ],
            [
                'name' => 'Dojo Cabang Kaliwates',
                'code' => 'JMB003',
                'address' => 'Jl. Kaliwates Raya No. 78, Jember, Jawa Timur',
                'phone' => '0331-345678',
                'capacity' => 25,
                'facilities' => 'Ruang latihan, toilet, parkir terbatas',
                'latitude' => -8.1844,
                'longitude' => 113.6926,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}

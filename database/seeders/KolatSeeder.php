<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KolatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kolats = [
            [
                'name' => 'Kolat Pusat Jember',
                'address' => 'Jl. Gajah Mada No. 123, Jember',
                'schedule_day' => 'Senin',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat pusat di Jember dengan fasilitas lengkap',
                'is_active' => true,
            ],
            [
                'name' => 'Kolat Kaliwates',
                'address' => 'Jl. Sudarman No. 45, Kaliwates, Jember',
                'schedule_day' => 'Rabu',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Kaliwates',
                'is_active' => true,
            ],
            [
                'name' => 'Kolat Sumbersari',
                'address' => 'Jl. Kalimantan No. 67, Sumbersari, Jember',
                'schedule_day' => 'Jumat',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di daerah Sumbersari',
                'is_active' => true,
            ],
        ];

        foreach ($kolats as $kolat) {
            DB::table('kolats')->updateOrInsert(
                ['name' => $kolat['name']], // Condition
                array_merge($kolat, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}

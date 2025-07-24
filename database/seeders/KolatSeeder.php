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
                'name' => 'UNEJ',
                'address' => 'Universitas Jember, Jl. Kalimantan No.37, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Senin',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di lingkungan Universitas Jember',
                'is_active' => true,
            ],
            [
                'name' => 'POLIJE',
                'address' => 'Politeknik Negeri Jember, Jl. Mastrip No.164, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Selasa',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di lingkungan Politeknik Negeri Jember',
                'is_active' => true,
            ],
            [
                'name' => 'TEGAL BESAR',
                'address' => 'Tegal Besar, Kec. Kaliwates, Kabupaten Jember',
                'schedule_day' => 'Rabu',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Tegal Besar',
                'is_active' => true,
            ],
            [
                'name' => 'PONDOK GEDE',
                'address' => 'Pondok Gede, Kec. Kaliwates, Kabupaten Jember',
                'schedule_day' => 'Kamis',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di daerah Pondok Gede',
                'is_active' => true,
            ],
            [
                'name' => 'KALIGA',
                'address' => 'Kaliwates Kidul, Kec. Kaliwates, Kabupaten Jember',
                'schedule_day' => 'Jumat',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di daerah Kaliwates Kidul (Kaliga)',
                'is_active' => true,
            ],
            [
                'name' => 'BSG',
                'address' => 'Bintoro Sari Gading, Kec. Patrang, Kabupaten Jember',
                'schedule_day' => 'Sabtu',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di daerah Bintoro Sari Gading',
                'is_active' => true,
            ],
            [
                'name' => 'TANGGUL RAYA',
                'address' => 'Tanggul, Kec. Tanggul, Kabupaten Jember',
                'schedule_day' => 'Minggu',
                'schedule_time' => '19:00:00',
                'description' => 'Kolat di daerah Tanggul Raya',
                'is_active' => true,
            ],
            [
                'name' => 'SMASA',
                'address' => 'SMA Negeri 1 Jember, Jl. Hayam Wuruk No.1, Tegal Boto Lor, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Senin',
                'schedule_time' => '20:00:00',
                'description' => 'Kolat di lingkungan SMA Negeri 1 Jember',
                'is_active' => true,
            ],
            [
                'name' => 'SMK 6',
                'address' => 'SMK Negeri 6 Jember, Jl. Brawijaya No.2, Tegal Boto Lor, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Selasa',
                'schedule_time' => '20:00:00',
                'description' => 'Kolat di lingkungan SMK Negeri 6 Jember',
                'is_active' => true,
            ],
            [
                'name' => 'MATASA',
                'address' => 'MAN 2 Jember, Jl. Manggis No.4, Tegal Boto Lor, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Rabu',
                'schedule_time' => '20:00:00',
                'description' => 'Kolat di lingkungan MAN 2 Jember (Matasa)',
                'is_active' => true,
            ],
            [
                'name' => 'ROLASI',
                'address' => 'Rowosari, Kec. Sumberjambe, Kabupaten Jember',
                'schedule_day' => 'Kamis',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Rowosari (Rolasi)',
                'is_active' => true,
            ],
            [
                'name' => 'SUMSAGA',
                'address' => 'Sumbersari Gading, Kec. Sumbersari, Kabupaten Jember',
                'schedule_day' => 'Jumat',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Sumbersari Gading',
                'is_active' => true,
            ],
            [
                'name' => 'TANGGUL WETAN',
                'address' => 'Tanggul Wetan, Kec. Tanggul, Kabupaten Jember',
                'schedule_day' => 'Sabtu',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Tanggul Wetan',
                'is_active' => true,
            ],
            [
                'name' => 'B1-B2',
                'address' => 'Pusat Latihan Tingkat Lanjut, Jl. Gajah Mada No.123, Kaliwates, Kabupaten Jember',
                'schedule_day' => 'Minggu',
                'schedule_time' => '08:00:00',
                'description' => 'Kolat khusus untuk tingkat B1 dan B2',
                'is_active' => true,
            ],
            [
                'name' => 'ARJASA',
                'address' => 'Arjasa, Kec. Arjasa, Kabupaten Jember',
                'schedule_day' => 'Senin',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Arjasa',
                'is_active' => true,
            ],
            [
                'name' => 'AJUNG',
                'address' => 'Ajung, Kec. Ajung, Kabupaten Jember',
                'schedule_day' => 'Selasa',
                'schedule_time' => '19:30:00',
                'description' => 'Kolat di daerah Ajung',
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

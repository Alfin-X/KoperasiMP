<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TingkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tingkatans = [
            ['name' => 'Calon Anggota', 'code' => 'CA', 'level' => 1],
            ['name' => 'Dasar 1', 'code' => 'D1', 'level' => 2],
            ['name' => 'Dasar 2', 'code' => 'D2', 'level' => 3],
            ['name' => 'Balik 1', 'code' => 'B1', 'level' => 4],
            ['name' => 'Balik 2', 'code' => 'B2', 'level' => 5],
            ['name' => 'Kombinasi 1', 'code' => 'Kom1', 'level' => 6],
            ['name' => 'Kombinasi 2', 'code' => 'Kom2', 'level' => 7],
            ['name' => 'Khusus 1', 'code' => 'K1', 'level' => 8],
            ['name' => 'Khusus 2', 'code' => 'K2', 'level' => 9],
            ['name' => 'Khusus 3', 'code' => 'K3', 'level' => 10],
            ['name' => 'Kesegaran', 'code' => 'Kesegaran', 'level' => 11],
            ['name' => 'Inti 1', 'code' => 'Inti 1', 'level' => 12],
            ['name' => 'Inti 2', 'code' => 'Inti 2', 'level' => 13],
        ];

        foreach ($tingkatans as $tingkatan) {
            \App\Models\Tingkatan::updateOrCreate(
                ['code' => $tingkatan['code']], // Condition
                array_merge($tingkatan, [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Sabuk Putih',
                'color' => 'Putih',
                'order' => 1,
                'requirements' => 'Tingkatan pemula untuk anggota baru',
                'min_training_hours' => 0,
                'min_months' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Sabuk Kuning',
                'color' => 'Kuning',
                'order' => 2,
                'requirements' => 'Menguasai gerakan dasar, minimal 3 bulan latihan',
                'min_training_hours' => 48,
                'min_months' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Sabuk Hijau',
                'color' => 'Hijau',
                'order' => 3,
                'requirements' => 'Menguasai jurus tingkat menengah, minimal 6 bulan dari kuning',
                'min_training_hours' => 96,
                'min_months' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Sabuk Biru',
                'color' => 'Biru',
                'order' => 4,
                'requirements' => 'Menguasai teknik lanjutan, minimal 8 bulan dari hijau',
                'min_training_hours' => 128,
                'min_months' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Sabuk Coklat',
                'color' => 'Coklat',
                'order' => 5,
                'requirements' => 'Menguasai teknik tingkat tinggi, minimal 12 bulan dari biru',
                'min_training_hours' => 192,
                'min_months' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Sabuk Hitam',
                'color' => 'Hitam',
                'order' => 6,
                'requirements' => 'Menguasai seluruh teknik, minimal 18 bulan dari coklat',
                'min_training_hours' => 288,
                'min_months' => 18,
                'is_active' => true,
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}

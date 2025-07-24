<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get role IDs
        $anggotaRole = \App\Models\Role::where('name', 'anggota')->first();
        $pelatihRole = \App\Models\Role::where('name', 'pelatih')->first();

        // Get tingkatan mapping
        $tingkatanMap = \App\Models\Tingkatan::pluck('id', 'code')->toArray();

        // Get kolat mapping - create kolats if they don't exist
        $kolatNames = [
            'UNEJ', 'POLIJE', 'TEGAL BESAR', 'PONDOK GEDE', 'KALIGA', 'BSG',
            'TANGGUL RAYA', 'SMASA', 'SMK 6', 'MATASA', 'ROLASI', 'SUMSAGA',
            'TANGGUL WETAN', 'B1-B2', 'ARJASA', 'AJUNG'
        ];

        $kolatMap = [];
        foreach ($kolatNames as $kolatName) {
            $kolat = \App\Models\Kolat::firstOrCreate(
                ['name' => $kolatName],
                [
                    'address' => 'Alamat ' . $kolatName,
                    'schedule_day' => 'Senin',
                    'schedule_time' => '19:00:00',
                    'description' => 'Kolat ' . $kolatName,
                    'is_active' => true,
                ]
            );
            $kolatMap[$kolatName] = $kolat->id;
        }

        // Load data dari file terpisah
        $csvData = include __DIR__ . '/user_data.php';

        foreach ($csvData as $userData) {
            [$name, $tingkatanCode, $status, $kolatName, $email, $password] = $userData;

            // Tentukan role berdasarkan status
            $roleId = $status === 'PELATIH' ? $pelatihRole->id : $anggotaRole->id;

            // Dapatkan tingkatan_id
            $tingkatanId = $tingkatanMap[$tingkatanCode] ?? null;

            // Dapatkan kolat_id - handle multiple kolats untuk pelatih
            $kolatId = null;
            if (strpos($kolatName, ',') !== false) {
                // Jika ada multiple kolat, ambil yang pertama
                $firstKolat = trim(explode(',', $kolatName)[0]);
                $kolatId = $kolatMap[$firstKolat] ?? null;
            } else {
                $kolatId = $kolatMap[$kolatName] ?? null;
            }

            // Create user
            \App\Models\User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => \Hash::make($password),
                    'role_id' => $roleId,
                    'kolat_id' => $kolatId,
                    'tingkatan_id' => $tingkatanId,
                    'tingkatan' => $tingkatanCode, // Keep old field for compatibility
                    'member_id' => 'MP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'join_date' => now(),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}

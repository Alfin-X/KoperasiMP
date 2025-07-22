<?php

namespace Database\Seeders;

use App\Models\Savings;
use App\Models\SavingsTransaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil beberapa anggota untuk test data
        $anggota = User::where('role_id', 3)->take(5)->get();

        foreach ($anggota as $user) {
            // Buat record simpanan jika belum ada
            $savings = Savings::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'simpanan_pokok' => 50000,
                    'simpanan_wajib' => rand(10000, 50000),
                    'simpanan_sukarela' => rand(0, 100000),
                    'total_balance' => 0,
                    'simpanan_pokok_paid' => true
                ]
            );

            // Hitung total balance
            $savings->total_balance = $savings->simpanan_pokok + $savings->simpanan_wajib + $savings->simpanan_sukarela;
            $savings->save();

            // Buat beberapa transaksi verified jika belum ada
            if (!SavingsTransaction::where('user_id', $user->id)->where('type', 'simpanan_pokok')->exists()) {
                SavingsTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'simpanan_pokok',
                    'amount' => 50000,
                    'description' => 'Setoran simpanan pokok',
                    'status' => 'verified',
                    'recorded_by' => $user->id,
                    'verified_by' => 1, // Admin
                    'verified_at' => now()->subDays(rand(1, 30))
                ]);
            }

            if (SavingsTransaction::where('user_id', $user->id)->where('type', 'simpanan_wajib')->count() < 2) {
                SavingsTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'simpanan_wajib',
                    'amount' => rand(3000, 10000),
                    'description' => 'Setoran simpanan wajib',
                    'status' => 'verified',
                    'recorded_by' => $user->id,
                    'verified_by' => 1, // Admin
                    'verified_at' => now()->subDays(rand(1, 15))
                ]);
            }

            // Buat beberapa transaksi pending
            if (rand(0, 1)) {
                SavingsTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'simpanan_sukarela',
                    'amount' => rand(5000, 25000),
                    'description' => 'Setoran simpanan sukarela',
                    'status' => 'pending',
                    'recorded_by' => $user->id,
                    'created_at' => now()->subHours(rand(1, 48))
                ]);
            }
        }

        // Buat beberapa transaksi pending tambahan
        $moreAnggota = User::where('role_id', 3)->skip(5)->take(3)->get();
        foreach ($moreAnggota as $user) {
            SavingsTransaction::create([
                'user_id' => $user->id,
                'type' => 'simpanan_pokok',
                'amount' => 50000,
                'description' => 'Setoran simpanan pokok - menunggu verifikasi',
                'status' => 'pending',
                'recorded_by' => $user->id,
                'created_at' => now()->subHours(rand(1, 24))
            ]);
        }
    }
}

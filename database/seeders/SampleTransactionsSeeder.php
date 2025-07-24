<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users for sample transactions
        $users = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'anggota');
        })->take(10)->get();

        if ($users->count() == 0) {
            echo "No anggota users found. Please run UserImportSeeder first.\n";
            return;
        }

        foreach ($users as $index => $user) {
            // Create savings record if not exists
            $savings = \App\Models\Savings::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'simpanan_pokok' => 0,
                    'simpanan_wajib' => 0,
                    'simpanan_sukarela' => 0,
                    'total_balance' => 0,
                ]
            );

            // Create sample transactions
            \App\Models\SavingsTransaction::create([
                'user_id' => $user->id,
                'type' => 'simpanan_pokok',
                'amount' => 50000,
                'description' => 'Simpanan pokok awal',
                'status' => 'pending',
                'proof_image' => null,
                'recorded_by' => null,
                'verified_by' => null,
                'verified_at' => null,
                'rejection_reason' => null,
            ]);

            \App\Models\SavingsTransaction::create([
                'user_id' => $user->id,
                'type' => 'simpanan_wajib',
                'amount' => 25000,
                'description' => 'Simpanan wajib bulan ' . now()->format('F Y'),
                'status' => 'pending',
                'proof_image' => null,
                'recorded_by' => null,
                'verified_by' => null,
                'verified_at' => null,
                'rejection_reason' => null,
            ]);

            if ($index < 3) {
                // Create some verified transactions
                \App\Models\SavingsTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'simpanan_sukarela',
                    'amount' => 100000,
                    'description' => 'Simpanan sukarela',
                    'status' => 'verified',
                    'proof_image' => null,
                    'recorded_by' => null,
                    'verified_by' => 1, // Admin
                    'verified_at' => now(),
                    'rejection_reason' => null,
                ]);
            }
        }

        echo "Created sample savings transactions for testing.\n";
    }
}

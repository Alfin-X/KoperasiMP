<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin role ID
        $adminRoleId = DB::table('roles')->where('name', 'admin')->first()->id;

        $admin = [
            'name' => 'Administrator',
            'email' => 'admin@mpjember.com',
            'phone' => '081234567890',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRoleId,
            'is_active' => true,
            'join_date' => now(),
            'email_verified_at' => now(),
        ];

        DB::table('users')->updateOrInsert(
            ['email' => $admin['email']], // Condition
            array_merge($admin, [
                'created_at' => now(),
                'updated_at' => now(),
            ])
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Administrator dengan akses penuh ke seluruh sistem SIMP',
                'permissions' => [
                    // Koperasi
                    'manage_cooperative', 'create_cooperative_member', 'manage_member_money',
                    'view_member_money', 'create_money_loan',
                    // Jual Beli
                    'manage_products', 'add_product', 'delete_product', 'edit_product', 'view_product',
                    // SPP
                    'manage_spp', 'create_spp_record', 'edit_spp_record', 'view_spp_record',
                    'receive_spp_notifications', 'create_monthly_spp_report',
                    // Absensi & User Management
                    'manage_member_accounts', 'create_member_account', 'edit_member_account',
                    'view_member_account', 'delete_member_account',
                    'manage_trainer_accounts', 'create_trainer_account', 'edit_trainer_account',
                    'view_trainer_account', 'delete_trainer_account',
                    'manage_training_locations', 'create_training_location', 'edit_training_location',
                    'view_training_location', 'delete_training_location',
                    'manage_attendance', 'create_attendance', 'edit_attendance', 'view_attendance',
                    'delete_attendance', 'create_monthly_attendance_report'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'pelatih',
                'display_name' => 'Pelatih',
                'description' => 'Pelatih dengan akses untuk mengelola anggota, absensi, dan transaksi terbatas',
                'permissions' => [
                    // Jual Beli
                    'buy_product',
                    // SPP
                    'send_spp_payment_proof', 'view_member_spp_data',
                    // Absensi & Member Management
                    'manage_member_accounts', 'create_member_account', 'edit_member_account',
                    'view_member_account', 'delete_member_account',
                    'manage_attendance', 'create_attendance', 'edit_attendance', 'view_attendance',
                    'delete_attendance', 'create_monthly_attendance_report'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'anggota',
                'display_name' => 'Anggota',
                'description' => 'Anggota dengan akses terbatas untuk melihat data pribadi dan melakukan transaksi',
                'permissions' => [
                    // Koperasi
                    'view_cooperative_money', 'pay_cooperative_savings',
                    // Jual Beli
                    'buy_product', 'view_product',
                    // SPP
                    'view_own_spp_status'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

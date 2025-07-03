<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles and locations
        $adminRole = Role::where('name', 'admin')->first();
        $pelatihRole = Role::where('name', 'pelatih')->first();

        $pusatLocation = Location::where('code', 'JMB001')->first();
        $sumbersariLocation = Location::where('code', 'JMB002')->first();

        // Create Admin Pusat
        User::create([
            'name' => 'Administrator Pusat',
            'email' => 'admin@mpjember.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'location_id' => $pusatLocation->id,
            'phone' => '081234567890',
            'gender' => 'male',
            'address' => 'Jember, Jawa Timur',
            'is_active' => true,
        ]);

        // Create Admin Cabang
        User::create([
            'name' => 'Admin Cabang Sumbersari',
            'email' => 'admin.sumbersari@mpjember.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'location_id' => $sumbersariLocation->id,
            'phone' => '081234567891',
            'gender' => 'female',
            'address' => 'Sumbersari, Jember, Jawa Timur',
            'is_active' => true,
        ]);

        // Create Pelatih
        User::create([
            'name' => 'Sensei Budi Santoso',
            'email' => 'pelatih.budi@mpjember.com',
            'password' => Hash::make('password123'),
            'role_id' => $pelatihRole->id,
            'location_id' => $pusatLocation->id,
            'phone' => '081234567892',
            'gender' => 'male',
            'address' => 'Jember, Jawa Timur',
            'is_active' => true,
        ]);
    }
}

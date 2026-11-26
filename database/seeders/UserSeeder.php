<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Kelurahan
        $admin = User::firstOrCreate(
            ['email' => 'admin@putajaya.go.id'],
            [
                'name' => 'Admin Kelurahan Putat Jaya',
                'phone' => '081234567890',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');

        // Pelaku UMKM
        $umkmOwners = [
            ['name' => 'Budi Santoso', 'email' => 'budi@putatjaya.test', 'phone' => '081234567801'],
            ['name' => 'Sari Wulandari', 'email' => 'sari@putatjaya.test', 'phone' => '081234567802'],
            ['name' => 'Rini Handayani', 'email' => 'rini@putatjaya.test', 'phone' => '081234567803'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@putatjaya.test', 'phone' => '081234567804'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@putatjaya.test', 'phone' => '081234567805'],
            ['name' => 'Hendra Wijaya', 'email' => 'hendra@putatjaya.test', 'phone' => '081234567806'],
            ['name' => 'Eka Prasetyo', 'email' => 'eka@putatjaya.test', 'phone' => '081234567807'],
            ['name' => 'Fitri Rahayu', 'email' => 'fitri@putatjaya.test', 'phone' => '081234567808'],
            ['name' => 'Agus Suryanto', 'email' => 'agus@putatjaya.test', 'phone' => '081234567809'],
            ['name' => 'Ani Setyaningrum', 'email' => 'ani@putatjaya.test', 'phone' => '081234567810'],
            ['name' => 'Yanto Kusuma', 'email' => 'yanto@putatjaya.test', 'phone' => '081234567811'],
            ['name' => 'Lia Permatasari', 'email' => 'lia@putatjaya.test', 'phone' => '081234567812'],
        ];

        foreach ($umkmOwners as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );
            $user->assignRole('umkm_owner');
        }
    }
}

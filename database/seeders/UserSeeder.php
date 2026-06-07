<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Membuat user dummy untuk admin, pemilik, dan penyewa.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@rentalin.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'owner@rentalin.com'],
            [
                'name' => 'Vynelle Market',
                'password' => bcrypt('password'),
                'role' => 'owner',
                'phone' => '+62 812-3333-0935',
                'address' => 'Jl. Braga, Kecamatan Sumur Bandung, Kota Bandung',
                'avatar' => 'owner-vynelle.png',
            ]
        );

        User::firstOrCreate(
            ['email' => 'tenant@rentalin.com'],
            [
                'name' => 'Nugra Hashattan',
                'password' => bcrypt('password'),
                'role' => 'tenant',
                'phone' => '+62 812-8888-1234',
                'address' => 'Bandung, Jawa Barat',
                'avatar' => 'profile-tenant.png',
            ]
        );

        User::firstOrCreate(
            ['email' => 'tariq@rentalin.com'],
            [
                'name' => 'Tariq Halilintar',
                'password' => bcrypt('password'),
                'role' => 'tenant',
                'phone' => '+62 812-1111-2222',
                'address' => 'Jakarta',
                'avatar' => 'profile-tariq.png',
            ]
        );

        User::firstOrCreate(
            ['email' => 'muh.zaidan.rahman@upi.edu'],
            [
                'name' => 'Tariq Halilintar',
                'password' => bcrypt('password'),
                'role' => 'tenant',
                'phone' => '+62 812-1111-2222',
                'address' => 'Jakarta',
                'avatar' => 'profile-tariq.png',
            ]
        );
    }
}
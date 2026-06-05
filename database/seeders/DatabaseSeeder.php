<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            RentalSeeder::class,
            PaymentSeeder::class,
            DamageClaimSeeder::class,        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rentalin.com',
            'password' => bcrypt('password'),
            'role' => 'admin', 
        ]);
    }
}

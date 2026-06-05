<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\DamageClaim;
use Illuminate\Database\Seeder;

class DamageClaimSeeder extends Seeder
{
    /**
     * Membuat klaim kerusakan dummy untuk rental dengan status kerusakan.
     */
    public function run(): void
    {
        $damageRentals = Rental::where('status', 'kerusakan')->get();

        foreach ($damageRentals as $rental) {
            DamageClaim::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'damage_type' => 'Kerusakan Fisik',
                    'damage_part' => 'Body Barang',
                    'description' => $rental->damage_description ?? 'Barang mengalami kerusakan setelah dikembalikan.',
                    'repair_fee' => $rental->damage_fee ?? 0,
                    'status' => 'submitted',
                ]
            );
        }
    }
}